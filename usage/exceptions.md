---
layout: default
title: Exceptions
permalink: /usage/exceptions/
api: Catcher
---

As with standard try/catch blocks you can set which types of exception to catch like so:

~~~php
$catcher->catch(\InvalidArugmentException::class);
$catcher->try(function () {
    throw new \UnexpectedValueException("Whoops1!");
});
~~~

This would cause the exception to be thrown at the call to `try()` meaning any remaining code would not be executed.

You can specify multiple types like so:
~~~php
$catcher->catch(\InvalidArugmentException::class);
$catcher->catch(\UnexpectedValueException::class);
$catcher->try(function () {
    throw new \UnexpectedValueException("Whoops1!");
});
~~~

And you can restore the default behaviour using `catchAll()`:

~~~php
$catcher->catchAll();
~~~
