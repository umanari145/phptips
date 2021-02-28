<?php
session_start();

require_once __DIR__ .'/../vendor/autoload.php';

use Jenssegers\Blade\Blade;

$viewPath = __DIR__ .'/template';
$cachePath = __DIR__ .'/cache';
$configFile = __DIR__ .'/config.json';

$configJson = file_get_contents($configFile);
$configArr = json_decode($configJson, true);

$blade = new Blade($viewPath, $cachePath);

$isLogin = @$_SESSION['is_login'] ?: false;

echo $blade->render('login', [
  'clientID' => $configArr['web']['client_id'],
  'isLogin' => $isLogin
]);
