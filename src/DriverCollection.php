<?php
namespace XlsBenchmarks;

use ArrayIterator;
use Countable;
use InvalidArgumentException;
use IteratorAggregate;

/**
 * A collection of benchmarks and packagelist
 *
 * @package xls-benchmarks
 * @since  0.1.0
 */
class DriverCollection implements Countable, IteratorAggregate
{
    /**
     * Drivers
     *
     * @var XlsBenchmarks\Driver[]
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
