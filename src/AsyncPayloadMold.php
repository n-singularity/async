<?php

namespace Nsingularity\Async;


class AsyncPayloadMold
{
    const TYPE_GLOBAL_FUNCTION = 1;
    const TYPE_CLASS_FUNCTION  = 2;
    const TYPE_CLASS           = 3;

    /** @var */
    private $parameters;

    /** @var */
    private $type;

    /** @var $class */
    private $asyncableClass;

    /** @var $class */
    private $classFunction;

    /** @var $function */
    private $function;

    public function __construct($function, array $parameters = [], $type, array $options = [])
    {
        $this->type       = $type;
        $this->parameters = $parameters;

        if ($type == self::TYPE_GLOBAL_FUNCTION) {
            $this->function = $function;
        } elseif ($type == self::TYPE_CLASS_FUNCTION) {
            $this->classFunction = $function[0];
            $this->function      = $function[1];
        } elseif ($type == self::TYPE_CLASS_FUNCTION) {
            $this->asyncableClass = $function;
        }
    }

    public function handler()
    {
        if ($this->type == self::TYPE_GLOBAL_FUNCTION) {
            return call_user_func_array($this->function, $this->parameters);
        } elseif ($this->type == self::TYPE_CLASS_FUNCTION) {
            return call_user_func_array([$this->classFunction, $this->function], $this->parameters);
        } elseif ($this->type == self::TYPE_CLASS_FUNCTION) {
            if ($this->asyncableClass instanceof AsyncableClassInterface) {
                return $this->asyncableClass->handler();
            }
        }
    }
}