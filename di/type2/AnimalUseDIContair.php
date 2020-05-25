<?php



/**
 * DIコンテナを使ったDI
 *
 */

require_once 'Pet.php';
require_once 'Cat.php';
require_once 'Dog.php';

require_once "../../vendor/autoload.php";
require_once "di_config.php";

$container['pet.name'] = 'tama';
$animal = $container['animal'];
$animal->showPetProf();


class Animal
{

    private $pet;

    public function __construct(Pet $pet) {
        $this->pet = $pet;
    }

    public function showPetProf() {
        $this->pet->getName();
        $this->pet->bark();
    }
}
