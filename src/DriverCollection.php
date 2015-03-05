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
     * Package listing
     *
     * @var array
     */
    private $package_list = [
        'SplFileObject' => [
            'version' => PHP_VERSION,
            'homepage' => 'http://php.net/splfileobject',
        ],
        'filesystem functions' => [
            'version' => PHP_VERSION,
            'homepage' => 'http://php.net/manual/ref.filesystem.php',
        ]
    ];

    /**
     * a new instance of DriverCollection
     *
     * @param string $composer_lock path to the composer.lock file
     */
    public function __construct($composer_lock)
    {
        $json = json_decode(file_get_contents($composer_lock), true);
        $packages = array_filter($json['packages'], function (array $package) {
            return 'league/climate' !== $package['name'];
        });

        foreach ($packages as $package) {
            if ('league/csv' == $package['name'] && empty($package['homepage'])) {
                $package['homepage'] = 'http://csv.thephpleague.com';
            }

            $this->package_list[$package['name']] = [
                'version' => $package['version'],
                'homepage' => $package['homepage'],
            ];
        }
        ksort($this->package_list);
    }

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
     * @param  int $mode count mode
     *
     * @return int
     */
    public function count($mode = COUNT_NORMAL)
    {
        return count($this->benchmarks, $mode);
    }

    /**
     * Returns the package found
     *
     * @return array
     */
    public function getPackageList()
    {
        return $this->package_list;
    }

    /**
     * Returns the package version as seen by composer
     *
     * @param string $package
     *
     * @throws \InvalidArgumentException If the package is not recognized
     *
     * @return string
     */
    public function getPackageVersion($package)
    {
        if (! array_key_exists($package, $this->package_list)) {
            throw new InvalidArgumentException('The specified package is not registered in composer file');
        }

        return $this->package_list[$package]['version'];
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
        if (! array_key_exists($driver->getName(), $this->package_list)) {
            throw new InvalidArgumentException('The specified package is not registered in composer file');
        }

        $this->benchmarks[] = $driver;
    }
}
