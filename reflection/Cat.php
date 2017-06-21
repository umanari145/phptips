<?php

namespace animal;

require_once 'Animal.php';

class Cat extends Animal{

    private $name = 'tama';

    public function bark() {
        echo $this->name . " " ."mya- mya-";
    }

}