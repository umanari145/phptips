<?php

$sca = new SampleClass();
$scb = new SampleClass();


$sca->staticMethod1();//1
SampleClass::staticMethod1();//2
$sca::staticMethod1();//3

$sca->instanceMethod1();//4;
$scb->instanceMethod1();//5;

$sca->instanceMethod2();//1;
$scb->instanceMethod2();//1;
$sca->instanceMethod2();//2;
$scb->instanceMethod2();//2;


class SampleClass
{
    //クラス・インスタンス間で共有される
    private static $num1 ;

    //特定インスタンスのみ
    private $num2;

    public static function staticMethod1(){
        $num = self::$num1;
        $num++;
        self::$num1 = $num;
        echo $num .PHP_EOL;
        //下記はエラーになる。staticメソッドからインスタンス変数は呼べない(クラスからインスタンスは呼べない)
        //echo $this->num2;
    }

    public function instanceMethod1(){
        //インスタンスメソッドからクラス変数は呼べる
        $num = self::$num1;
        $num++;
        self::$num1 = $num;

        echo $num .PHP_EOL;
        //下記の処理はundefinedになる
        //echo $this->num1 . PHP_EOL;
        echo $this->num2 . PHP_EOL;//空白
    }

    public function instanceMethod2(){
        //インスタンスメソッドからクラス変数は呼べる
        $num = $this->num2;
        $num++;
        $this->num2 = $num;
        echo $num .PHP_EOL;
    }
}