<?php

namespace Nsingularity\Async;

use Illuminate\Support\Facades\Cache;

class Async extends AsyncAbstract
{
    static function globalFunction($function, $parameters = [])
    {
        $payload = new AsyncPayloadMold($function, $parameters, AsyncPayloadMold::TYPE_GLOBAL_FUNCTION);
        parent::execute($payload);
    }

    static function objectFunction(object $object, $function, $parameters = [])
    {
        $payload = new AsyncPayloadMold([$object, $function], $parameters, AsyncPayloadMold::TYPE_CLASS_FUNCTION);
        parent::execute($payload);
    }

    static function object(AsyncableClassInterface $object)
    {
        $payload = new AsyncPayloadMold($object, [], AsyncPayloadMold::TYPE_CLASS);
        parent::execute($payload);
    }

    static function run($key)
    {
        $payload = Cache::get($key);
        Cache::forget($key);

        if ($payload instanceof AsyncPayloadMold) {
            $payload->handler();
        }
    }
}