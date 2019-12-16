<?php

namespace Nsingularity\Async;


use Illuminate\Support\Facades\Cache;
use \Exception;

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
                if($response->getStatus()){
                    return $response->getData();
                }else{
                    throw new Exception($response->getData());
                }
            }

            sleep($waitSecond);
        }

        return null;
    }

}