<?php

use Pimple\Container;

$container = new Container();

$container['pet.name'] = '';

$container['pet'] = $container->factory(function ($c) {
    return new DogIncIF($c['pet.name']);
});

$container['animal'] = $container->factory(function ($c) {
    return new Animal($c['pet']);
});
