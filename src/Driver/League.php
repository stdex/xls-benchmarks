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

use League\Csv\Reader;
use League\Csv\Writer;

/**
 * league/csv driver
 *
 * @package csv-benchmarks
 * @since  0.1.0
 */
class League extends AbstractDriver implements Driver
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
        foreach ($this->generateRawData($nbrows) as $row) {
            $csv->insertOne($row);
        }

        return $nbrows;
    }
}
