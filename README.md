CSV Benchmarks (PHP)
==========

[![Build Status](https://travis-ci.org/nyamsprod/csv-benchmarks.svg?branch=master)](https://travis-ci.org/nyamsprod/csv-benchmarks)
[![Latest Version](https://img.shields.io/github/release/nyamsprod/csv-benchmarks.svg?style=flat-square)](https://github.com/nyamsprod/csv-benchmarks/releases)

All CSV packages are managed by composer. Tested with the latest stable version

[**See the latest benchmark on Travis-CI**](https://travis-ci.org/nyamsprod/csv-benchmarks)

```
$ php bin/benchmark --rows=100
CSV Benchmark
Runtime: 5.5.9-1ubuntu4.6
Host: Linux sogeking 3.13.0-46-generic #75-Ubuntu SMP Tue Feb 10 15:26:00 UTC 2015 i686
Nb Package tested: 7
CSV document output: /var/www/csv-benchmarks/output/result.csv
Rows to be inserted/read: 100
Cells to be inserted/read: 300

------------------------------------------------------------------------
| Package        | Version          | Action | Duration (MS) | NB Rows |
------------------------------------------------------------------------
| fopen          | 5.5.9-1ubuntu4.6 | Writer | 4,59          | 100     |
------------------------------------------------------------------------
| fopen          | 5.5.9-1ubuntu4.6 | Reader | 0.68          | 100     |
------------------------------------------------------------------------
| SplFileObject  | 5.5.9-1ubuntu4.6 | Writer | 4,63          | 100     |
------------------------------------------------------------------------
| SplFileObject  | 5.5.9-1ubuntu4.6 | Reader | 0.39          | 101     |
------------------------------------------------------------------------
| box/spout      | 1.0.1            | Writer | 6,34          | 100     |
------------------------------------------------------------------------
| box/spout      | 1.0.1            | Reader | 5.61          | 100     |
------------------------------------------------------------------------
| jwage/easy-csv | 0.0.2            | Writer | 5,45          | 100     |
------------------------------------------------------------------------
| jwage/easy-csv | 0.0.2            | Reader | 1.73          | 100     |
------------------------------------------------------------------------
| goodby/csv     | 1.2.0            | Writer | 9,11          | 100     |
------------------------------------------------------------------------
| goodby/csv     | 1.2.0            | Reader | 4,2           | 100     |
------------------------------------------------------------------------
| keboola/csv    | 1.1.3            | Writer | 10,52         | 100     |
------------------------------------------------------------------------
| keboola/csv    | 1.1.3            | Reader | 2,88          | 100     |
------------------------------------------------------------------------
| league/csv     | 7.0.0            | Writer | 8,04          | 100     |
------------------------------------------------------------------------
| league/csv     | 7.0.0            | Reader | 1,86          | 101     |
------------------------------------------------------------------------
```

Tested packages
-------

- [box/spout](https://github.com/box/spout) [![Latest Version](https://img.shields.io/github/release/box/spout.svg?style=flat-square)](https://github.com/box/spout/releases)
- [goodby/csv](https://github.com/goodby/csv) [![Latest Version](https://img.shields.io/github/release/goodby/csv.svg?style=flat-square)](https://github.com/goodby/csv/releases)
- [jwage/easy-csv](https://github.com/jwage/easy-csv) [![Latest Version](https://img.shields.io/github/release/jwage/easy-csv.svg?style=flat-square)](https://github.com/jwage/easy-csv/releases)
- [league/csv](https://github.com/thephpleague/csv) [![Latest Version](https://img.shields.io/github/release/thephpleague/csv.svg?style=flat-square)](https://github.com/thephpleague/csv/releases)
- [keboola/csv](https://github.com/keboola/php-csv) [![Latest Version](https://poser.pugx.org/keboola/csv/v/stable.svg)](https://github.com/keboola/php-csv/releases)

Requirements
-------

You need **PHP >=5.5.0** or **HHVM >= 3.2** to be sure the test will (PHP Generators as used to ease generating huge CSV documents).

Adding a new package
----

- Make sure your csv package is available on [packagist](https://packagist.org) first
- Clone this repo
- Update the `composer.json` with the submitted package

```
$ composer require "myawesome/csv-package"

```

- Add a new class in the `src/Driver`, for instance `MyAwesomeCsvPackage` directory that implements the `Driver` Interface.  
You can copy/paste an existing Driver to see how it works. Remember that the `getName` method **must** return the package name as registered with packagist. in your case it will be `myawesome/csv-package`.

- Update the benchmark script by adding your new driver.

```php
$drivers->add(new Driver\MyAwesomeCsvPackage());
```

- Test and submit your added package through pull request

Contributing
-------

Contributions are welcome and will be fully credited. Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

Security
-------

If you discover any security related issues, please email nyamsprod@gmail.com instead of using the issue tracker.

Credits
-------

- [ignace nyamagana butera](https://github.com/nyamsprod)
- [All Contributors](https://github.com/nyamsprod/csv-benchmarks/graphs/contributors)

License
-------

The MIT License (MIT). Please see [LICENSE](LICENSE) for more information.
