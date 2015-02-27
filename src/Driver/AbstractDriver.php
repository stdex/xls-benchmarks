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

use ReflectionClass;
use ReflectionMethod;

/**
 * An Interface to create package specific tests
 *
 * @package csv-benchmarks
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
     * Row count per CSV document
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
     * The Path to the CSV document to read from/write to
     *
     * @var string
     */
    protected $path;

    /**
     * Set the cells number per row to be inserted when writing to the CSV document
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
     * Set the rows count to be inserted when writing to the CSV document
     *
     * @param int $nbrows
     */
    public function setRowCount($nbrows)
    {
        $this->nbrows = filter_var($nbrows, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'default' => 100]]);
    }

    /**
     * Get row count per CSV document
     *
     * @return int
     */
    public function getRowCount()
    {
        return $this->nbrows;
    }

    /**
     * Set CSV document path to read from or write to
     *
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * return current CSV document path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
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
     * @package csv-benchmarks
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
            return preg_match('/Test$/', $method->name);
        });

        uasort($methods, function ($met1, $met2) {
            if ('writerTest' == $met1->name) {
                return -1;
            } elseif ('writerTest' == $met2->name) {
                return 1;
            }

            return strcasecmp($met1->name, $met2->name);
        });

        foreach ($methods as $method) {
            for ($i = 0; $i < $this->iteration; $i++) {
                $start = microtime(true);
                $method->invoke($this);
                $duration = microtime(true) - $start;
                $results[$method->name][] = [
                    'duration' => round($duration * 1000, 2),
                ];
            }
        }

        return $results;
    }
}
