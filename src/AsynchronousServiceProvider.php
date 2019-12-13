<?php

namespace Nsingularity\Async;

use Illuminate\Support\ServiceProvider;
use Nsingularity\Async\Console\ExecuteCommand;

class AsynchronousServiceProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = true;

    /**
     * Boot the service provider.
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the service provider.
     * @return void
     */
    public function register()
    {
        $this->mergeConfig();

        $this->commands([
            ExecuteCommand::class,
        ]);
    }

    /**
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
