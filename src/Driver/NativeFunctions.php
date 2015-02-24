<?php
/**
 * This file is part of the csv-benchmarks library
 *
 * @license http://opensource.org/licenses/MIT
 * @link https://github.com/nyamsprod/csv-benchmark
 * @version 0.1.0
 * @package csv-benchmarks
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CsvBenchmarks\Driver;

/**
 * Native functions fopen/fputcsv/fgetcsv driver
 *
 * @package csv-benchmarks
 * @since  0.1.0
 */
class NativeFunctions extends AbstractDriver implements Driver
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
        foreach ($this->generateRawData($nbrows) as $row) {
            fputcsv($csv, $row);
        }
        fclose($csv);

        return $nbrows;
    }
}
