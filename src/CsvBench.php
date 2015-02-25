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
     * Cell count per row
     *
     * @var integer
     */
    protected $nbcells = 3;

    /**
     * Row count per CSV document
     *
     * @var integer
     */
    protected $nbrows = 100;

    /**
     * The Path to the CSV document to read from/write to
     *
     * @var string
     */
    protected $path;

    /**
     * Benchmark results
     *
     * @var array
     */
    private $results = [];

    /**
     * New CSVBench instance
     *
     * @param \CsvBenchmarks\Driver\DriverCollection $collection
     * @param \League\CLImate\CLImate                $terminal
     */
    public function __construct(DriverCollection $collection, CLImate $terminal)
    {
        $this->terminal   = $terminal;
        $this->collection = $collection;
    }

    /**
     * Set the file path where the CSV data will be read from/write to
     *
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = trim($path);
    }

    /**
     * Set the rows count to be inserted when writing to the CSV document
     *
     * @param int $nbcells
     */
    public function setCellCount($nbcells)
    {
        $this->nbcells = filter_var($nbcells, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'default' => 3]]);
    }

    /**
     * Set the rows count to be inserted when writing to the CSV document
     *
     * @param int $nbrows
     */
    public function setRowCount($nbrows)
    {
        $this->nbrows = filter_var($nbrows, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        if (false === $this->nbrows) {
            throw new InvalidArgumentException('row count must be a valid positif integer');
        }
    }

    /**
     * Set the rows count to be inserted when writing to the CSV document
     *
     * @param int $iteration
     */
    public function setIterationCount($iteration)
    {
        $this->iteration = filter_var($iteration, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'default' => 3]]);
    }

    /**
     * run the test for a given Driver/Package
     *
     * @param  Driver $driver
     *
     */
    private function benchmarkPackage(Driver $driver)
    {
        $driver->setRowCount($this->nbrows);
        $driver->setCellCount($this->nbcells);
        $driver->setPath($this->path);
        $this->benchmarkMethod($driver, 'runWriter');
        $this->benchmarkMethod($driver, 'runReader');
    }

    /**
     * run a test for a given Driver/Package
     *
     * @param  Driver $driver
     * @param  string $test
     *
     */
    private function benchmarkMethod(Driver $driver, $test)
    {
        for ($i = 0; $i < $this->iteration; $i++) {
            $start    = microtime(true);
            $nbrows   = $driver->{$test}();
            $duration = microtime(true) - $start;
            $package  = $driver->getName();
            $this->results[$package][$test][] = [
                'duration' => round($duration * 1000, 2),
            ];
        }
    }

    /**
     * runs all the benchmarks tests
     */
    public function __invoke()
    {
        $nb_tests = count($this->collection)*2 - 1;
        $this->terminal->output("<green>CSV Benchmark</green>");
        $this->terminal->output("Runtime: <yellow>".PHP_VERSION."</yellow>");
        $this->terminal->output("Host: <yellow>".php_uname()."</yellow>");
        $this->terminal->output("Packages tested: <yellow>".count($this->collection)."</yellow>");
        $this->terminal->output("Rows to be inserted/read: <yellow>{$this->nbrows}</yellow>");
        $this->terminal->output("Cells to be inserted/read: <yellow>".($this->nbrows*$this->nbcells)."</yellow>");
        $this->terminal->output("CSV document output: <yellow>{$this->path}</yellow>");
        $this->terminal->output("Test Iteration: <yellow>".($this->iteration)."</yellow>");
        foreach ($this->collection as $driver) {

            $this->benchmarkPackage($driver);
        }
        $this->cliOutput();
    }

    /**
     * Format and Output the result to the console
     */
    private function cliOutput()
    {
        $table = [[
            '<green>Package</green>',
            '<green>Version</green>',
            '<green>Test</green>',
            '<green>Avg Duration (MS)</green>',
        ]];
        foreach ($this->results as $package => $bench) {
            $version = $this->collection->getPackageVersion($package);
            foreach ($bench as $action => $res) {
                $infos = [
                    $package,
                    $version,
                    $action,
                    round(array_sum(array_column($res, 'duration')) / $this->iteration, 2),
                ];
                if ('runReader' == $action) {
                    array_walk($infos, function (&$value) {
                        $value = "<cyan>$value</cyan>";
                    });
                }
                $table[] = $infos;
            }
        }
        $this->terminal->table($table);
    }
}
