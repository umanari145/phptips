<?php

use Pimple\Container;

$container = new Container();

$container['pet.name'] = '';

$container['pet'] = $container->factory(function ($c) {
    //猫の場合
    return new CatIncIF($c['pet.name']);
    //犬の場合
    //return new DogIncIF($c['pet.name']);
});

$container['animal'] = $container->factory(function ($c) {
    return new Animal($c['pet']);
});
