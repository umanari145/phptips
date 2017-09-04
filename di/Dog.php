<?php

class Cat{
    public function meow()
    {
        echo "nya-\n";
    }
}

/**
 * 非DI
 *
 */
class Dog0{
    /**
     *
     * クラス生成が中にあるため、Catのインスタンスが変わると修正の必要がある
     */
    public function barks() {
        $cat = new Cat();
        $cat->meow();
    }
}

$dog = new Dog0();
$dog->barks();


/**
 *
 * メソッドインジェクション(メソッド直前で注入)
 *
 */
class Dog1{

    public function barks(Cat $cat)
    {
        $cat->meow();
    }

}

$cat = new Cat();
$dog = new Dog1();
$dog->barks($cat);

/**
 *
 * セッタインジェクション(セッタで注入)
 *
 */
class Dog2{

    private $cat;

    public function setCat(Cat $cat)
    {
        $this->cat = $cat;
    }

    public function barks()
    {
        $this->cat->meow();
    }

}

$cat = new Cat();
$dog = new Dog2();
$dog->setCat($cat);
$dog->barks();


/**
 *
 * コンストラクタインジェクション(コンストラクタで注入)
 *
 */
class Dog3{

    private $cat;

    public function __construct(Cat $cat)
    {
        $this->cat = $cat;
    }

    public function barks()
    {
        $this->cat->meow();
    }

}

$cat = new Cat();
$dog = new Dog3($cat);
$dog->barks();
