<?php

/**
 *  clouserを使ったarray_mapもどき
 *
 */
function array_convert(callable $callback, array $arr)
{
    foreach ($arr as $key => &$value) {
        $value = $callback($value);
    }
    return $arr;
}

$arr = [
    1,2,3,4
];

//無名関数を引数にとる collectionのmapなどと同じ()
$arr2 = array_convert(function ($v) {
    return $v * 2;
}, $arr);

var_dump($arr2);

echo "-------------通常のclouser----------------\n";

$count = 10;
$test = function ($count) {
    return $count * 2;
};

var_dump($test(10));



echo "-------------使い捨ての用途 配列の中にちょっとした関数を入れたい時----------------\n";

$taxRate = 1.08;
$arr = [
    'key1' => 10,
    'price' => function ($v) use ($taxRate) {
        return $v * 2 * $taxRate;
    }
];

var_dump($arr['price'](10));
