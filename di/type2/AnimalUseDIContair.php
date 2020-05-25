<?php



/**
 * DIコンテナを使ったDI
 *
 */

require_once 'PetInterface.php';
require_once 'CatIncIF.php';
require_once 'DogIncIF.php';

require_once "../../vendor/autoload.php";
require_once "di_config.php";

$container['pet.name'] = 'tama';
$animal = $container['animal'];
$animal->showPetProf();


class Animal
{

    private $pet;

    public function __construct(PetInterface $pet) {
        $this->pet = $pet;
    }

    public function showPetProf() {
        $this->pet->getName();
        $this->pet->bark();
    }
}
