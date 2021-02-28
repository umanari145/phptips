<?php
session_start();

require_once __DIR__ .'/../vendor/autoload.php';

unset($_SESSION['is_login']);

echo 'ログアウトしました。';
