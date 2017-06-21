<?php

namespace animal;

require_once 'Cat.php';
require_once 'Dog.php';

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