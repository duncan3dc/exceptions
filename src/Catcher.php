<?php

namespace duncan3dc\Exceptions;

class Catcher
{
    /**
     * @param \Throwable[] $exceptions An array of caught exceptions.
     */
    private $exceptions = [];

    /**
     * @param ExceptionFactoryInterface $factory A factory for creating exceptions.
     */
    private $factory;


    /**
     * Create a new instance.
     */
    public function __construct(ExceptionFactoryInterface $factory = null)
    {
        if ($factory === null) {
            $factory = new ExceptionFactory;
        }

        $this->factory = $factory;
    }


    /**
     * Run some code and catch any exceptions thrown.
     *
     * The exception will be stored to be thrown later.
     *
     * @param callable $code The code to be run
     * @param mixed $parameters The parameters to be passed
     *
     * @return mixed The return value of the callable is passed back, or null if an exception was thrown
     */
    public function try(callable $code, ...$params)
    {
        try {
            return $code(...$params);
        } catch (\Throwable $e) {
            $this->exceptions[] = $e;
        }
    }


    /**
     * Get any caught exceptions.
     *
     * @return \Throwable[]
     */
    public function getExceptions()
    {
        return $this->exceptions;
    }


    /**
     * Discard any caught exceptions.
     *
     * @return void
     */
    public function clear()
    {
        $this->exceptions = [];
    }


    /**
     * Throw any caught exceptions.
     *
     * @return void
     */
    public function throw()
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
