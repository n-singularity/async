<?php

namespace Nsingularity\Async\Console;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use LaravelDoctrine\Migrations\Configuration\ConfigurationProvider;
use LaravelDoctrine\Migrations\Migrator;
use Nsingularity\Async\Async;

class ExecuteCommand extends Command
{
    use ConfirmableTrait;

    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'async:execute async {--key=}';

    /**
     * @var string
     */
    protected $description = 'Execute a process parallelly on background';

    /**
     * Execute the console command.
     *
     * @param ConfigurationProvider $provider
     * @param Migrator              $migrator
     */
    public function handle()
    {
        $key = $this->option('key');
        $this->info(Async::run($key));
    }
}
