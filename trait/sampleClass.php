<?php

require_once 'sampleTrait.php';

class sampleClass
{
    use Calculator;

    public function __construnct()
    {
    }

    public function hoge()
    {
        return 'hoge';
    }
}
