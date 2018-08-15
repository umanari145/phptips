<?php

require 'conf.php';

$post_data = [
  'name' => 'hogehoge'
];


$ch = curl_init();

curl_setopt_array($ch, [
    CURLOPT_URL => POST_URL,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HEADER => true,
    CURLOPT_POSTFIELDS => http_build_query($post_data),
]);

$response = curl_exec($ch);
$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$header = substr($response, 0, $header_size);
//response出力
var_dump($header);
//responseの形を出力
var_dump($response);

curl_close($ch);
