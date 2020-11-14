<?php


require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

require_once('MemberService.php');

$memberController = new MemberController();
//$memberController->type1();
//$memberController->type2();
$memberController->type3();

class MemberController {

    public function __construct() {
        $this->memberService = new MemberService();
    }

    public function type1() {
        echo "-------Serviceでcatch--------\n";
        $res = $this->memberService->save_data([
            'product_price' => '999a'
        ]);
        
        var_dump($res);
        //レスポンスのサンプル(こけたものは下記のように吐き出される)
        /*array(2) {
            ["result"]=>
            bool(false)
            ["errorMessage"]=>
            string(93) "SQLSTATE[42S02]: Base table or view not found: 1146 Table 'phptips.sample_data' doesn't exist"
        }
        */
    }

    public function type2() {
        echo "-------Controllerでcatch--------\n";
        try{
            $res2 = $this->memberService->save_data2([
                'product_price' => '9991'
            ]);
            //正常系 
            var_dump($res2);
        }catch(Exception $e) {
            //異常系
            var_dump($e->getMessage());
        }
    }

    public function type3() {
        echo "-------Controllerでcatch(独自のthrow)--------\n";
        try{
            $res3 = $this->memberService->save_data3([
                'product_price' => '999q'
            ]);
            //正常系 
            var_dump($res3);
        }catch(Exception $e) {
            //異常系
            var_dump($e->getCustomMessage());
        }
    }
}

