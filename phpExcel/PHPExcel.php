<?php

require dirname(__FILE__) . "./../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Reader\Xlsx as ExcelReader;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as ExcelWriter;
use PhpOffice\PhpSpreadsheet\Spreadsheet as SpreadSheet;
use Faker\Factory as Faker;

$phpExcel = new PHPExcel();
//データ書き込み
//$phpExcel->writeExcel();

$phpExcel->readExcel();

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

    public function readExcel(): array
    {
        $obj = $this->readExcel->load($this->dir . "output.xlsx");
        //全シートの取得
        $sheets = $obj->getSheetNames();
        $dataArr = [];
        foreach ($sheets as $eachSheetName) {
            if ($eachSheetName !== 'Worksheet') {
                $colIndex = 0;
                $sheet= $obj->getSheetByName($eachSheetName);
                $tmpArr = $this->makeHashFromTable($sheet);
                $dataArr = array_merge($dataArr, $tmpArr);
            }
        }
        return $dataArr;
    }

    public function makeHashFromTable($sheet): array
    {
        $dataArr = [];
        $header = [];
        foreach ($sheet->getRowIterator() as $row) {
            $data = [];
            $rowIndex = $row->getRowIndex();
            foreach ($sheet->getColumnIterator() as $column) {
                $colAlphabet = $column->getColumnIndex();
                $value = $sheet->getCell($colAlphabet . $rowIndex)->getFormattedValue();
                if ($rowIndex === 1) {
                    $header[] = $value;
                } else {
                    $data[] = $value;
                }
            }
            if ($rowIndex > 1) {
                if (!empty($data) && count($header) === count($data)) {
                    $dataArr[] = array_combine($header, $data);
                }
            }
        }
        return $dataArr;
    }
}