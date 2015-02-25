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
}
