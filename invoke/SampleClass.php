<?php

class SampleClass
{
    private $_name; // 名前
    private $_age;  // 年齢
 
    public function __construct($name, $age)
    {
        $this->_name = $name;
        $this->_age  = $age;
    }

    /**
     * __invoke マジックメソッド
     */
    public function __invoke()
    {
        // 名前と年齢を結合して返す
        echo $this->_name . '(' . $this->_age . ')';
    }
}