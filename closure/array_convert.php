<?php

/**
 *  clouserを使ったarray_mapもどき
 *
 */
function array_convert($callback, $arr) {
    foreach ($arr as $key => &$value) {
        $value = $callback($value);
    }
    return $arr;
}

$arr = [
    1,2,3,4
];

$arr2 = array_convert(function($v){
    return $v * 2;
}, $arr);

var_dump($arr2);

echo "-------------通常のclouser----------------\n";

$count = 10;
$test = function ($count) {
    return $count * 2;
};

var_dump($test(10));
