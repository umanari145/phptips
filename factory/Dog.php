<?php


class Dog implements Pet
{

    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName(): void
    {
        echo "dog name is " . $this->name . "\n";
    }

    public function bark(): void
    {
        echo 'wanwan' . "\n";
    }
}
