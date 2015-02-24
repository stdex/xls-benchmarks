<?php

namespace CsvBenchmarks\Driver;

use EasyCSV\Reader;
use EasyCSV\Writer;

class EasyCsv implements Driver
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return "jwage/easy-csv";
    }

    /**
     * {@inheritdoc}
     */
    public function runReader($file)
    {
        $nbrows = 0;
        $csv = new Reader($file, 'r+', false);
        while ($row = $csv->getRow()) {
            ++$nbrows;
        }
        $csv = null;

        return $nbrows;
    }

    /**
     * {@inheritdoc}
     */
    public function runWriter($file, $nbrows)
    {
        $csv = new Writer($file, 'w');
        foreach (generateRawData($nbrows) as $row) {
            $csv->writeRow($row);
        }
        $csv = null;

        return $nbrows;
    }
}
