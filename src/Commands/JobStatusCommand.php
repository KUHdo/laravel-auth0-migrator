<?php

namespace Kuhdo\LaravelAuth0Migrator\Commands;

use Illuminate\Console\Command;
use Kuhdo\LaravelAuth0Migrator\LaravelAuth0Migrator;

class JobStatusCommand extends Command
{
    protected $signature = 'auth0:status {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Shows all import jobs.';

    public function handle(LaravelAuth0Migrator $migrator): int
    {
        $this->table(
            $migrator->jobStatus($this->argument('id')),
            []
        );

        return static::SUCCESS;
    }
}
