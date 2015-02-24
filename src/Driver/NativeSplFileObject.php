<?php

namespace CsvBenchmarks\Driver;

use SplFileObject;

class NativeSplFileObject implements Driver
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return "SplFileObject";
    }

    /**
     * {@inheritdoc}
     */
    public function runReader($file)
    {
        $nbrows = 0;
        $csv = new SplFileObject($file);
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
        $csv = new SplFileObject($file, 'w');
        foreach (generateRawData($nbrows) as $row) {
            $csv->fputcsv($row);
        }

        return $nbrows;
    }
}
