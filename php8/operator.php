<?php

// 三項演算子
echo (1 == 1) ? 'trueです。' : 'falseです。' ;
echo "\n";

echo "--エルビス演算子-- emptyのように幅広い表示";
echo "\n";
// エルビス演算子

//当然aが表示される
echo 'a' ?: '' ;

echo '' ?: '空だとこっちが表示' ;
echo "\n";

echo false ?: 'falseだとこっちが表示' ;
echo "\n";

echo 0 ?: '0だとこっちが表示' ;
echo "\n";

echo null ?: 'nullだとこっちが表示' ;
echo "\n";

echo "--こっからnull演算子-- nullのみ";
echo "\n";
//null演算子
echo null ?? 'nullだとこっちが表示' ;
echo "\n";

//'空白だと??の右は表示されない';
echo '' ?? 'だめぽ' ;
echo "\n";
