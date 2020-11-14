<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;

//チャンネル
$log = new Logger('name');

$date_format = 'Y/m/d H:i:s';
$format = "%datetime% > %level_name% > %message% %context% %extra%\n";

$formatter = new LineFormatter($format,$date_format);

$stream = new StreamHandler(__DIR__.'/debug.log', Logger::INFO);
$stream->setFormatter($formatter);
//出力先(通常ログ)
$log->pushHandler($stream);

//追加情報(現在使いどころが少し不明)
//メモリ情報などが一般的
$log->pushProcessor(function ($record) {
    $record['extra']['dummy'] = 'Hello world!';
    return $record;
});

$params = [
    'key1' => 'value'
];

//debugは出力されない
$log->debug('デバッグ', $params);
$log->warning('ワーニング ', $params);
$log->error('error', $params);