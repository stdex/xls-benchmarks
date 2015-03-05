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

use Box\Spout\Common\Type;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Writer\WriterFactory;
use CsvBenchmarks\AbstractDriver;
use CsvBenchmarks\Driver;

/**
 * box/spout driver
 *
 * @package csv-benchmarks
 * @since  0.1.0
 */
class Spout extends AbstractDriver implements Driver
{
    /**
     * {@inheritdoc}
     */
    protected $package_name = "box/spout";

    /**
     * {@inheritdoc}
     */
    public function readerTest()
    {
        $csv = ReaderFactory::create(Type::CSV);
        $csv->open($this->path);
        while ($csv->hasNextRow()) {
            $csv->nextRow();
        }
        $csv->close();
    }

    /**
     * {@inheritdoc}
     */
    public function writerTest()
    {
        $csv = WriterFactory::create(Type::CSV);
        $csv->openToFile($this->path);
        foreach ($this->generateRawData() as $row) {
            $csv->addRow($row);
        }
        $csv->close();
    }
}
