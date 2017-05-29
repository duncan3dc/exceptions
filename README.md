# exceptions
A small PHP library to catch exceptions and throw them all together later.

Full documentation is available at http://duncan3dc.github.io/exceptions/  
PHPDoc API documentation is also available at [http://duncan3dc.github.io/exceptions/api/](http://duncan3dc.github.io/exceptions/api/namespaces/duncan3dc.Exceptions.html)  

[![Build Status](https://img.shields.io/travis/duncan3dc/exceptions.svg)](https://travis-ci.org/duncan3dc/exceptions)
[![Latest Version](https://img.shields.io/packagist/v/duncan3dc/exceptions.svg)](https://packagist.org/packages/duncan3dc/exceptions)


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
