<?php
session_start();

require_once __DIR__ .'/../vendor/autoload.php';


$configFile = __DIR__ .'/config.json';

$configJson = file_get_contents($configFile);
$configArr = json_decode($configJson, true);
// POSTで送られてくるトークンを取得.
$token = $_POST['token'];

$client = new Google_Client(['client_id' => $configArr['web']['client_id']]);
$payload = $client->verifyIdToken($token);

if ($payload) {
  $_SESSION['is_login'] = true;
  $userid = $payload['sub'];
  // ユーザ登録やログイン処理など
  // 結果を出力
  echo $userid;
} else {
  // Invalid ID token
  // 結果を出力
  echo null;
}