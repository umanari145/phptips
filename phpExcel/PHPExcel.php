<?php

require dirname(__FILE__) . "./../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Reader\Xlsx as ExcelReader;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as ExcelWriter;
use PhpOffice\PhpSpreadsheet\Spreadsheet as SpreadSheet;
use Faker\Factory as Faker;

$phpExcel = new PHPExcel();
$phpExcel->writeExcel();

class PHPExcel
{

    private $dir;

    public function __construct()
    {
        $this->faker = Faker::create('ja_JP');
        $this->readExcel = new ExcelReader();
        $this->spreadsheet = new Spreadsheet();
        $this->writeExcel = new ExcelWriter($this->spreadsheet);
        $this->dir = __DIR__ . "/";
    }

    public function writeExcel()
    {

        for ($number = 1; $number <= 3; $number++) {
            $sheet = $this->spreadsheet->createSheet();
            $sheet->setTitle('名簿'. $number);
            $sheet->setCellValue('A1', '名前');
            $sheet->setCellValue('B1', '誕生日');
            $sheet->setCellValue('C1', '住所');

            for ($i=2; $i<10; $i++) {
                $sheet->setCellValue('A' . $i, $this->faker->name);
                $sheet->setCellValue('B' . $i, $this->faker->date($format = 'Y-m-d', $max = '2000-01-01'));
                $sheet->setCellValue('C' . $i, $this->faker->address);
            }
        }
        $this->writeExcel->save($this->dir . "output.xlsx");
    }

}