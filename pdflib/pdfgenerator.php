<?php
require_once 'fpdf/japanese.php';

$pdf = new PDF_Japanese();
$pdf->AddSJISFont();
$pdf->AddPage();
$pdf->SetFont('SJIS','',18);

//位置の指定
$pdf->setXY(100,80);
//サイズと出力文字
$pdf->Write(18,tosjis('サンプル帳票'));
$pdf->ln();

//引数について
//第1 テーブルの幅、
//第2 テーブルの高さ、
//第3 文字、
//第4 枠の有無 0なし 1あり
//第5 0: 右へ移動 1: 次の行の開始位置へ移動 2: 下へ移動　
//第5 テーブル内の文字の位置 L 左寄席 C 中央 R 右寄せ
$pdf->cell(60,14,tosjis("名前"),1,0,'C');
$pdf->cell(20,14,tosjis("年齢"),1,0,'C');
$pdf->cell(70,14,tosjis("誕生日"),1,0,'C');
//これで改行を表す
$pdf->ln();

$pdf->cell(60,14,tosjis("山田太郎"),1,0,'L');
$pdf->cell(20,14,"35",1,0,'C');
$pdf->cell(70,14,"1970/1/1",1,0,'R');

$pdf->ln();

$pdf->cell(60,14,tosjis("山田太郎"),1,0,'L');
$pdf->cell(20,14,"35",1,0,'C');
$pdf->cell(70,14,"1970/1/1",1,0,'R');


$pdf->AddPage();

$pdf->cell(60,14,tosjis("名前"),1,0,'C');
$pdf->cell(20,14,tosjis("年齢"),1,0,'C');
$pdf->cell(70,14,tosjis("誕生日"),1,0,'C');
//これで改行を表す
$pdf->ln();

$pdf->cell(60,14,tosjis("鈴木次郎"),1,0,'L');
$pdf->cell(20,14,"20",1,0,'C');
$pdf->cell(70,14,"1980/5/13",1,0,'R');


$pdf->Output();

function tosjis($str){
  return mb_convert_encoding($str,'SJIS','auto');
}
