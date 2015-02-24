<?php

namespace CsvBenchmarks\Driver;

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
