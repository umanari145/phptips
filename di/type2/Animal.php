<?php

/**
 * DIコンテナを使わないDI
 *
 */
require_once 'Pet.php';
require_once 'Cat.php';
require_once 'Dog.php';


$animal = new Animal(new Dog('pochi'));
$animal->showPetProf();

class Animal{

    private $pet;

    public function __construct(Pet $pet) {
        $this->pet = $pet;
    }

    public function showPetProf() {
        $this->pet->getName();
        $this->pet->bark();
    }
}
