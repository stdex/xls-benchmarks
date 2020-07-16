<?php

namespace XlsBenchmarks\Drivers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use XlsBenchmarks\AbstractDriver;
use XlsBenchmarks\Driver;

/**
 * @package xls-benchmarks
 * @since  0.1.0
 */
class Phpspreadsheet extends AbstractDriver implements Driver
{
    /**
     * {@inheritdoc}
     */
    protected $package_name = "phpoffice/phpspreadsheet";

    protected $alphas = [];

    public function __construct()
    {
        $this->alphas = range('A', 'Z');
    }

    /**
     * {@inheritdoc}
     */
    public function writerTest()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $i = 1;
        foreach ($this->generateRawData() as $row) {
            foreach ($row as $id => $cell) {
                $col = $this->alphas[$id] . $i;
                $sheet->setCellValue($col, $cell);
            }
            ++$i;
        }

        $writer = new Xls($spreadsheet);
        $writer->save($this->path);
    }
}
