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

use Box\Spout\Common\Type;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Writer\WriterFactory;

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
    public function getName()
    {
        return "box/spout";
    }

    /**
     * {@inheritdoc}
     */
    public function runReader($file)
    {
        $nbrows = 0;
        $csv = ReaderFactory::create(Type::CSV);
        $csv->open($file);
        while ($csv->hasNextRow()) {
            $csv->nextRow();
            ++$nbrows;
        }
        $csv->close();

        return $nbrows;
    }

    /**
     * {@inheritdoc}
     */
    public function runWriter($file, $nbrows)
    {
        $csv = WriterFactory::create(Type::CSV);
        $csv->openToFile($file);
        foreach ($this->generateRawData($nbrows) as $row) {
            $csv->addRow($row);
        }
        $csv->close();

        return $nbrows;
    }
}
