<?php

require dirname(__FILE__) . "./../vendor/autoload.php";

$faker = Faker\Factory::create('ja_JP');


echo $faker->name . "\n";
echo $faker->address . "\n";

$arr = [1, 2, 3];
echo getDummyPulldownList($faker, $arr);

/**
 * 複数要素の取得
 * @param  array  $arr
 * @return
 */
function getDummyPulldownList($faker, $arr = [])
{
    return $faker->randomElement($arr) . "\n";
}
