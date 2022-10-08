<?php

require_once 'Pet.php';
require_once 'Dog.php';
require_once 'Cat.php';
require_once 'AnimalFactory.php';


$animalController = new AnimalController(new AnimalFactory());
$animalController->set_animal('dog', 'pocchi');
//dog name is pocchi
//wanwan
$animalController->set_animal('cat', 'tama');
//cat name is tama
//nyanya

class AnimalController
{

    private $factory;

    public function __construct($factory)
    {
        $this->factory = $factory;
    }

    public function setAnimal($type, $name): void
    {
        $animal = $this->factory->createAnimal($type, $name);
        $animal->getName();
        $animal->bark();
    }

}
