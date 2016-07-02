<?php

namespace duncan3dc\ExceptionsTests;

use duncan3dc\Exceptions\Catcher;

class CatcherTest extends \PHPUnit_Framework_TestCase
{
    private $catcher;

    public function setUp()
    {
        $this->catcher = new Catcher;
    }


    public function testNoExceptions()
    {
        $result = $this->catcher->throw();
        $this->assertNull($result);
    }


    public function testSecondCodeRuns()
    {
        $this->catcher->try(function () {
            throw new \Exception("Fail1");
        });

        $result = false;
        $this->catcher->try(function () use (&$result) {
            $result = true;
        });

        $this->assertTrue($result);

        $this->setExpectedException(\Exception::class, "Fail1");
        $this->catcher->throw();
    }


    public function testGetExceptions()
    {
        $exceptions = [
            new \Exception("Fail1"),
            new \Exception("Fail2"),
        ];

        $this->catcher->try(function () use ($exceptions) {
            throw $exceptions[0];
        });
        $this->catcher->try(function () use ($exceptions) {
            throw $exceptions[1];
        });

        $this->assertSame($exceptions, $this->catcher->getExceptions());

        $this->catcher->clear();
    }


    public function testClear()
    {
        $exception = new \Exception("Nope");

        $this->catcher->try(function () use ($exception) {
            throw $exception;
        });

        $this->assertSame([$exception], $this->catcher->getExceptions());

        $this->catcher->clear();

        $this->assertSame([], $this->catcher->getExceptions());
    }


    public function testMultipleExceptions()
    {
        $this->catcher->try(function () {
            throw new \Exception("Fail1");
        });
        $this->catcher->try(function () {
            throw new \Exception("Fail2");
        });

        $this->expectOutputRegex("/^Exception: Fail1 in /");
        $this->setExpectedException(\Exception::class, "Fail2");
        $this->catcher->throw();
    }


    public function testDestruct()
    {
        $this->catcher->try(function () {
            throw new \Exception("Nope");
        });

        $this->setExpectedException(\Exception::class, "Nope");
        unset($this->catcher);
    }
}
