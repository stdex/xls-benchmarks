<?php

namespace CsvBenchmarks\Driver;

use League\Csv\Reader;
use League\Csv\Writer;

class League implements Driver
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return "league/csv";
    }

    /**
     * {@inheritdoc}
     */
    public function runReader($file)
    {
        $nbrows = 0;
        $csv = Reader::createFromPath($file);
        foreach ($csv as $row) {
            ++$nbrows;
        }

        return $nbrows;
    }

    /**
     * {@inheritdoc}
     */
    public function runWriter($file, $nbrows)
    {
        $csv = Writer::createFromPath($file, 'w');
        foreach (generateRawData($nbrows) as $row) {
            $csv->insertOne($row);
        }

        return $nbrows;
    }
}
