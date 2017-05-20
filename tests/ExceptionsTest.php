<?php

namespace duncan3dc\ExceptionsTests;

use duncan3dc\Exceptions\Exceptions;
use PHPUnit\Framework\TestCase;

class ExceptionsTest extends TestCase
{
    private $catcher;

    public function testOneException()
    {
        $exceptions = new Exceptions([
            new \InvalidArgumentException("Number 1"),
        ]);
        $this->assertContains("InvalidArgumentException: Number 1", $exceptions->__toString());
    }


    public function testTwoExceptions()
    {
        $exceptions = new Exceptions([
            new \InvalidArgumentException("Number 1"),
            new \UnexpectedValueException("Number 2"),
        ]);
        $this->assertContains("InvalidArgumentException: Number 1", $exceptions->__toString());
        $this->assertContains("UnexpectedValueException: Number 2", $exceptions->__toString());
    }
}
