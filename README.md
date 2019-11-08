# exceptions
A small PHP library to catch exceptions and throw them all together later.

Full documentation is available at http://duncan3dc.github.io/exceptions/  
PHPDoc API documentation is also available at [http://duncan3dc.github.io/exceptions/api/](http://duncan3dc.github.io/exceptions/api/namespaces/duncan3dc.Exceptions.html)  

[![release](https://poser.pugx.org/duncan3dc/exceptions/version.svg)](https://packagist.org/packages/duncan3dc/exceptions)
[![build](https://travis-ci.org/duncan3dc/exceptions.svg?branch=master)](https://travis-ci.org/duncan3dc/exceptions)
[![coverage](https://codecov.io/gh/duncan3dc/exceptions/graph/badge.svg)](https://codecov.io/gh/duncan3dc/exceptions)

## Installation

The recommended method of installing this library is via [Composer](//getcomposer.org/).

Run the following command from your project root:

```bash
$ composer require duncan3dc/exceptions
```


## Usage

```php
use duncan3dc\Exceptions\Catcher;

require __DIR__ . "/vendor/autoload.php";

$catcher = new Catcher;

$catcher->try(function () {
    throw new \Exception("Whoops1!");
});

$catcher->try(function () {
    throw new \Exception("Whoops2!");
});

$catcher->try(function () {
    echo "ok\n";
});

$catcher->throw();
```

_Read more at http://duncan3dc.github.io/exceptions/_  


## Changelog
A [Changelog](CHANGELOG.md) has been available since the beginning of time


## Where to get help
Found a bug? Got a question? Just not sure how something works?  
Please [create an issue](//github.com/duncan3dc/exceptions/issues) and I'll do my best to help out.  
Alternatively you can catch me on [Twitter](https://twitter.com/duncan3dc)


## duncan3dc/exceptions for enterprise

Available as part of the Tidelift Subscription

The maintainers of duncan3dc/exceptions and thousands of other packages are working with Tidelift to deliver commercial support and maintenance for the open source dependencies you use to build your applications. Save time, reduce risk, and improve code health, while paying the maintainers of the exact dependencies you use. [Learn more.](https://tidelift.com/subscription/pkg/packagist-duncan3dc-exceptions?utm_source=packagist-duncan3dc-exceptions&utm_medium=referral&utm_campaign=readme)
