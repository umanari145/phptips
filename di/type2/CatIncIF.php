<?php

require_once 'PetInterface.php';

class CatIncIF implements PetInterface {

    private $name;

    public function __construct($name) {
        $this->name = $name;
    }
    
    public function getName() {
        echo "cat name is " . $this->name . "\n";
    }

    public function bark() {
        echo 'nyanya' . "\n";
    }
}
