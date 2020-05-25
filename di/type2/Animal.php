<?php

/**
 * DIコンテナを使わないDI
 *
 */
require_once 'PetInterface.php';
require_once 'CatIncIF.php';
require_once 'DogIncIF.php';


$animal = new Animal(new DogIncIF('pochi'));
$animal->showPetProf();

class Animal{

    private $pet;

    public function __construct(PetInterface $pet) {
        $this->pet = $pet;
    }

    public function showPetProf() {
        $this->pet->getName();
        $this->pet->bark();
    }
}
