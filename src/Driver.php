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

/**
 * An Interface to create package specific tests
 *
 * @package csv-benchmarks
 * @since  0.1.0
 */
interface Driver
{
    /**
     * Set the cells number per row to be inserted when writing to the CSV document
     *
     * @param int $nbcells
     */
    public function setCellCount($nbcells);

    /**
     * Get the cells count per row
     *
     * @return int
     */
    public function getCellCount();

    /**
     * Set the rows count to be inserted when writing to the CSV document
     *
     * @param int $nbrows
     */
    public function setRowCount($nbrows);

    /**
     * Get row count per CSV document
     *
     * @return int
     */
    public function getRowCount();

    /**
     * Set CSV document path to read from or write to
     *
     * @param string $path
     */
    public function setPath($path);

    /**
     * return current CSV document path
     *
     * @return string
     */
    public function getPath();

    /**
     * Set the rows count to be inserted when writing to the CSV document
     *
     * @param int $iteration
     */
    public function setIterationCount($iteration);

    /**
     * return test iteration count
     *
     * @return int
     */
    public function getIterationCount();

    /**
     * Return the Package Name
     *
     * @return string
     */
    public function getName();

    /**
     * Test the basic reading capability of a driver
     *
     * @return void
     */
    public function readerTest();

    /**
     * Test the basic writing capability of a driver
     *
     * @return void
     */
    public function writerTest();

    /**
     * Run the tests
     *
     * @return array
     */
    public function __invoke();
}
