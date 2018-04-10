<?php

namespace duncan3dc\ExceptionsTests;

use duncan3dc\Exceptions\Catcher;
use duncan3dc\Exceptions\ExceptionFactoryInterface;
use duncan3dc\Exceptions\Exceptions;
use duncan3dc\ObjectIntruder\Intruder;
use Mockery;
use PHPUnit\Framework\TestCase;

class CatcherTest extends TestCase
{
    /**
     * @var Catcher $catcher The instance we are testing.
     */
    private $catcher;

    public function setUp()
    {
        $this->catcher = new Catcher;
    }


    public function tearDown()
    {
        Mockery::close();
    }


    public function testConstructor()
    {
        $factory = Mockery::mock(ExceptionFactoryInterface::class);
        $factory->shouldReceive("make")->once()->andReturn(new \OutOfBoundsException);

        $catcher = new Catcher($factory);

        $catcher->try(function () {
            throw new \Exception("Constructor1");
        });
        $catcher->try(function () {
            throw new \Exception("Constructor2");
        });

        $this->expectException(\OutOfBoundsException::class);
        $catcher->throw();
    }


    public function testNoExceptions()
    {
        $result = $this->catcher->throw();
        $this->assertNull($result);
    }


    public function testSecondCodeRuns()
    {
        $this->catcher->try(function () {
            throw new \Exception("First Fail");
        });

        $result = false;
        $this->catcher->try(function () use (&$result) {
            $result = true;
        });

        $this->assertTrue($result);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("First Fail");
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
            throw new \UnexpectedValueException("Multiple1");
        });
        $this->catcher->try(function () {
            throw new \InvalidArgumentException("Multiple2");
        });

        $this->expectException(Exceptions::class);
        $this->catcher->throw();
    }


    public function testDestruct()
    {
        $this->catcher->try(function () {
            throw new \Exception("Nope");
        });

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Nope");
        unset($this->catcher);
    }


    public function testCallableParameters()
    {
        $result = $this->catcher->try(function ($arg1, $arg2) {
            return "{$arg1}_{$arg2}";
        }, "one", "two");

        $this->assertSame("one_two", $result);
    }


    public function testShouldCatch1()
    {
        $catcher = new Intruder($this->catcher);

        $result = $catcher->shouldCatch(new \Exception);

        $this->assertTrue($result);
    }
    public function testShouldCatch2()
    {
        $catcher = new Intruder($this->catcher);

        $catcher->catch(\InvalidArgumentException::class);
        $result = $catcher->shouldCatch(new \Exception);

        $this->assertFalse($result);
    }
    public function testShouldCatch3()
    {
        $catcher = new Intruder($this->catcher);

        $catcher->catch(\InvalidArgumentException::class);
        $result = $catcher->shouldCatch(new \InvalidArgumentException);

        $this->assertTrue($result);
    }
    public function testShouldCatch4()
    {
        $catcher = new Intruder($this->catcher);

        $catcher->catch(\Exception::class);
        $result = $catcher->shouldCatch(new \InvalidArgumentException);

        $this->assertTrue($result);
    }
    public function testShouldCatch5()
    {
        $catcher = new Intruder($this->catcher);

        $catcher->catch(\InvalidArgumentException::class);
        $catcher->catch(\UnexpectedValueException::class);
        $result = $catcher->shouldCatch(new \UnexpectedValueException);

        $this->assertTrue($result);
    }
    public function testShouldCatch6()
    {
        $catcher = new Intruder($this->catcher);

        $catcher->catch(\UnexpectedValueException::class);
        $catcher->catch(\InvalidArgumentException::class);
        $result = $catcher->shouldCatch(new \UnexpectedValueException);

        $this->assertTrue($result);
    }


    public function testCatch()
    {
        $this->catcher->catch(\InvalidArgumentException::class);

        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessage("Don't catch me");
        $this->catcher->try(function () {
            throw new \UnexpectedValueException("Don't catch me");
        });

        $this->catcher->clear();
    }


    public function testCatchAll()
    {
        $catcher = new Intruder($this->catcher);

        $catcher->catch(\InvalidArgumentException::class);
        $catcher->catchAll();
        $result = $catcher->shouldCatch(new \UnexpectedValueException);

        $this->assertTrue($result);
    }
}
