<?php

namespace Nsingularity\Async;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

abstract class AsyncAbstract
{
    protected static function execute(AsyncPayloadMold $payload)
    {
        $key     = Str::random(6);
        Cache::put($key, $payload, 1000);

        $basePath = str_replace(" ", "\ ", base_path());
        $command  = 'cd ' . $basePath . ' && php artisan async:execute --key=' . $key . ' > /dev/null &';
        $handler  = popen($command, "r");
        pclose($handler);
    }
}
