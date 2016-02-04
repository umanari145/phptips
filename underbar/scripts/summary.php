<?php

require __DIR__ . '/../vendor/autoload.php';

use Underbar\ArrayImpl as _; 


//����
//http://emonkak.github.io/underbar.php/#groupBy    

$arr=[
   	["name"=>" kazumi", "domain"=>"gmail.com",  "age"=>"30","pref"=>"chiba"],
	["name"=>"ichirou","domain"=>"yahoo.co.jp", "age"=>"18","pref"=>"tokyo"],
	["name"=>" yuusuke","domain"=>"hotmail.com", "age"=>"25","pref"=>"chiba"],
	["name"=>" satoshi","domain"=>"gmail.com", "age"=>"45","pref"=>"kanagawa"],
	["name"=>"jirou ",  "domain"=>"hotmail.com", "age"=>"9","pref"=>"tokyo"]
    ];

#���o
#
#����
$arr2 =  _::filter( $arr , function($ele) {
    return $ele["age"] >=20;
});
//var_dump( $arr2 );
//array(3) {
//  [0]=>
//  array(4) {
//    ["name"]=>
//    string(7) " kazumi"
//    ["domain"]=>
//    string(9) "gmail.com"
//    ["age"]=>
//    string(2) "30"
//    ["pref"]=>
//    string(5) "chiba"
//  }
//  [2]=>
//  array(4) {
//    ["name"]=>
//    string(8) " yuusuke"
//    ["domain"]=>
//    string(11) "hotmail.com"
//    ["age"]=>
//    string(2) "25"
//    ["pref"]=>
//    string(5) "chiba"
//  }
//  [3]=>
//  array(4) {
//    ["name"]=>
//    string(8) " satoshi"
//    ["domain"]=>
//    string(9) "gmail.com"
//    ["age"]=>
//    string(2) "45"
//    ["pref"]=>
//    string(8) "kanagawa"
//  }
//}

#where��
$arr2 = _::where($arr, ['pref' => "chiba"]);
//var_dump( $arr2 );
//array(2) {
//  [0]=>
//  array(4) {
//    ["name"]=>
//    string(7) " kazumi"
//    ["domain"]=>
//    string(9) "gmail.com"
//    ["age"]=>
//    string(2) "30"
//    ["pref"]=>
//    string(5) "chiba"
//  }
//  [2]=>
//  array(4) {
//    ["name"]=>
//    string(8) " yuusuke"
//    ["domain"]=>
//    string(11) "hotmail.com"
//    ["age"]=>
//    string(2) "25"
//    ["pref"]=>
//    string(5) "chiba"
//  }
//}

$arr2 = _::pluck($arr, 'domain');
//var_dump( $arr2 );
//array(5) {
//  [0]=>
//  string(9) "gmail.com"
//  [1]=>
//  string(11) "yahoo.co.jp"
//  [2]=>
//  string(11) "hotmail.com"
//  [3]=>
//  string(9) "gmail.com"
//  [4]=>
//  string(11) "hotmail.com"
//}


#�W�v

#�����ƂɃO���[�s���Ogroupby 
$arr2 = _::groupBy( $arr, function($ele) { return $ele["pref"]; } );

//var_dump( $arr2 );

//�����ƂɃO���[�s���O
//array(3) {
//  ["chiba"]=>
//  array(2) {
//    [0]=>
//    array(4) {
//      ["name"]=>
//      string(7) " kazumi"
//      ["domain"]=>
//      string(9) "gmail.com"
//      ["age"]=>
//      string(2) "30"
//      ["pref"]=>
//      string(5) "chiba"
//    }
//    [1]=>
//    array(4) {
//      ["name"]=>
//      string(8) " yuusuke"
//      ["domain"]=>
//      string(11) "hotmail.com"
//      ["age"]=>
//      string(2) "25"
//      ["pref"]=>
//      string(5) "chiba"
//    }
//  }
//  ["tokyo"]=>
//  array(2) {
//    [0]=>
//    array(4) {
//      ["name"]=>
//      string(7) "ichirou"
//      ["domain"]=>
//      string(11) "yahoo.co.jp"
//      ["age"]=>
//      string(2) "18"
//      ["pref"]=>
//      string(5) "tokyo"
//    }
//    [1]=>
//    array(4) {
//      ["name"]=>
//      string(6) "jirou "
//      ["domain"]=>
//      string(11) "hotmail.com"
//      ["age"]=>
//      string(1) "9"
//      ["pref"]=>
//      string(5) "tokyo"
//    }
//  }
//  ["kanagawa"]=>
//  array(1) {
//    [0]=>
//    array(4) {
//      ["name"]=>
//      string(8) " satoshi"
//      ["domain"]=>
//      string(9) "gmail.com"
//      ["age"]=>
//      string(2) "45"
//      ["pref"]=>
//      string(8) "kanagawa"
//    }
//  }
//}
//
//https://quartet-communications.com/info/topics/17506


//�d�����Ȃ��p�^�[���͎g����
$arr3 = _::indexBy( $arr , 'pref');

//var_dump( $arr3 );

//array(3) {
//  ["chiba"]=>
//  array(4) {
//    ["name"]=>
//    string(8) " yuusuke"
//    ["domain"]=>
//    string(11) "hotmail.com"
//    ["age"]=> 
//    string(2) "25"
//    ["pref"]=>
//    string(5) "chiba"
//  }
//  ["tokyo"]=>
//  array(4) {
//    ["name"]=>
//    string(6) "jirou "
//    ["domain"]=>
//    string(11) "hotmail.com"
//    ["age"]=>
//    string(1) "9"
//    ["pref"]=>
//    string(5) "tokyo"
//  }
//  ["kanagawa"]=>
//  array(4) {
//    ["name"]=>
//    string(8) " satoshi"
//    ["domain"]=>
//    string(9) "gmail.com"
//    ["age"]=>
//    string(2) "45"
//    ["pref"]=>
//    string(8) "kanagawa"
//  }
//}
//
//
//���ʂ̐���

$arr4 = _::countBy( $arr ,function( $ele ){ 
    return ( $ele["age"]  >= 20 ) ? "child": " adult ";
} );

//var_dump( $arr4 );

//array(2) {
//  ["child"]=>
//  int(3)
//  [" adult "]=>
//  int(2)
//}
//
//
//�������G�ȃp�^�[��
$arr5 = _::countBy( $arr ,function( $ele ){ 
    $age; 
    if( $ele["age"]  < 10 ){
        $age ="jidou";
    }elseif( $ele["age"] < 20 ){
        $age ="teen";
    }elseif( $ele["age"] < 30 ){
        $age ="twenty";
    }else{
        $age ="adult";
    }
    return $age;
} );

//var_dump( $arr5 );
//array(4) {
//  ["adult"]=>
//  int(2)
//  ["teen"]=>
//  int(1)
//  ["twenty"]=>
//  int(1)
//  ["jidou"]=>
//  int(1)
//}
//
//���O�A�����A�h(�󔒏����{�h���C��)�̔z������
$arr2 = _::map( $arr, function($ele) {  
    $ele["email"] = trim( $ele["name"] ) ."@". $ele["domain"];
    return $ele;
});

//var_dump( $arr2 );
//array(5) {
//  [0]=>
//  array(5) {
//    ["name"]=>
//    string(7) " kazumi"
//    ["domain"]=>
//    string(9) "gmail.com"
//    ["age"]=>
//    string(2) "30"
//    ["pref"]=>
//    string(5) "chiba"
//    ["email"]=>
//    string(16) "kazumi@gmail.com"
//  }
//  [1]=>
//  array(5) {
//    ["name"]=>
//    string(7) "ichirou"
//    ["domain"]=>
//    string(11) "yahoo.co.jp"
//    ["age"]=>
//    string(2) "18"
//    ["pref"]=>
//    string(5) "tokyo"
//    ["email"]=>
//    string(19) "ichirou@yahoo.co.jp"
//  }
//  [2]=>
//  array(5) {
//    ["name"]=>
//    string(8) " yuusuke"
//    ["domain"]=>
//    string(11) "hotmail.com"
//    ["age"]=>
//    string(2) "25"
//    ["pref"]=>
//    string(5) "chiba"
//    ["email"]=>
//    string(19) "yuusuke@hotmail.com"
//  }
//  [3]=>
//  array(5) {
//    ["name"]=>
//    string(8) " satoshi"
//    ["domain"]=>
//    string(9) "gmail.com"
//    ["age"]=>
//    string(2) "45"
//    ["pref"]=>
//    string(8) "kanagawa"
//    ["email"]=>
//    string(17) "satoshi@gmail.com"
//  }
//  [4]=>
//  array(5) {
//    ["name"]=>
//    string(6) "jirou "
//    ["domain"]=>
//    string(11) "hotmail.com"
//    ["age"]=>
//    string(1) "9"
//    ["pref"]=>
//    string(5) "tokyo"
//    ["email"]=>
//    string(17) "jirou@hotmail.com"
//  }
//}
//
//
//


#30�Έȏ�̃����A�h(���O�̋󔒂��폜)�����
$arr3 = _::chain($arr)
    ->filter( function( $ele ) { return $ele["age"] >= 30; })
    ->map( function( $ele ) { 
        $ele["email"] = trim( $ele["name"] ) ."@". $ele["domain"];
        return $ele;
    });

var_dump( $arr3 );

//object(Underbar\Internal\Wrapper)#2 (2) {
//  ["value":"Underbar\Internal\Wrapper":private]=>
//  array(2) {
//    [0]=>
//    array(5) {
//      ["name"]=>
//      string(7) " kazumi"
//      ["domain"]=>
//      string(9) "gmail.com"
//      ["age"]=>
//      string(2) "30"
//      ["pref"]=>
//      string(5) "chiba"
//      ["email"]=>
//      string(16) "kazumi@gmail.com"
//    }
//    [3]=>
//    array(5) {
//      ["name"]=>
//      string(8) " satoshi"
//      ["domain"]=>
//      string(9) "gmail.com"
//      ["age"]=>
//      string(2) "45"
//      ["pref"]=>
//      string(8) "kanagawa"
//      ["email"]=>
//      string(17) "satoshi@gmail.com"
//    }
//  }
//  ["impl":"Underbar\Internal\Wrapper":private]=>
//  string(18) "Underbar\ArrayImpl"
//}
