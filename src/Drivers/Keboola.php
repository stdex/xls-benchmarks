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
use Keboola\Csv\CsvFile;

/**
 * keboola/csv driver
 *
 * @package csv-benchmarks
 * @since  0.1.0
 */
class Keboola extends AbstractDriver implements Driver
{
    /**
     * {@inheritdoc}
     */
    protected $package_name = "keboola/csv";

    /**
     * {@inheritdoc}
     */
    public function readerTest()
    {
        $csv = new CsvFile($this->path);
        foreach ($csv as $row) {
        }
    }

    /**
     * {@inheritdoc}
     */
    public function writerTest()
    {
        $csv = new CsvFile($this->path);
        foreach ($this->generateRawData() as $row) {
            $csv->writeRow($row);
        }
    }
}
