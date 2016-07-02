# exceptions
A small PHP library to catch exceptions and throw them all together later.

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
