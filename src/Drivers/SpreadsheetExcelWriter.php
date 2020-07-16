<?php

namespace XlsBenchmarks\Drivers;

use Spreadsheet_Excel_Writer;
use XlsBenchmarks\AbstractDriver;
use XlsBenchmarks\Driver;

/**
 * @package xls-benchmarks
 * @since  0.1.0
 */
class SpreadsheetExcelWriter extends AbstractDriver implements Driver
{
    /**
     * {@inheritdoc}
     */
    protected $package_name = "pear/spreadsheet_excel_writer";

    /**
     * {@inheritdoc}
     */
    public function writerTest()
    {
        $xls = new Spreadsheet_Excel_Writer($this->path);
        $xls->setVersion(8);

        $sheet = $xls->addWorksheet('info');
        $sheet->setInputEncoding('UTF-8');

        $id = 0;
        foreach ($this->generateRawData() as $row) {
            $sheet->writeRow($id, 0, $row);
            $id++;
        }

        $xls->close();
    }
}
