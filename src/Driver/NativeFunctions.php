<?php

namespace CsvBenchmarks\Driver;

class NativeFunctions implements Driver
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return "fopen";
    }

    /**
     * {@inheritdoc}
     */
    public function runReader($file)
    {
        $nbrows = 0;
        $csv = fopen($file, 'r');
        while (false !== ($data = fgetcsv($csv))) {
            ++$nbrows;
        }
        fclose($csv);

        return $nbrows;
    }

    /**
     * {@inheritdoc}
     */
    public function runWriter($file, $nbrows)
    {
        $csv = fopen($file, 'w');
        foreach (generateRawData($nbrows) as $row) {
            fputcsv($csv, $row);
        }
        fclose($csv);

        return $nbrows;
    }
}
