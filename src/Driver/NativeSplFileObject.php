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

use SplFileObject;

/**
 * SplFileObject driver
 *
 * @package csv-benchmarks
 * @since  0.1.0
 */
class NativeSplFileObject extends AbstractDriver implements Driver
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
        foreach ($this->generateRawData($nbrows) as $row) {
            $csv->fputcsv($row);
        }

        return $nbrows;
    }
}
