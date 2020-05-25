<?php


class Dog implements Pet {

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
