<?php

require_once 'PetInterface.php';
require_once 'CatIncIF.php';
require_once 'DogIncIF.php';


$pet = new Pet(new DogIncIF());
$pet->showPetProf();

class Pet{

    private $pet;

    public function __construct(PetInterface $pet) {
        $this->pet = $pet;
    }

    public function showPetProf() {
        $this->pet->getName();
        $this->pet->bark();
    }
}
