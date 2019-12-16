<?php

namespace Nsingularity\Async;

use Illuminate\Support\Facades\Cache;
use \Exceptio;

class Async extends AsyncAbstract
{
    /**
     * @param $function
     * @param array $parameters
     * @return AsyncHandler
     */
    static function globalFunction($function, $parameters = [])
    {
        $payload = new AsyncPayloadMold($function, $parameters, AsyncPayloadMold::TYPE_GLOBAL_FUNCTION);
        return parent::execute($payload);
    }

    /**
     * @param object $object
     * @param $function
     * @param array $parameters
     * @return AsyncHandler
     */
    static function objectFunction(object $object, $function, $parameters = [])
    {
        $payload = new AsyncPayloadMold([$object, $function], $parameters, AsyncPayloadMold::TYPE_CLASS_FUNCTION);
        return parent::execute($payload);
    }

    /**
     * @param AsyncableClassInterface $object
     * @return AsyncHandler
     */
    static function object(AsyncableClassInterface $object)
    {
        $payload = new AsyncPayloadMold($object, [], AsyncPayloadMold::TYPE_CLASS);
        return parent::execute($payload);
    }

    static function run($key)
    {
        $payload = Cache::pull($key);

        if ($payload instanceof AsyncPayloadMold) {
            try {
                Cache::put($key, new AsyncResponse(true, $payload->handler()), 60);
            } catch (\Exception $e) {
                Cache::put($key, new AsyncResponse(false, $e->getMessage()), 60);
            }
        }else{
            Cache::put($key, new AsyncResponse(false, "not valid payload"), 60);
        }
    }
}