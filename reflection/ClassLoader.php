<?php

/**
 * Classが定義されていない場合に、ファイルを探すクラス
 */
class ClassLoader
{
    public static function loadClass($class)
    {
        $classHashes = [
            'animal\Cat' => 'Cat.php',
            'animal\Dog' => 'Dog.php',
            'animal\Animal' => 'Animal.php'
        ];

        if (! empty($class) && !empty($classHashes[$class])) {
            $file_name = $classHashes[$class];
        }

        if (file_exists($file_name)) {
            require_once $file_name;
        }
    }

}

// これを実行しないとオートローダーとして動かない
spl_autoload_register(array('ClassLoader', 'loadClass'));