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
class PackageCollection implements Countable, IteratorAggregate
{
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
     * addPackageFromComposer
     *
     * @param  string $composer_lock path to the composer lock file
     *
     * @return void
     */
    public function addPackageFromComposer($composer_lock)
    {
        $json = json_decode(file_get_contents($composer_lock), true);
        $packages = array_filter($json['packages'], function (array $package) {
            return 'league/climate' !== $package['name'];
        });

        foreach ($packages as $package) {
            $this->add($package['name'], $package['version'], $package['homepage']);
        }
    }

    /**
     * IteratorAggregate interface
     *
     * @return \Iterator
     */
    public function getIterator()
    {
        ksort($this->package_list);

        return new ArrayIterator($this->package_list);
    }

    /**
     * Countable Interface
     *
     * @param  int $mode count mode
     *
     * @return int
     */
    public function count()
    {
        return count($this->package_list);
    }

    /**
     * add a package
     *
     * @param string $package
     * @param string $version
     * @param string $homepage
     */
    public function add($package, $version, $homepage)
    {
        if (isset($this->package_list[$package])) {
            throw new InvalidArgumentException('this package is already registered');
        }
        $this->package_list[$package] = [
            'version' => $version,
            'homepage' => $homepage,
        ];
    }

    public function has($package)
    {
        return array_key_exists($package, $this->package_list);
    }

    /**
     * remove a package
     *
     * @param string $package
     *
     */
    public function remove($package)
    {
        unset($this->package_list[$package]);
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
    public function get($package)
    {
        if (! array_key_exists($package, $this->package_list)) {
            throw new InvalidArgumentException('The specified package is not registered in composer file');
        }

        return $this->package_list[$package];
    }
}
