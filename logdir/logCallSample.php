<?php



require_once 'Log.php';

$log = new Log('sample', 'mail');
$params = [
    'key1' => 'value1'
];
$log->debug("ログを出します。debug", $params);
$log->info("ログを出します。info", $params);

/*
$log2 = new Log('sample2', 'sql.log');
$params = [
    'key1' => 'value1'
];
$log2->debug("ログを出します。pikko", $params);
*/