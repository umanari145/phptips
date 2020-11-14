<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\NativeMailerHandler;

class Log {
    
    private $log_level;

    public function __construct($channnel, $file_name = 'debug.log', $log_level = Logger::DEBUG) {
        $this->log_level = $log_level;
        $this->log_format = "[%datetime%] %level_name%:%message% %context% %extra%\n";
        $this->date_format = 'Y/m/d H:i:s';

        //ファイルにだす
        //$this->loadFileStream($channnel, $file_name);
        //標準出力
        //$this->loadStdStream($channnel, $log_level);
        //別の媒体(メール、DB、slack・・・)
        $this->loadMailStream($channnel, $log_level);
    }

    private function loadFileStream($channnel, $file_name) {
        
        $log = new Logger($channnel);

        $formatter = new LineFormatter($this->log_format, $this->date_format);
        $file_path = sprintf("%s/%s", __DIR__, $file_name);
        $streamHandler = new StreamHandler($file_path, $this->log_level);

        //rotaing の数字はrotatingの日にち間隔　0で無制限
        $rotatingFileHandler = new RotatingFileHandler($file_path, 5, $this->log_level); 
        $rotatingFileHandler->setFormatter($formatter); // ログ書式

        $log->pushHandler($streamHandler);
        $log->pushHandler($rotatingFileHandler);

        $this->log = $log;
    }

    private function loadStdStream($channnel, $log_level) {
     
        $log = new Logger($channnel);

        $formatter = new LineFormatter($this->log_format, $this->date_format);
        $streamHandler = new StreamHandler("php://stdout", $this->log_level);

        $log->pushHandler($streamHandler);
        $this->log = $log;
    }


    private function loadMailStream($channnel, $log_level) {
     
        $log = new Logger($channnel);

        $to = 'umanari145@gmail.com';
        $from = 'umanari145@gmail.com';
        $formatter = new LineFormatter($this->log_format, $this->date_format);
        $nativeMailerHandler = new NativeMailerHandler($to, "ログ告知", $from, $log_level);
    
        $log->pushHandler($nativeMailerHandler);
        $this->log = $log;
    }


    /**
     * info,log,warning,errorなどをマジックメソッドで呼び出す
     */
    public function __call($name, $args) {

        $message = $args[0];
        $params = @$args[1]?:[];

        try {
            $this->log->{$name}($message, $params);
        } catch(Error $e) {
            //NoClassDefFoundError
            var_dump($e->getTraceAsString());
            var_dump($e->getMessage());
        }
    }
}