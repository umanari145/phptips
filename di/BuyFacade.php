<?php

/**
 * http://hamuhamu.hatenablog.jp/entry/2015/08/17/020308
 *
 */

Class Calcer{
    public function calc($food, $num) {
        echo "calc\n";
    }
}

Class Register{
    public function pay($payment, $money) {
        echo "pay\n";
    }
}

Class Coupon{
    public function publish($userId) {
        echo "publish\n";
    }
}

/**
 *
 * 非DI　かなり複雑なクラス
 *
 */
class BuyFacade{


    public function execute($userId, $food, $num, $money)
    {
        try {
            $calcer = new Calcer();
            $payment = $calcer->calc($food, $num);

            $register = new Register();
            $register->pay($payment, $money);

            $coupon = new Coupon();
            $coupon->publish($userId);

        } catch (Exception $e) {
            var_dump($e->getMessage());
            throw new Exception($e);
        }

    }
}


$facade = new BuyFacade();
$facade->execute(10, "りんご", 50, 5000);