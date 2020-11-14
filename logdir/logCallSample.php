<?php



require_once 'Log.php';

$log = new Log('sample');
$params = [
    'key1' => 'value1'
];
$log->debug("ログを出します。pikko", $params);



$log2 = new Log('sample2', 'sql.log');
$params = [
    'key1' => 'value1'
];
$log2->debug("ログを出します。pikko", $params);