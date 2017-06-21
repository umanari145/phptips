<?php

namespace Calculation;





class Calc2{

    private function getName($param, $param2) {
        return $param['first_name'] . " " . $param2['family_name'];
    }

    private function getAge($param, $param2) {
        return $param['age'] . " " . $param2['birth_day'];
    }

    public function doFunc($param, $param2,$method) {
        $res = call_user_func_array(array($this, 'get'. $method), array($param, $param2));
        echo $res;
    }
}

$calc = new Calc2();

$calc->doFunc([
    'first_name'  => 'tarou',
    'age'   => 30
],[
    'family_name' => 'matsumoto',
    'birth_day'   => '1985/1/1'
], 'Name');
//tarou matsumoto
