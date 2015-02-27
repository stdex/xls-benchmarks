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

use EasyCSV\Reader;
use EasyCSV\Writer;

/**
 * jwage/easy-csv driver
 *
 * @package csv-benchmarks
 * @since  0.1.0
 */
class EasyCsv extends AbstractDriver implements Driver
{
    /**
     * {@inheritdoc}
     */
    protected $package_name = "jwage/easy-csv";

    /**
     * {@inheritdoc}
     */
    public function readerTest()
    {
        $csv = new Reader($this->path, 'r+', false);
        while ($row = $csv->getRow()) {
        }
    }

    /**
     * {@inheritdoc}
     */
    public function writerTest()
    {
        $csv = new Writer($this->path, 'w');
        foreach ($this->generateRawData() as $row) {
            $csv->writeRow($row);
        }
    }
}
