<?php

require_once __DIR__ . '/../vendor/autoload.php';

$client = new Predis\Client([
    'scheme' => 'tcp',
    'host'   => 'redis',
    'port'   => 6379,
]);


// 通常のキーでの保存
$client->set('hoge', 'moge');

//配列データの取得
$arr = [
    "001" => ["name"=>"kazumi", "domain"=>"gmail.com",  "age"=>"30","pref"=>"chiba"],
    "002" => ["name"=>"ichirou","domain"=>"yahoo.co.jp", "age"=>"18","pref"=>"tokyo"],
    "003" => ["name"=>"yuusuke","domain"=>"hotmail.com", "age"=>"25","pref"=>"chiba"],
    "004" => ["name"=>"satoshi","domain"=>"gmail.com", "age"=>"45","pref"=>"kanagawa"],
    "005" => ["name"=>"jirou ",  "domain"=>"hotmail.com", "age"=>"9","pref"=>"tokyo"]
];

$arr2 = [
    "001" => ["name"=>"kiyohara", "domain"=>"gmail.com",  "age"=>"30","pref"=>"chiba"],
    "002" => ["name"=>"ochiai","domain"=>"yahoo.co.jp", "age"=>"18","pref"=>"tokyo"],
];

$arr3 = [
    "001" => ["name"=>"testaa", "domain"=>"gmail.com",  "age"=>"30","pref"=>"chiba"],
    "002" => ["name"=>"testb","domain"=>"yahoo.co.jp", "age"=>"18","pref"=>"tokyo"],
];
//保存
foreach ($arr as $userKey => $member) {
    $key = sprintf("user_data:type01:%s", $userKey);
    $memberSerialize = json_encode($member);
    $client->set($key, $memberSerialize);
    echo $key . "\n";
}

foreach ($arr2 as $userKey => $member) {
    $key = sprintf("user_data:type02:%s", $userKey);
    $memberSerialize = json_encode($member);
    $client->set($key, $memberSerialize);
    echo $key . "\n";
}

$memberSerialize = json_encode($arr3);
$client->set("user_data:type03", $memberSerialize);


//復元(keyの取得)
$keys = $client->keys("user_data:type*");

//keyから復元
$member = [];
foreach ($keys as $eachKey) {
    echo $eachKey;
    $arr = explode(":", $eachKey);
    if (isset($arr[0]) && isset($arr[1]) && isset($arr[2])) {
        $hoge = $client->get($eachKey);
        $member[$arr[0]][$arr[1]][$arr[2]] = json_decode($hoge, true);
    } elseif (isset($arr[0]) && isset($arr[1])) {
        $hoge = $client->get($eachKey);
        $member[$arr[0]][$arr[1]]= json_decode($hoge, true);
    } else {
        $hoge = $client->get($eachKey);
        $member[$arr[0]]= $hoge;
    }
}
var_dump($member);
