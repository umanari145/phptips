<?php

require __DIR__ . '/../vendor/autoload.php';

use Illuminate\Support\Collection;

// 公式
// https://laravel.com/docs/10.x/collections　2023年現在

$arr = [
    ["name" => " kazumi", "domain" => "gmail.com",  "age" => "30", "pref" => "chiba"],
    ["name" => "ichirou", "domain" => "yahoo.co.jp", "age" => "18", "pref" => "tokyo"],
    ["name" => " yuusuke", "domain" => "hotmail.com", "age" => "25", "pref" => "chiba"],
    ["name" => " satoshi", "domain" => "gmail.com", "age" => "45", "pref" => "kanagawa"],
    ["name" => "jirou ",  "domain" => "hotmail.com", "age" => "9", "pref" => "tokyo"]
];

$arr = collect($arr);
#抽出
#条件 20歳以上を抽出
$arr2 = $arr->filter(fn($ele) => $ele['age'] >= 20);
//dd($arr2);

#where句 (filterとほぼ同じ)
$arr3 = $arr->where('pref', 'chiba');

#特定プロパティのみを抽出
$arr4 = $arr->pluck($arr, 'name');

#集計
#県ごとにグルーピングgroupby
$arr5 = $arr->groupBy('pref');

//年齢別の集計
$arr6 = $arr->countBy(fn($ele) => $ele['age'] >= 20 ? 'child' : 'adult');
/*
^ Illuminate\Support\Collection^ {#12
  #items: array:2 [
    "child" => 3
    "adult" => 2
  ]
  #escapeWhenCastingToString: false
}*/


//少し複雑なパターン
//名前、メルアド(空白除去＋ドメイン)の配列を作る
$arr7 = $arr->map(fn($ele) => sprintf('%s@%s', $ele['name'], $ele['domain']));


#30歳以上のメルアド(名前の空白を削除)を作る
$arr8 = $arr->filter(fn($ele) => $ele['age'] >= 30)
    ->map(function ($ele) {
        $ele['email'] = sprintf('%s@%s', trim($ele['name']), $ele['domain']);
        return $ele;
    });