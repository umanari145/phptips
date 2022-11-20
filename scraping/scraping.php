<?php 

require_once dirname(__DIR__) . '/vendor/autoload.php';

use PHPHtmlParser\Dom;

// 文字コードを設定する。
// 日本語だと文字コードの自動解析がうまく動かないようなので、
// ページに合わせて設定する必要があります
//$options = new Options();
//$options->setEnforceEncoding('utf8');

//$url = 'https://www.dmm.co.jp/live/chat/=/design_pattern=2021/';
//$dom = new Dom();
//$dom->loadFromUrl($url, $options);

$dom = new Dom;
$data = file_get_contents(dirname(__FILE__) . "/dmm_20221111.html");
$dom->loadStr($data);
$targets = $dom->find('li.CharacterItem  button.CharacterItem__pinBtn');
foreach ($targets as $target) {
    // キャストのidとstatusを取得
    echo $target->getAttribute('data-character_id') . $target->getAttribute('data-status') . "\n";
}
// 商品名を取得
