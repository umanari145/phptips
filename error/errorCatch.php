<?php
//画面にエラーは出さない
ini_set('display_errors', 0);
//出力えらーの定義
error_reporting(E_ALL);
//エラーが起きた時の処理
set_error_handler('my_error_handler', E_ALL);
register_shutdown_function('my_shutdown_error_handle');

function my_error_handler($errno, $errstr, $errfile, $errline)
{
    //error_logをコール
    $filePath = dirname(__FILE__) .'/debug.log';
    $log_time = date('Y-m-d H:i:s');
    $log_date = date('Y-m-d');
    $errorMsg =  sprintf("%s:%s %s(%s)", $log_time, $errstr, $errfile, $errline);
    error_log($errorMsg."\n", 3, $filePath);
};

//fatal errorのキャッチ
function my_shutdown_error_handle()
{
    $isError = false;
    $error = error_get_last();
    if ($error) {
        switch ($error['type']) {
     case E_ERROR:
     case E_PARSE:
     case E_CORE_ERROR:
     case E_CORE_WARNING:
     case E_COMPILE_ERROR:
     case E_COMPILE_WARNING:
          $isError = true;
                 break;
         }
    }
    if ($isError) {
        my_error_handler($error['type'], $error['message'], $error['file'], $error['line'], null);
    }
}

//エラーメッセージをわざと出す
echo $aaa;
//fatal errorでもキャッチ
//echo func();
