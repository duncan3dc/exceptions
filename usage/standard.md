---
layout: default
title: Standard
permalink: /usage/standard/
api: Catcher
---

To use the library, just pass a callable to the `try()` method, then call `throw()` when you want any exceptions to be thrown.

~~~php
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
~~~

The above script will output `"ok\n"` and then throw an Exception containing details of both `Whoops1!` and `Whoops2!`.

<p class="message-info">If you forget to call $catcher->throw() it will be automatically done on destruction</p>
