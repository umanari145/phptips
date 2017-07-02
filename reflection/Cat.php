<?php

namespace animal;

class Cat extends Animal{

    private $name = 'tama';

    public function bark() {
        echo $this->name . " " ."mya- mya-";
    }

}