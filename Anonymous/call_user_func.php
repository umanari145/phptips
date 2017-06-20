<?php

class Calc{

    private function getName($param) {
        return $param['name'];
    }

    private function getAge($param) {
        return $param['age'];
    }

    public function doFunc($param, $method) {
        $res = call_user_func(array($this, 'get'. $method), $param);
        echo $res;
    }
}

$calc = new Calc();

$calc->doFunc([
    'name'  => 'tarou',
    'age'   => 30
], 'Age');
//30
