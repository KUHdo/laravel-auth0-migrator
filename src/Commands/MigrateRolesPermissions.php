<?php

namespace KUHdo\LaravelAuth0Migrator\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Collection;
use KUHdo\LaravelAuth0Migrator\LaravelAuth0Migrator;

class MigrateRolesPermissions extends Command
{
    protected $signature = 'auth0:migrate:roles-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports all user identities to auth0 database via management api.';

    public function handle(LaravelAuth0Migrator $migrator): int
    {
        $count = User::count();
        $this->output->progressStart($count);

        User::cursor()
            ->chunk(MigrationCommand::CHUNK_SIZE)
            ->map(fn (Collection $usersChunk) => $migrator->jsonFromChunk($usersChunk))
            ->lazy()
            ->each(function (string $chunkJson) use ($migrator) {
                $migrator->requestUsersImport($chunkJson);
                $this->output->progressAdvance(MigrationCommand::CHUNK_SIZE);
            });

        $this->output->progressFinish();

        return static::SUCCESS;
    }
}
