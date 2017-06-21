<?php

namespace animal;

require_once 'Animal.php';

class Dog extends Animal {

    private $name = 'pochi';

    public function bark() {
        echo $this->name . " " ."wan wan";
    }

}