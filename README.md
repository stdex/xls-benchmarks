CSV Benchmarks (PHP)
==========

[![Build Status](https://travis-ci.org/nyamsprod/csv-benchmarks.svg?branch=master)](https://travis-ci.org/nyamsprod/csv-benchmarks)
[![Latest Version](https://img.shields.io/github/release/nyamsprod/csv-benchmarks.svg?style=flat-square)](https://github.com/nyamsprod/csv-benchmarks/releases)

All CSV packages are managed by composer. Tested with the latest stable version

[**See the latest benchmark on Travis-CI**](https://travis-ci.org/nyamsprod/csv-benchmarks)

```
$  php bin/benchmark --rows=100 --iteration=10 --cells=10
CSV Benchmark
Runtime: 5.5.9-1ubuntu4.6
Host: Linux sogeking 3.13.0-46-generic #75-Ubuntu SMP Tue Feb 10 15:26:00 UTC 2015 i686
Packages tested: 7
Rows to be inserted/read: 100
Cells to be inserted/read: 1000
CSV document output: /var/www/csv-benchmarks/output/result.csv
Test Iteration: 10
---------------------------------------------------------------------------
| Package              | Version          | Test      | Avg Duration (MS) |
---------------------------------------------------------------------------
| filesystem functions | 5.5.9-1ubuntu4.6 | runWriter | 2,25              |
---------------------------------------------------------------------------
| filesystem functions | 5.5.9-1ubuntu4.6 | runReader | 2,5               |
---------------------------------------------------------------------------
| SplFileObject        | 5.5.9-1ubuntu4.6 | runWriter | 2,71              |
---------------------------------------------------------------------------
| SplFileObject        | 5.5.9-1ubuntu4.6 | runReader | 0,4               |
---------------------------------------------------------------------------
| box/spout            | 1.0.1            | runWriter | 2,85              |
---------------------------------------------------------------------------
| box/spout            | 1.0.1            | runReader | 6,02              |
---------------------------------------------------------------------------
| jwage/easy-csv       | 0.0.2            | runWriter | 3,05              |
---------------------------------------------------------------------------
| jwage/easy-csv       | 0.0.2            | runReader | 3,48              |
---------------------------------------------------------------------------
| goodby/csv           | 1.2.0            | runWriter | 7,05              |
---------------------------------------------------------------------------
| goodby/csv           | 1.2.0            | runReader | 5,84              |
---------------------------------------------------------------------------
| keboola/csv          | 1.1.3            | runWriter | 15,5              |
---------------------------------------------------------------------------
| keboola/csv          | 1.1.3            | runReader | 3,85              |
---------------------------------------------------------------------------
| league/csv           | 7.0.0            | runWriter | 3,64              |
---------------------------------------------------------------------------
| league/csv           | 7.0.0            | runReader | 2,61              |
---------------------------------------------------------------------------
```

Tested packages
-------

- [box/spout](https://github.com/box/spout) [![Latest Version](https://img.shields.io/github/release/box/spout.svg?style=flat-square)](https://github.com/box/spout/releases)
- [goodby/csv](https://github.com/goodby/csv) [![Latest Version](https://img.shields.io/github/release/goodby/csv.svg?style=flat-square)](https://github.com/goodby/csv/releases)
- [jwage/easy-csv](https://github.com/jwage/easy-csv) [![Latest Version](https://img.shields.io/github/release/jwage/easy-csv.svg?style=flat-square)](https://github.com/jwage/easy-csv/releases)
- [keboola/csv](https://github.com/keboola/php-csv) [![Latest Version](https://poser.pugx.org/keboola/csv/v/stable.svg)](https://github.com/keboola/php-csv/releases)
- [league/csv](https://github.com/thephpleague/csv) [![Latest Version](https://img.shields.io/github/release/thephpleague/csv.svg?style=flat-square)](https://github.com/thephpleague/csv/releases)

Requirements
---

You need **PHP >=5.5.0** or **HHVM >= 3.2** to be sure the test will run. (PHP Generators as used to ease generating huge CSV documents).

Installation
----

```
$ composer require nyamsprod/csv-benchmarks
```

Usage
----

```
$ php bin/benchmark
```

Will display a help message with all the information needed.


Adding a new package
----

- Make sure your csv package is available on [packagist](https://packagist.org) first
- Clone this repo
- Update the `composer.json` with the submitted package

```
$ composer require "myawesome/csv-package"
```

- Add a new class in the `src/Driver`, for instance `MyAwesomeCsvPackage` directory that implements the `CsvBenchmarks\Driver\Driver` Interface.  
You can copy/paste an existing Driver to see how it works.  
Remember that the `getName` method **must** return the package name as registered with packagist. Following our example, it will be `myawesome/csv-package`.

- Update the benchmark script by adding your new driver.

```php
$drivers->add(new Driver\MyAwesomeCsvPackage());
```

- If everything goes as planned you can submit your package via a Pull Request

Contributing
-------

Contributions are welcome and will be fully credited. Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

Credits
-------

- [ignace nyamagana butera](https://github.com/nyamsprod)
- [All Contributors](https://github.com/nyamsprod/csv-benchmarks/graphs/contributors)

License
-------

The MIT License (MIT). Please see [LICENSE](LICENSE) for more information.
