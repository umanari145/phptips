<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\NativeMailerHandler;

class Log {
    
    private $log_level;

    public function __construct($channnel, $outputType = 'file', $file_name = 'debug.log', $log_level = Logger::DEBUG) {
        $this->log_level = $log_level;
        $this->log_format = "[%datetime%] %level_name% %memory% %message% %trace%\n";
        $this->date_format = 'Y/m/d H:i:s';

        switch ($outputType) {
            case 'file':
               //ファイルにだす
                $this->loadFileStream($channnel, $file_name);
                break;
            case 'std':
                //ファイルにだす
                $this->loadStdStream($channnel, $log_level);
                break;
            case 'mail':
                //メールに出す
                $this->loadMailStream($channnel, $log_level);
                break;
        }
    }

    private function loadFileStream($channnel, $file_name) {
        
        $this->log = new Logger($channnel);

        //第三引数のtrueは改行を有効にする
        $formatter = new LineFormatter($this->log_format, $this->date_format, true);
        $file_path = sprintf("%s/%s", __DIR__, $file_name);
        $streamHandler = new StreamHandler($file_path, $this->log_level);

        //rotaing の数字はrotatingの日にち間隔　0で無制限
        $rotatingFileHandler = new RotatingFileHandler($file_path, 5, $this->log_level); 
        $rotatingFileHandler->setFormatter($formatter); // ログ書式

        $this->log->pushHandler($streamHandler);
        $this->log->pushHandler($rotatingFileHandler);

        $this->log->pushProcessor(array($this, 'processorCallback'));
    }

    private function loadStdStream($channnel) {
     
        $this->log = new Logger($channnel);

        $formatter = new LineFormatter($this->log_format, $this->date_format, true);
        $streamHandler = new StreamHandler("php://stdout", $this->log_level);

        $this->log->pushHandler($streamHandler);
        $this->log->pushProcessor(array($this, 'processorCallback'));
    }


    private function loadMailStream($channnel) {
     
        $this->log = new Logger($channnel);

        $to = 'umanari145@gmail.com';
        $from = 'umanari145@gmail.com';
        $formatter = new LineFormatter($this->log_format, $this->date_format, true);
        $nativeMailerHandler = new NativeMailerHandler($to, "ログ告知", $from, $this->log_level);
    
        $this->log->pushHandler($nativeMailerHandler);
        $this->log->pushProcessor(array($this, 'processorCallback'));
    }

    /**
     * callback系の処理(必ず呼び出す処理)
     */
    public function processorCallback($record)
    {
        $record['trace'] = $record['context']['trace'];
        $memorySize = (int) (memory_get_usage() / (1024 * 1024)) . "MB";
        $record['memory'] = $memorySize;
        return $record;
    }

    /**
     * info,log,warning,errorなどをマジックメソッドで呼び出す(ない場合はここにくるためinfoやerrorを呼び出せる)
     */
    public function __call($name, $args) {

        $message = $args[0];
        $params = @$args[1]?:[];
        $message = $message . " params:[". json_encode($params) . "]";

        try {
            $this->logexe($name, $message);
        } catch (Error $e) {
            //NoClassDefFoundError
            var_dump($e->getTraceAsString());
            var_dump($e->getMessage());
        }
    }
    
    public function logexe($level, $message, $params = [])
    {
        // 呼び出し元ファイルと行数の取得
        //スタックトレースの情報を全て取得できる
        $backtrace = debug_backtrace();

        $traceArr = [];
        foreach ($backtrace as $eachTrace) {
            $traceArr[] = sprintf("%s line %d", $eachTrace['file'], $eachTrace['line']);
        }
        $trace = "\n" . implode("\n", $traceArr);
        //改行されないのでぼつ
        $context = [
            'trace' => $trace
        ];
        $this->log->{$level}($message, $context);
    }

}