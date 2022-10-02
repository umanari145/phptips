<?php

require_once 'ChildClass.php';

/**
 * 静的遅延束縛の子クラス
 */
class ChildClass extends ParentClass {

    public static function hello()
    {
        echo __CLASS__ . ' hello!!';
    }
}
