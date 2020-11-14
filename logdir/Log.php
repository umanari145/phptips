<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\RotatingFileHandler;

class Log {
    
    private $log_level;

    public function __construct($channnel, $file_name = 'debug.log', $log_level = Logger::DEBUG) {

        $this->log_level = $log_level;
        $this->loadFileStream($channnel, $file_name);
    }

    private function loadFileStream($channnel, $file_name) {
        
        $log = new Logger($channnel);

        $log_format = "[%datetime%] %level_name%:%message% %context% %extra%\n";
        $date_format = 'Y/m/d H:i:s';
        $formatter = new LineFormatter($log_format, $date_format);

        $file_path = sprintf("%s/%s", __DIR__, $file_name);
        $streamHandler = new StreamHandler($file_path, $this->log_level);

        //rotaing の数字はrotatingの日にち間隔　0で無制限
        $rotatingFileHandler = new RotatingFileHandler($file_path, 5, $this->log_level); 
        $rotatingFileHandler->setFormatter($formatter); // ログ書式

        $log->pushHandler($streamHandler);
        $log->pushHandler($rotatingFileHandler);

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