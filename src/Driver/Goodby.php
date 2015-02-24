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

use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\LexerConfig;
use Goodby\CSV\Export\Standard\Exporter;
use Goodby\CSV\Export\Standard\ExporterConfig;

/**
 * goodby/csv driver
 *
 * @package csv-benchmarks
 * @since  0.1.0
 */
class Goodby implements Driver
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return "goodby/csv";
    }

    /**
     * {@inheritdoc}
     */
    public function runReader($file)
    {
        $nbrows = 0;
        $interpreter = new Interpreter();
        $interpreter->addObserver(function (array $rows) use (&$nbrows) {
            ++$nbrows;
        });
        $lexer = new Lexer(new LexerConfig());
        $lexer->parse($file, $interpreter);

        return $nbrows;
    }

    /**
     * {@inheritdoc}
     */
    public function runWriter($file, $nbrows)
    {
        $exporter = new Exporter(new ExporterConfig());
        $exporter->export($file, generateRawData($nbrows));
        $exporter = null;

        return $nbrows;
    }
}
