<?php

namespace Nsingularity\Async;


class AsyncResponse
{
    /** @var */
    private $status;

    /** @var */
    private $data;


    public function __construct($status, $data)
    {
        $this->status = $status;
        $this->data   = $data;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }
}