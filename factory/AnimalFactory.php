<?php


class AnimalFactory {

    public function createAnimal( $type, $name) {
        $animal = null;
        switch ($type) {
            case 'cat':
                $animal = new Cat($name);
                break;
            case 'dog':
                $animal = new Dog($name);
                break;
        }
        return $animal;
    }
}
