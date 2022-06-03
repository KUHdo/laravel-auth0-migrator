<?php

namespace KUHdo\LaravelAuth0Migrator\Commands;

use Illuminate\Console\Command;
use KUHdo\LaravelAuth0Migrator\Auth0Migrator;

class JobStatusCommand extends Command
{
    protected $signature = 'auth0:status {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Shows all import jobs.';

    public function handle(Auth0Migrator $migrator): int
    {
        $this->table(
            $migrator->jobStatus($this->argument('id')),
            []
        );

        return static::SUCCESS;
    }
}
