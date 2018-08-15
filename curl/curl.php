<?php

require 'conf.php';

$post_data = [
  'name' => 'hogehoge'
];


$ch = curl_init();

curl_setopt_array($ch, [
    CURLOPT_URL => POST_URL,
    //trueにするとcurl_exeの返り値が文字列
    CURLOPT_RETURNTRANSFER => true,
    //postメソッド
    CURLOPT_POST => true,
    //http response
    CURLOPT_HEADER => true,
    //postのデータをエンコーディングして引き渡す
    CURLOPT_POSTFIELDS => http_build_query($post_data),
]);

$response = curl_exec($ch);

//ステータスコード
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
var_dump($code);


$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$header = substr($response, 0, $header_size);
//httpヘッダー出力
var_dump($header);

//responseの形を出力
var_dump($response);

curl_close($ch);
