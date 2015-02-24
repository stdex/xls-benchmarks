<?php

namespace CsvBenchmarks\Driver;

use Box\Spout\Common\Type;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Writer\WriterFactory;

class Spout implements Driver
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return "box/spout";
    }

    /**
     * {@inheritdoc}
     */
    public function runReader($file)
    {
        $nbrows = 0;
        $csv = ReaderFactory::create(Type::CSV);
        $csv->open($file);
        while ($csv->hasNextRow()) {
            $csv->nextRow();
            ++$nbrows;
        }
        $csv->close();

        return $nbrows;
    }

    /**
     * {@inheritdoc}
     */
    public function runWriter($file, $nbrows)
    {
        $csv = WriterFactory::create(Type::CSV);
        $csv->openToFile($file);
        foreach (generateRawData($nbrows) as $row) {
            $csv->addRow($row);
        }
        $csv->close();

        return $nbrows;
    }
}
