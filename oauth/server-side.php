<?php

require_once __DIR__ .'/../vendor/autoload.php';
 
// POSTで送られてくるトークンを取得.
$id_token = filter_input(INPUT_POST, 'idtoken');
 
$client = new Google_Client(['client_id' => 'クライエントID']);
$payload = $client->verifyIdToken($id_token);

var_dump($payload);
exit();
if ($payload) {
  $userid = $payload['sub'];
  // ユーザ登録やログイン処理など
  // 結果を出力
  echo $userid;
} else {
  // Invalid ID token
  // 結果を出力
  echo null;
}