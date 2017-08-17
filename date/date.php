<?php

echo "インスタンス作成";

$day1 = new DateTime();
var_dump($day1);

echo "yyyy/MM//dd形式の読み取り";

$day1 = new DateTime('1980/05/13');
var_dump($day1);

echo "yyyy-mm-dd形式の読み取り";

$day1 = new DateTime('1980-05-13');
var_dump($day1);

echo "年月日自分秒を独自に設定";

$day1 = new DateTime();
$day1->setDate(1980,5,13)->setTime(11,55,22);
var_dump($day1);

echo "任意フォーマットへの出力(個別の年月日などもこれで取り出す)\n";

$day1 = new DateTime();
echo $day1->format('Ymd H:i:s');

echo "加算・減算(strtotimeと一緒)";

$day1 = new DateTime();
$day1->modify('+1 months');
var_dump($day1);

echo "加算・減算(DateIntervalを使う)";
//pをかしらにつけて表し、年月日と時分秒の間にはTを入れる(詳しくは公式を・・)
//1年2か月4日6時間8分後
$interval = new DateInterval('P1Y2M4DT6H8M');
$day1 = new DateTime();
$day1->add($interval);
var_dump($day1);

echo "差の判定";
$day1 = new DateTime('2011-11-10');
$day2 = new DateTime('2011-11-15');
$diff = $day1->diff($day2);
//DateIntervalなので加減にそのまま使える
var_dump($diff);
//formatは公式を
echo $diff->format("%R%a");