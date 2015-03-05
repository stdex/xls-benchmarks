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

use ArrayIterator;
use Countable;
use InvalidArgumentException;
use IteratorAggregate;

/**
 * A collection of benchmarks and packagelist
 *
 * @package csv-benchmarks
 * @since  0.1.0
 */
class DriverCollection implements Countable, IteratorAggregate
{
    /**
     * Drivers
     *
     * @var CsvBenchmarks\Driver[]
     */
    private $benchmarks = [];

    /**
     * IteratorAggregate interface
     *
     * @return \Iterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->benchmarks);
    }

    /**
     * Countable Interface
     *
     * @return int
     */
    public function count()
    {
        return count($this->benchmarks);
    }

    /**
     * Add a Driver
     *
     * @param Driver $driver a driver
     *
     * @throws \InvalidArgumentException If the Driver is not recognized
     */
    public function add(Driver $driver)
    {
        if ($this->has($driver)) {
            throw new InvalidArgumentException('The specified package is already registered');
        }

        $this->benchmarks[] = $driver;
    }

    public function has(Driver $driver)
    {
        return false !== array_search($driver, $this->benchmarks, true);
    }

    public function remove(Driver $driver)
    {
        if (false !== ($key = array_search($driver, $this->benchmarks, true))) {
            unset($this->benchmarks[$key]);
        }
    }
}
