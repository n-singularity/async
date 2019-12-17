<?php

namespace Nsingularity\Async\Exceptions;

use \Exception;
use \Throwable;

class AsyncException extends Exception
{
    /**
     * AsyncException constructor.
     * @param string $messages
     * @param int $code
     * @param Throwable $previous
     */
    public function __construct($messages = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($messages, $code, $previous);
    }
}