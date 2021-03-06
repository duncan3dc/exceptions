<?php

namespace duncan3dc\Exceptions;

use function get_class;

class Exceptions extends \Exception
{
    /**
     * @param \Throwable[] $exceptions An array of caught exceptions.
     */
    private $exceptions = [];


    /**
     * Create a new instance.
     *
     * @param \Throwable[] $exceptions An array of caught exceptions.
     */
    public function __construct(array $exceptions)
    {
        $this->exceptions = $exceptions;
        parent::__construct("Exceptions");
    }


    /**
     * Format the exceptions.
     *
     * @return string
     */
    public function __toString(): string
    {
        $string = $this->getMessage() . ":";

        foreach ($this->exceptions as $e) {
            $string .= "\n\n";
            $string .= get_class($e) . ": " . $e->getMessage() . "\n";
            $string .= $e->getTraceAsString();
        }

        $string .= "\n";

        return $string;
    }
}
