<?php

define('LOG_FILE', dirname(__FILE__) . "/error.log");

$arr = range(1, 10);

sampleFunc($arr);

function sampleFunc($arr)
{
    foreach ($arr as $a) {
        try {
            sampleErrorFunc1($a);
        } catch (Exception $e) {
            //exceptionが出たからといって処理が止まるわけではない
            error_log($e->getMessage(), 3, LOG_FILE);
            error_log("error occur", 3, LOG_FILE);
        }
    }
}

function sampleErrorFunc1($a)
{
    if ($a === 3) {
        throw new Exception('例外が発生しました。');
    } else {
        echo $a . "\n";
    }
}
