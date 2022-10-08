<?php


class Cat implements Pet
{

    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName(): void
    {
        echo "cat name is " . $this->name . "\n";
    }

    public function bark(): void
    {
        echo 'nyanya' . "\n";
    }
}
