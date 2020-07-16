<?php

namespace XlsBenchmarks;

use ReflectionClass;
use ReflectionMethod;

/**
 * An Interface to create package specific tests
 *
 * @package xls-benchmarks
 * @since  0.1.0
 */
class AbstractDriver
{
    /**
     * Package name as defined by packagist
     *
     * @var string
     */
    protected $package_name;

    /**
     * Cell count per row
     *
     * @var integer
     */
    protected $nbcells = 3;

    /**
     * Row count per XLS document
     *
     * @var integer
     */
    protected $nbrows = 100;

    /**
     * Test iteration
     *
     * @var integer
     */
    protected $iteration = 3;

    /**
     * The Path to the XLS document to read from/write to
     *
     * @var string
     */
    protected $path;

    /**
     * Set the cells number per row to be inserted when writing to the XLS document
     *
     * @param int $nbcells
     */
    public function setCellCount($nbcells)
    {
        $this->nbcells = filter_var($nbcells, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'default' => 3]]);
    }

    /**
     * Get the cells count per row
     *
     * @return int
     */
    public function getCellCount()
    {
        return $this->nbcells;
    }

    /**
     * Set the rows count to be inserted when writing to the XLS document
     *
     * @param int $nbrows
     */
    public function setRowCount($nbrows)
    {
        $this->nbrows = filter_var($nbrows, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'default' => 100]]);
    }

    /**
     * Get row count per XLS document
     *
     * @return int
     */
    public function getRowCount()
    {
        return $this->nbrows;
    }

    /**
     * Set XLS document path to read from or write to
     *
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * return current XLS document path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set the rows count to be inserted when writing to the XLS document
     *
     * @param int $iteration
     */
    public function setIterationCount($iteration)
    {
        $this->iteration = filter_var($iteration, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'default' => 3]]);
    }

    /**
     * return test iteration count
     *
     * @return int
     */
    public function getIterationCount()
    {
        return $this->iteration;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->package_name;
    }

    /**
     * Using PHP 5.5 generator to ease memory usage
     * @package xls-benchmarks
     * @since  0.1.0
     *
     * @param int $nb_rows
     *
     * @return array
     */
    protected function generateRawData()
    {
        for ($i = 0; $i < $this->nbrows; $i++) {
            $index = $i;
            $arr = [];
            while ($index < $i+$this->nbcells) {
                $arr[] = 'cell--'.$index;
                $index++;
            }
            yield $arr;
        }
    }

    /**
     * run a test for a given Driver/Package
     */
    public function __invoke()
    {
        $results = [];
        $reflection = new ReflectionClass($this);
        $methods = array_filter($reflection->getMethods(ReflectionMethod::IS_PUBLIC), function ($method) {
            $str = $method->name;
            return strpos(strrev($str), 'tseT') === 0 && ! in_array($str, ['writerTest']);
        });

        array_unshift(
            $methods,
            new ReflectionMethod($this, 'writerTest')
        );

        foreach ($methods as $method) {
            for ($i = 0; $i < $this->iteration; $i++) {
                $start = microtime(true);
                $method->invoke($this);
                $duration = microtime(true) - $start;
                $results[$method->name][] = [
                    'duration' => round($duration * 1000, 2),
                    'memory' => round(memory_get_peak_usage(true) / 1024 / 1024, 2),
                ];
            }
        }

        return $results;
    }
}
