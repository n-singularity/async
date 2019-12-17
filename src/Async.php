<?php

namespace Nsingularity\Async;

use Illuminate\Support\Facades\Cache;
use \Exceptio;
use Nsingularity\Async\Exceptions\AsyncException;

class Async extends AsyncAbstract
{
    /**
     * @param $function
     * @param array $parameters
     * @return AsyncHandler
     */
    static function globalFunction($function, $parameters = [], array $options = [])
    {
        $payload = new AsyncPayloadMold($function, $parameters, AsyncPayloadMold::TYPE_GLOBAL_FUNCTION, $options);
        return parent::execute($payload);
    }

    /**
     * @param object $object
     * @param $function
     * @param array $parameters
     * @return AsyncHandler
     */
    static function objectFunction(object $object, $function, $parameters = [], array $options = [])
    {
        $payload = new AsyncPayloadMold([$object, $function], $parameters, AsyncPayloadMold::TYPE_CLASS_FUNCTION, $options);
        return parent::execute($payload);
    }

    /**
     * @param AsyncableClassInterface $object
     * @return AsyncHandler
     */
    static function object(AsyncableClassInterface $object, array $options = [])
    {
        $payload = new AsyncPayloadMold($object, [], AsyncPayloadMold::TYPE_CLASS, $options);
        return parent::execute($payload);
    }

    static function run($key)
    {
        $payload = Cache::get($key);

        if ($payload instanceof AsyncPayloadMold) {
            try {
                Cache::put($key, new AsyncResponse(true, $payload->handler()), 60);
            } catch (\Exception $e) {
                Cache::put($key, new AsyncResponse(false, $e->getMessage()), 60);
                throw $e;
            }
        } else {
            Cache::put($key, new AsyncResponse(false, "not valid payload"), 60);
            throw new AsyncException("not valid payload");
        }
    }
}