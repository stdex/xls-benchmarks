CSV Benchmarks (PHP)
==========

All CSV packages are managed by composer. Tested with the latest stable version

Tested packages
-------

- [box/spout](https://github.com/box/spout) [![Latest Version](https://img.shields.io/github/release/box/spout.svg?style=flat-square)](https://github.com/box/spout/releases)
- [goodby/csv](https://github.com/goodby/csv) [![Latest Version](https://img.shields.io/github/release/goodby/csv.svg?style=flat-square)](https://github.com/goodby/csv/releases)
- [jwage/easy-csv](https://github.com/jwage/easy-csv) [![Latest Version](https://img.shields.io/github/release/jwage/easy-csv.svg?style=flat-square)](https://github.com/jwage/easy-csv/releases)
- [league/csv](https://github.com/thephpleague/csv) [![Latest Version](https://img.shields.io/github/release/thephpleague/csv.svg?style=flat-square)](https://github.com/thephpleague/csv/releases)
- [keboola/csv](https://github.com/keboola/php-csv) [![Latest Version](https://poser.pugx.org/keboola/csv/v/stable.svg)](https://github.com/keboola/php-csv/releases)

Adding a new package
----

- Make sure your csv package is available on [packagist](https://packagist.org) first
- Clone this repo
- Update the `composer.json` with the submitted package

```php
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
