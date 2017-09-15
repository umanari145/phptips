<?php

function testFunc()
{
    static $num;
    if (empty($num)) $num = 0;
    $num++;
    echo $num . PHP_EOL;
}

testFunc(); //1
testFunc(); //2
testFunc(); //3

class Test1
{
    public static function testStatic()
    {
        static $num;
        if (empty($num)) $num = 0;
        $num++;
        echo $num . PHP_EOL;
    }

}

Test1::testStatic();//1
Test1::testStatic();//2
Test1::testStatic();//3
Test1::testStatic();//4

$t1a = new Test1();
$t1b = new Test1();

$t1a->testStatic();//5
$t1b->testStatic();//6
$t1a->testStatic();//7
$t1b->testStatic();//8

class Test2
{
    public static $num;

    public function testInstance()
    {
        if (empty(self::$num)) self::$num = 0;

        $num = self::$num;
        $num++;
        echo $num . PHP_EOL;
        self::$num = $num;
    }

}

$t2a = new Test2();
$t2b = new Test2();


$t2a->testInstance();//1
$t2b->testInstance();//2
$t2a->testInstance();//3
$t2b->testInstance();//4


class Test3
{
    public static $num;

    public function testInstance()
    {
        //selfでないのでアクセスできていない
        //$this->numは上記のstatic $numとはちがうもの
        if (empty($this->num)) $this->num = 0;

        $num = $this->num;
        $num++;
        echo $num . PHP_EOL;
        $this->num = $num;

        //下記はnull
        //var_dump(self::$num);
    }
}

$t3a = new Test3();
$t3b = new Test3();


$t3a->testInstance();//1
$t3b->testInstance();//2
$t3a->testInstance();//3
$t3b->testInstance();//4
