<?php

namespace duncan3dc\Exceptions;

class Catcher
{
    /**
     * @param \Throwable[] $exceptions An array of caught exceptions.
     */
    private $exceptions = [];


    /**
     * Run some code and catch any exceptions thrown.
     *
     * The exception will be stored to be thrown later.
     *
     * @param callable $code The code to be run
     *
     * @return mixed The return value of the callable is passed back, or null if an exception was thrown
     */
    public function try(callable $code)
    {
        try {
            return $code();
        } catch (\Exception $e) {
            $this->exceptions[] = $e;
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
        if (count($this->exceptions) < 1) {
            return;
        }

        $finalException = array_pop($this->exceptions);

        foreach ($this->exceptions as $key => $e) {
            echo $e->__toString();
            unset($this->exceptions[$key]);
        }

        throw $finalException;
    }


    /**
     * Ensure any caught exceptions are thrown.
     */
    public function __destruct()
    {
        $this->throw();
    }
}
