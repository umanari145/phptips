<?php

require_once 'PetInterface.php';

class DogIncIF implements PetInterface {

    private $name;

    public function __construct($name) {
        $this->name = $name;
    }

    public function getName() {
        echo "dog name is " . $this->name . "\n";
    }

    public function bark() {
        echo 'wanwan' . "\n";
    }
}
