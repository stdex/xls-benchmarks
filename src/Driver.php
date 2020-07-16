<?php

namespace XlsBenchmarks;

/**
 * An Interface to create package specific tests
 *
 * @package xls-benchmarks
 * @since  0.1.0
 */
interface Driver
{
    /**
     * Set the cells number per row to be inserted when writing to the XLS document
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
     * Set the rows count to be inserted when writing to the XLS document
     *
     * @param int $nbrows
     */
    public function setRowCount($nbrows);

    /**
     * Get row count per XLS document
     *
     * @return int
     */
    public function getRowCount();

    /**
     * Set XLS document path to read from or write to
     *
     * @param string $path
     */
    public function setPath($path);

    /**
     * return current XLS document path
     *
     * @return string
     */
    public function getPath();

    /**
     * Set the rows count to be inserted when writing to the XLS document
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
