<?php

namespace duncan3dc\Exceptions;

use function count;

class Catcher
{
    /**
     * @var array<\Throwable> $exceptions An array of caught exceptions.
     */
    private $exceptions = [];

    /**
     * @var ExceptionFactoryInterface $factory A factory for creating exceptions.
     */
    private $factory;

    /**
     * @var array<string> $catch An array of exception types to catch.
     */
    private $catch = [];


    public function __construct(ExceptionFactoryInterface $factory = null)
    {
        if ($factory === null) {
            $factory = new ExceptionFactory();
        }

        $this->factory = $factory;
    }


    /**
     * Add an exception type to catch.
     *
     * @param string $class The exception class to catch
     */
    public function catch(string $class): void
    {
        $this->catch[] = $class;
    }


    /**
     * Catch any type of exception.
     */
    public function catchAll(): void
    {
        $this->catch = [];
    }


    /**
     * Run some code and catch any exceptions thrown.
     *
     * The exception will be stored to be thrown later.
     *
     * @param callable $code The code to be run
     * @param mixed ...$params The parameters to be passed
     *
     * @return mixed The return value of the callable is passed back, or null if an exception was thrown
     */
    public function try(callable $code, ...$params)
    {
        try {
            return $code(...$params);
        } catch (\Throwable $e) {
            if ($this->shouldCatch($e)) {
                $this->exceptions[] = $e;
            } else {
                throw $e;
            }
        }
    }


    /**
     * Check if the passed exception should be caught or not.
     */
    private function shouldCatch(\Throwable $e): bool
    {
        if (count($this->catch) === 0) {
            return true;
        }

        foreach ($this->catch as $catch) {
            if ($e instanceof $catch) {
                return true;
            }
        }

        return false;
    }


    /**
     * Get any caught exceptions.
     *
     * @return array<\Throwable>
     */
    public function getExceptions(): array
    {
        return $this->exceptions;
    }


    /**
     * Discard any caught exceptions.
     */
    public function clear(): void
    {
        $this->exceptions = [];
    }


    /**
     * Throw any caught exceptions.
     */
    public function throw(): void
    {
        # Ensure the exceptions are only thrown once
        $exceptions = $this->exceptions;
        $this->clear();

        if (count($exceptions) < 1) {
            return;
        }

        if (count($exceptions) === 1) {
            throw $exceptions[0];
        }

        throw $this->factory->make($exceptions);
    }


    /**
     * Ensure any caught exceptions are thrown.
     */
    public function __destruct()
    {
        $this->throw();
    }
}
