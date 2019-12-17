<?php

namespace Nsingularity\Async;


use Illuminate\Support\Facades\Cache;
use \Exception;
use Nsingularity\Async\Exceptions\AsyncException;

class AsyncHandler
{
    private $key;

    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * @param int $wait
     * @param int $maxAttemp
     */
    public function get(int $waitSecond = 1, int $maxAttemp = 10)
    {
        for ($i = 0; $i < $maxAttemp; $i++) {
            $response = Cache::get($this->key);
            if ($response instanceof AsyncResponse) {
                if ($response->getStatus()) {
                    return $response->getData();
                } else {
                    throw new AsyncException($response->getData());
                }
            } elseif (is_null($response)) {
                return [];
                break;
            }

            sleep($waitSecond);
        }

        return null;
    }

    /**
     * @param int $waitSecond
     * @param int $maxAttemp
     * @return array|null
     */
    public function getAndIgnoreException(int $waitSecond = 1, int $maxAttemp = 10)
    {
        for ($i = 0; $i < $maxAttemp; $i++) {
            $response = Cache::get($this->key);
            if ($response instanceof AsyncResponse) {
                if ($response->getStatus()) {
                    return [
                        "status"         => $response->getStatus(),
                        "data"           => $response->getData(),
                        "error_messages" => null,
                    ];
                } else {
                    return [
                        "status"         => $response->getStatus(),
                        "data"           => null,
                        "error_messages" => $response->getData()
                    ];
                }
            } elseif (is_null($response)) {
                return [];
                break;
            }

            sleep($waitSecond);
        }

        return [];
    }

}