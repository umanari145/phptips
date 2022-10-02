<?php

/**
 * 静的遅延束縛の親クラス
 */
class ParentClass {

    public function sayHello()
    {
        // こうすると親が呼ばれる
        // self::hello(); 
        // こうすると子供が呼ばれる
        // static::hello(); 
    }

    public static function hello()
    {
        echo __CLASS__ . ' hello!';
    }
}
