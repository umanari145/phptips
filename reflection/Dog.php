<?php

namespace animal;

class Dog extends Animal {

    private $name = 'pochi';

    public function bark() {
        echo $this->name . " " ."wan wan";
    }

}