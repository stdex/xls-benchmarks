<?php

namespace XlsBenchmarks\Drivers;

use Box\Spout\Common\Type;
use Box\Spout\Writer\WriterFactory;
use XlsBenchmarks\AbstractDriver;
use XlsBenchmarks\Driver;

/**
 * @package xls-benchmarks
 * @since  0.1.0
 */
class Spout extends AbstractDriver implements Driver
{
    /**
     * {@inheritdoc}
     */
    protected $package_name = "box/spout";

    /**
     * {@inheritdoc}
     */
    public function writerTest()
    {
        $xls = WriterFactory::create(Type::XLSX);
        $xls->openToFile($this->path);
        foreach ($this->generateRawData() as $row) {
            $xls->addRow($row);
        }
        $xls->close();
    }
}
