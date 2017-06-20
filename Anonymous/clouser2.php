<?php


$arr = [100,200,300];

$arr2 = array_map(function ($val){
    return $val * 2;
}, $arr);

var_dump($arr2);
//array(3) {
//    [0] =>
//    int(200)
//    [1] =>
//    int(400)
//    [2] =>
//    int(600)
//}

$double_price = function ($val){
    return $val * 2;
};

$arr3 = array_map($double_price, $arr);

var_dump($arr3);//$arr2と同じ


$arr4 = array_walk( $arr, function ($val){
    return $val * 2;
});
var_dump($arr4); //true[

$arr=[
   	["name"=>" kazumi", "domain"=>"gmail.com",  "age"=>"30","pref"=>"chiba"],
    ["name"=>"ichirou","domain"=>"yahoo.co.jp", "age"=>"18","pref"=>"tokyo"],
    ["name"=>" yuusuke","domain"=>"hotmail.com", "age"=>"25","pref"=>"chiba"],
    ["name"=>" satoshi","domain"=>"gmail.com", "age"=>"45","pref"=>"kanagawa"],
    ["name"=>"jirou ",  "domain"=>"hotmail.com", "age"=>"9","pref"=>"tokyo"]
];

$arr5 = array_filter( $arr, function ( $val){
    return $val['age'] >= 20 && $val['pref'] === 'chiba';
});
    var_dump($arr5);

//array(2) {
//  [0] =>
//  array(4) {
//    'name' =>
//    string(7) " kazumi"
//    'domain' =>
//    string(9) "gmail.com"
//    'age' =>
//    string(2) "30"
//    'pref' =>
//    string(5) "chiba"
//  }
//  [2] =>
//  array(4) {
//    'name' =>
//    string(8) " yuusuke"
//    'domain' =>
//    string(11) "hotmail.com"
//    'age' =>
//    string(2) "25"
//    'pref' =>
//    string(5) "chiba"
//  }

//特定のカラム抜き出し
$arr6 = array_column($arr, 'name');
var_dump($arr6);
//array(5) {
//    [0] =>
//    string(7) " kazumi"
//    [1] =>
//    string(7) "ichirou"
//    [2] =>
//    string(8) " yuusuke"
//    [3] =>
//    string(8) " satoshi"
//    [4] =>
//    string(6)
//}

$arr7 = array_map(function ($val){ return $val['name'];}, $arr);
var_dump($arr7);//$arr6と同じ

//30歳以上のメルアド(名前の空白を削除し、名前＋@+domain)を作る
//若干読みにくいがarray_filterで配列を作り、そのあとarray_mapに渡している
$arr8 = array_map(function ($val){
    $val["email"] = $val["name"] ."@" . $val["domain"];
    return $val;
},array_filter($arr, function ($val){
    return $val['age'] >= 30;
}));
var_dump($arr8);
//array(2) {
//    [0] =>
//    array(5) {
//        'name' =>
//        string(7) " kazumi"
//            'domain' =>
//        string(9) "gmail.com"
//            'age' =>
//        string(2) "30"
//            'pref' =>
//        string(5) "chiba"
//            'email' =>
//        string(17) " kazumi@gmail.com"
//    }
//    [3] =>
//    array(5) {
//        'name' =>
//        string(8) " satoshi"
//            'domain' =>
//        string(9) "gmail.com"
//            'age' =>
//        string(2) "45"
//            'pref' =>
//        string(8) "kanagawa"
//            'email' =>
//        string(18) " satoshi@gmail.com"
//    }
//}
