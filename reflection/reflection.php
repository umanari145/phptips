<?php

namespace animal;

require_once dirname(__FILE__) .'/ClassLoader.php';

$classes = [
    'animal\Cat',
    'animal\Dog'
];


echo "reflection \n";

foreach ($classes as $class) {
    $reflClass = new \ReflectionClass($class);
    $animal = $reflClass->newInstance();
    $animal->bark() ;
    echo "\n";
}

echo "not reflection \n";

/**
 *  動的なクラスやメソッド定義だけなら下記のような書き方だけでもいいかも
 */
$func = 'bark';
foreach ($classes as $class) {
    $animalClass = new $class();
    $animalClass->{$func}();
    echo "\n";
}
