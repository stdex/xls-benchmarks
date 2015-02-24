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
namespace CsvBenchmarks;

use League\CLImate\CLImate;
use InvalidArgumentException;
use CsvBenchmarks\Driver\Driver;
use CsvBenchmarks\Driver\DriverCollection;

/**
 * A collection of benchmarks
 * @package csv-benchmarks
 * @since  0.1.0
 */
class CsvBench
{
    /**
     * Console output
     *
     * @var League\CLImate\CLImate
     */
    private $terminal;

    /**
     * Driver collection
     *
     * @var \CsvBenchmarks\Driver\DriverCollection
     */
    private $collection;

    /**
     * File path where CSV data will be read and/or write
     *
     * @var string
     */
    private $file;

    /**
     * Rows count to be added to or read from the CSV document
     *
     * @var int
     */
    private $nbrows;

    public function __construct(DriverCollection $collection, CLImate $terminal)
    {
        $this->terminal   = $terminal;
        $this->collection = $collection;
    }

    public function setOutputFile($file)
    {
        $this->file = trim($file);
    }

    public function setNbWritingRows($nbrows)
    {
        $this->nbrows =filter_var($nbrows, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'default' => 200000]]);
    }

    private function benchmarkPackage(Driver $driver, array &$results)
    {
        $package  = $driver->getName();

        //writer test
        $this->progress->current($this->key, $driver->getName().' Writer Test');
        ++$this->key;
        $start    = microtime(true);
        $nbrows   = $driver->runWriter($this->file, $this->nbrows);
        $duration = microtime(true) - $start;
        $results[] = [
            $package,
            $this->collection->getPackageVersion($package),
            'Writer',
            round($duration * 1000, 2),
            $nbrows,
        ];

        //reader test
        $this->progress->current($this->key, $driver->getName().' Reader Test');
        ++$this->key;
        $start    = microtime(true);
        $nbrows   = $driver->runReader($this->file);
        $duration = microtime(true) - $start;
        $results[] = [
            "<cyan>$package</cyan>",
            '<cyan>'.$this->collection->getPackageVersion($package).'</cyan>',
            '<cyan>Reader</cyan>',
            '<cyan>'.round($duration * 1000, 2).'</cyan>',
            "<cyan>$nbrows</cyan>",
        ];
    }

    public function __invoke()
    {
        $nb_tests = count($this->collection)*2 - 1;
        $this->terminal->output("<green>CSV Benchmark</green>");
        $this->terminal->output("Runtime: <yellow>".PHP_VERSION."</yellow>");
        $this->terminal->output("Host: <yellow>".php_uname()."</yellow>");
        $this->terminal->output("Nb Package tested: <yellow>$nb_tests</yellow>");
        $this->terminal->output("CSV document output: <yellow>{$this->file}</yellow>");
        $this->terminal->output("Rows to be inserted/read: <yellow>{$this->nbrows}</yellow>");
        $this->terminal->output("Cells to be inserted/read: <yellow>".($this->nbrows*3)."</yellow>");
        $this->terminal->output("");
        $table = [[
            '<green>Package</green>',
            '<green><green>Version</green>',
            '<green>Action</green>',
            '<green>Duration (MS)</green>',
            '<green>NB Rows</green>',
        ]];
        $this->progress = $this->terminal->progress()->total($nb_tests);
        $this->key = 0;
        foreach ($this->collection as $driver) {
            $this->benchmarkPackage($driver, $table);
        }
        $this->terminal->table($table);
    }
}
