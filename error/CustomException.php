<?php

class CustomException extends Exception{

    private $errorCode;

    public function __construct(Exception $e) {
        $this->e = $e;
    }

    public function getCustomErrorCode () {
        $this->errorCode = 'E1111';
        return $this->errorCode;
    }

    public function getCustomMessage() {
        return sprintf("%s%s", $this->e->getMessage(), $this->e->getTraceAsString());
    }
}