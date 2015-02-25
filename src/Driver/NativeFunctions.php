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
    protected $package_name = "filesystem functions";

    /**
     * {@inheritdoc}
     */
    public function runReader()
    {
        $nbrows = 0;
        $csv = fopen($this->path, 'r');
        while (false !== ($data = fgetcsv($csv))) {
            ++$nbrows;
        }
        fclose($csv);

        return $nbrows;
    }

    /**
     * {@inheritdoc}
     */
    public function runWriter()
    {
        $csv = fopen($this->path, 'w');
        foreach ($this->generateRawData() as $row) {
            fputcsv($csv, $row);
        }
        fclose($csv);

        return $this->nbrows;
    }
}
