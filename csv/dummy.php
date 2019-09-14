<?php

use Faker\Factory;
use Goodby\CSV\Export\Standard\Exporter;
use Goodby\CSV\Export\Standard\ExporterConfig;
use Goodby\CSV\Import\Standard\LexerConfig;
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;

#https://github.com/goodby/csv
require_once dirname(__DIR__) . '/vendor/autoload.php';


#exportCsv();

importCsv();


function importCsv() {

    $temperature = array();

    $config = new LexerConfig();
    #$config
    #    ->setDelimiter("\t") // Customize delimiter. Default value is comma(,)
    #    ->setEnclosure("'")  // Customize enclosure. Default value is double quotation(")
    #    ->setEscape("\\")    // Customize escape character. Default value is backslash(\)
    #    ->setToCharset('UTF-8') // Customize target encoding. Default value is null, no converting.
    #    ->setFromCharset('SJIS-win') // Customize CSV file encoding. Default value is null.

    $lexer = new Lexer($config);

    $interpreter = new Interpreter();
    $interpreter->addObserver(function(array $row) use (&$temperature) {
        $temperature[] = array(
            'name' => $row[0],
            'tel' => $row[1],
            'email' => $row[2],
        );
    });

    $lexer->parse('users.csv', $interpreter);
    print_r($temperature);


}


function exportCsv() {
    // フェイクデータを生成するジェネレータを作成
    $faker = Factory::create('ja_JP');

    // 日本人の氏名を10人分出力
    $data =[];
    for ($i = 0; $i < 10; $i++) {
        $data[] = [
            'name'  =>  $faker->name,
            'tel'   =>  $faker->phoneNumber,
            'email' =>  $faker->email
         ];
    }

    //configの設定 SJISで出力する
    $config = new ExporterConfig();
    $config->setToCharset('UTF-8')
    #         ->setDelimiter("\t") // Customize delimiter. Default value is comma(,)
    #        ↓ただし必要なもの(マルチバイト系の文字でないと入らない)
            ->setEnclosure('"');  // Customize enclosure. Default value is double quotation(")
    #        ->setEscape("\\")    // Customize escape character. Default value is backslash(\)
    #        ->setFromCharset('UTF-8') /

    //エクスポート
    $exporter = new Exporter($config);
    $exporter->export('users.csv', $data);
}
