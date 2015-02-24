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
class EasyCsv implements Driver
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return "jwage/easy-csv";
    }

    /**
     * {@inheritdoc}
     */
    public function runReader($file)
    {
        $nbrows = 0;
        $csv = new Reader($file, 'r+', false);
        while ($row = $csv->getRow()) {
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
        $csv = new Writer($file, 'w');
        foreach (generateRawData($nbrows) as $row) {
            $csv->writeRow($row);
        }
        $csv = null;

        return $nbrows;
    }
}
