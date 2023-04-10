<?php

// 三項演算子
echo (1 == 1) ? 'trueです。' : 'falseです。' ;
echo "\n";

echo "--エルビス演算子-- emptyのように幅広い表示";
echo "\n";
// エルビス演算子
$var1 = 'a';
echo $var1 ?: '' ;

$var2 = '';
echo $var2 ?: '空だとこっちが表示' ;
echo "\n";

$var3 = false;
echo $var3 ?: 'falseだとこっちが表示' ;
echo "\n";

$var4 = 0;
echo $var4 ?: '0だとこっちが表示' ;
echo "\n";


$var5 = null;
echo $var5 ?: 'nullだとこっちが表示' ;
echo "\n";

echo "--こっからnull演算子-- nullのみ";
echo "\n";
//null演算子
$nullable_var1 = null;
echo $nullable_var1 ?? 'nullだとこっちが表示' ;
echo "\n";

$nullable_var2 = '空白だと??の右は表示されない';
echo $nullable_var2 ?? 'だめぽ' ;
echo "\n";
