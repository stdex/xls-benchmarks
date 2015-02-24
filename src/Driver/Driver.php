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

/**
 * An Interface to create package specific tests
 *
 * @package csv-benchmarks
 * @since  0.1.0
 */
interface Driver
{
    /**
     * Return the Package Name
     *
     * @return string
     */
    public function getName();

    /**
     * Reader test
     * @param  string $file the file path to read from
     *
     * @return int  the number of lines read
     */
    public function runReader($file);

    /**
     * Writer test
     * @param  string $file    the file path to write to
     * @param  int    $nbrows the number of rows to insert
     *
     * @return int  the actual number of lines inserted
     */
    public function runWriter($file, $nbrows);
}
