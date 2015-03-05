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
namespace CsvBenchmarks\Drivers;

use CsvBenchmarks\AbstractDriver;
use CsvBenchmarks\Driver;

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
    public function readerTest()
    {
        $csv = fopen($this->path, 'r');
        while (false !== ($data = fgetcsv($csv))) {
        }
        fclose($csv);
    }

    /**
     * {@inheritdoc}
     */
    public function writerTest()
    {
        $csv = fopen($this->path, 'w');
        foreach ($this->generateRawData() as $row) {
            fputcsv($csv, $row);
        }
        fclose($csv);
    }
}
