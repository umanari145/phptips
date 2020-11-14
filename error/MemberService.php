<?php

require_once 'CustomException.php';

class MemberService {

    /**
     * DBへの接続
     * @param object $logger ログの読み込み
     */
    public function __construct()
    {
        ORM::configure('mysql:host=' . getenv('DB_HOST') .';dbname=' . getenv('DB_NAME'));
        ORM::configure('username', getenv('DB_USER'));
        ORM::configure('password', getenv('DB_PASS'));
        ORM::configure('driver_options', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
        ORM::configure('return_result_sets', true); // returns result sets
    }

    /**
     * 設定保存
     * @param  array $params 設定
     * @return 
     */

    public function save_data($params)
    {
        try {
            $data = ORM::for_table('sample_table')->where('id', 1)->find_one();
            $data->set($params);
            $data->save();
        } catch (PDOException $e) {
            //エラー時の処理
            //わざと存在しないカラムをinsertしたりしてテスト
            return [
                'result' => false,
                'errorMessage' => $e->getMessage() 
            ];
        }

        return [
            'result' => true,
            'data' => $data
        ];
    }


    /**
     * 設定保存
     * @param  array $params 設定
     * @return 
     */

    public function save_data2($params)
    {
        try {
            $data = ORM::for_table('sample_table')->where('id', 1)->find_one();
            $data->set($params);
            $data->save();
        } catch (PDOException $e) {
            throw $e;
        }

        return [
            'result' => true,
            'data' => $data
        ];
    }


        /**
     * 設定保存
     * @param  array $params 設定
     * @return 
     */

    public function save_data3($params)
    {
        try {
            $data = ORM::for_table('sample_table')->where('id', 1)->find_one();
            $data->set($params);
            $data->save();
        } catch (PDOException $e) {
            throw new CustomException($e);
        }

        return [
            'result' => true,
            'data' => $data
        ];
    }

}
