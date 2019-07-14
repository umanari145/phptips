<?php

$sca = new SampleClass();
$scb = new SampleClass();


$sca->staticMethod1();//1
SampleClass::staticMethod1();//2
$sca::staticMethod1();//3

$sca->instanceMethod1();//4;
$scb->instanceMethod1();//5;

//クラスからインスタンス変数はよべない　エラーになる
$sca::instanceMethod1();//4;

$sca->instanceMethod2();//1;
$scb->instanceMethod2();//1;
$sca->instanceMethod2();//2;
$scb->instanceMethod2();//2;

//静的変数なので呼べる
SampleClass::$num1;
//インスタンス変数なので呼べない
//エラーが起こる
//SampleClass::$num2;

class SampleClass
{
    //クラス・インスタンス間で共有される
    public static $num1 ;

    //特定インスタンスのみ
    public $num2;

    public static function staticMethod1()
    {
        $num = self::$num1;
        $num++;
        self::$num1 = $num;
        echo $num .PHP_EOL;

        //下記はエラーになる。staticメソッドからインスタンス変数は呼べない(クラスからインスタンスは呼べない)
        //echo $this->num2;
        //下記も当然static変数ではないので呼べない
        //echo self::$num2;

        //クラスメソッドからインスタンスメソッドはよべない エラーになる
        //$this->instanceMethod1();
    }

    public static function staticMethod2()
    {
        echo 'static method2'. PHP_EOL;
    }

    public function instanceMethod1()
    {
        //インスタンスメソッドからクラス変数は呼べる
        $num = self::$num1;
        $num++;
        self::$num1 = $num;

        echo $num .PHP_EOL;
        //下記の処理はundefinedになる $this->num1 とself::$num1は当然別物!
        //echo $this->num1 . PHP_EOL;
        echo $this->num2 . PHP_EOL;//空白

        //通常はstaticはこの呼び方
        self::staticMethod2();
        //この方法でも呼べる
        $this->staticMethod2();
    }

    public function instanceMethod2()
    {
        //インスタンスメソッドからクラス変数は呼べる(通常の使い方)
        $num = $this->num2;
        $num++;
        $this->num2 = $num;
        echo $num .PHP_EOL;
    }
}
