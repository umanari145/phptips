<?php

namespace animal;

require_once dirname(__FILE__) .'/ClassLoader.php';

$classes = [
    'animal\Cat',
    'animal\Dog'
];

foreach ($classes as $class) {
    $reflClass = new \ReflectionClass($class);
    $animal = $reflClass->newInstance();
    $animal->bark() ;
    echo "\n";
}