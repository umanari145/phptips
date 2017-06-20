<?php

$arr = [100,200,300];

$arr2 = array_reduce($arr,function ($res, $val){
    $res += $val;
    return $res;
});

var_dump($arr2); //600

$arr = [
    [
        "name" => " kazumi",
        "domain" => "gmail.com",
        "age" => "30",
        "pref" => "chiba",
        "score" => '75'
    ],
    [
        "name" => "ichirou",
        "domain" => "yahoo.co.jp",
        "age" => "18",
        "pref" => "tokyo",
        "score" => '23'
    ],
    [
        "name" => " yuusuke",
        "domain" => "hotmail.com",
        "age" => "25",
        "pref" => "chiba",
        "score" => '92'
    ],
    [
        "name" => " satoshi",
        "domain" => "gmail.com",
        "age" => "45",
        "pref" => "kanagawa",
        "score" => '17'
    ],
    [
        "name" => "jirou ",
        "domain" => "hotmail.com",
        "age" => "9",
        "pref" => "tokyo",
        "score" => '43'
    ]
];

//30才以上のスコアの取得
$arr3 = array_reduce($arr, function ($res, $val){

    if (empty($res)) $res = ['count' => 0,'score'=>0];

    if ($val['age'] >=30) {
        $res['count']++;
        $res['score'] += $val['score'];
    }
    return $res;
});
var_dump($arr3);
//array(2) {
//    'count' =>
//    int(2)
//    'score' =>
//    int(92)
//}

//年齢順にソート
usort( $arr, function ($a,$b){
    return $a['age'] - $b['age'];
});

array_map(function ($val){echo $val['name'] . " " .$val['age']. "\n";}, $arr);

//jirou  9
//ichirou 18
//yuusuke 25
//kazumi 30
//satoshi 45
