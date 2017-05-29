---
layout: default
title: Formatting
permalink: /usage/formatting/
api: ExceptionFactoryInterface
---

By default the exceptions will be formatted using their class name, the error message, and the stack trace, for example:

~~~
Fatal error: Uncaught Exceptions:

Exception: Whoops1!
#0 /tmp/example/vendor/duncan3dc/exceptions/src/Catcher.php(73): {closure}()
#1 /tmp/example/test.php(12): duncan3dc\Exceptions\Catcher->try(Object(Closure))
#2 {main}

Exception: Whoops2!
#0 /tmp/example/vendor/duncan3dc/exceptions/src/Catcher.php(73): {closure}()
#1 /tmp/example/test.php(16): duncan3dc\Exceptions\Catcher->try(Object(Closure))
#2 {main}

  thrown in /tmp/example/vendor/duncan3dc/exceptions/src/Catcher.php on line 148
~~~

You can create your own custom formatter, by extending the [Exception](http://php.net/manual/en/class.exception.php) class, [like so](https://github.com/duncan3dc/exceptions/blob/master/src/Exceptions.php).
Then you just need a factory that follows [ExceptionFactoryInterface](../../api/classes/duncan3dc.Exceptions.ExceptionFactoryInterface.html) to pass into the `Catcher` constructor:

Here's an example using anaonymous classes:
~~~php
$catcher = new Catcher(new class implements ExceptionFactoryInterface {
    public function make(array $exceptions): \Exception
    {
        return new class extends \Exception {
            public function __toString(): string
            {
                return "Custom error message";
            }
        };
    }
});
~~~
