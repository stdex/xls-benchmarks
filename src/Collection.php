<?php

namespace CsvBenchmarks;

use League\CLImate\CLImate;
use InvalidArgumentException;
use CsvBenchmarks\Driver\Driver;

class Collection
{
    private $benchmarks = [];

    private $file;

    private $terminal;

    private $package_list = [
        'SplFileObject' => [
            'version' => PHP_VERSION,
            'homepage' => 'http://php.net/splfileobject',
        ],
        'fopen' => [
            'version' => PHP_VERSION,
            'homepage' => 'http://php.net/fopen',
        ]
    ];

    public function __construct(CLImate $terminal)
    {
        $this->terminal = $terminal;
    }

    public function registerPackageList($composer_lock)
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

    public function getPackageList()
    {
        return $this->package_list;
    }

    public function setOutputFile($file)
    {
        $this->file = trim($file);
    }

    public function setNbWritingRows($nbrows)
    {
        $this->nbrows = $nbrows;
    }

    public function addBenchmark(Driver $driver)
    {
        if (! array_key_exists($driver->getName(), $this->package_list)) {
            throw new InvalidArgumentException('The specified package is not registered in composer file');
        }

        $this->benchmarks[] = $driver;
    }

    private function benchmarkPackage(Driver $driver, array &$results)
    {
        $package  = $driver->getName();

        //writer test
        $this->progress->current($this->key, $driver->getName().' Writer Test');
        ++$this->key;
        $start    = microtime(true);
        $nbrows   = $driver->runWriter($this->file, $this->nbrows);
        $duration = microtime(true) - $start;
        $results[] = [
            $package,
            $this->package_list[$package]['version'],
            'Writer',
            round($duration * 1000, 2),
            $nbrows,
        ];

        //reader test
        $this->progress->current($this->key, $driver->getName().' Reader Test');
        ++$this->key;
        $start    = microtime(true);
        $nbrows   = $driver->runReader($this->file);
        $duration = microtime(true) - $start;
        $results[] = [
            "<cyan>$package</cyan>",
            '<cyan>'.$this->package_list[$package]['version'].'</cyan>',
            '<cyan>Reader</cyan>',
            '<cyan>'.round($duration * 1000, 2).'</cyan>',
            "<cyan>$nbrows</cyan>",
        ];
    }

    public function __invoke()
    {
        $nb_tests = count($this->benchmarks)*2 - 1;
        $this->terminal->output("<green>CSV Benchmark</green>");
        $this->terminal->output("Runtime: <yellow>".PHP_VERSION."</yellow>");
        $this->terminal->output("Host: <yellow>".php_uname()."</yellow>");
        $this->terminal->output("Nb Package tested: <yellow>$nb_tests</yellow>");
        $this->terminal->output("CSV document output: <yellow>{$this->file}</yellow>");
        $this->terminal->output("Rows to be inserted/read: <yellow>{$this->nbrows}</yellow>");
        $this->terminal->output("Cells to be inserted/read: <yellow>".($this->nbrows*3)."</yellow>");
        $this->terminal->output("");
        $table = [[
            '<green>Package</green>',
            '<green><green>Version</green>',
            '<green>Action</green>',
            '<green>Duration (MS)</green>',
            '<green>NB Rows</green>',
        ]];
        $this->progress = $this->terminal->progress()->total($nb_tests);
        $this->key = 0;
        foreach ($this->benchmarks as $driver) {
            $this->benchmarkPackage($driver, $table);
        }
        $this->terminal->table($table);
    }
}
