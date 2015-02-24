<?php

namespace CsvBenchmarks\Driver;

use Keboola\Csv\CsvFile;

class Keboola implements Driver
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return "keboola/csv";
    }

    /**
     * {@inheritdoc}
     */
    public function runReader($file)
    {
        $nbrows = 0;
        $csv = new CsvFile($file);
        foreach ($csv as $row) {
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
        $csv = new CsvFile($file);
        foreach (generateRawData($nbrows) as $row) {
            $csv->writeRow($row);
        }
        $csv = null;

        return $nbrows;
    }
}
