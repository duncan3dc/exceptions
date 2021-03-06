<?php

namespace duncan3dc\Exceptions;

interface ExceptionFactoryInterface
{
    /**
     * Create an exception that handles multiple.
     *
     * @param \Throwable[] $exceptions An array of caught exceptions
     *
     * @return \Exception
     */
    public function make(array $exceptions): \Exception;
}
