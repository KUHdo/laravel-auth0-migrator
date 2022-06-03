<?php

namespace KUHdo\LaravelAuth0Migrator\Commands;

use Auth0\SDK\Exception\ArgumentException;
use Auth0\SDK\Exception\NetworkException;
use Illuminate\Console\Command;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Collection;
use KUHdo\LaravelAuth0Migrator\Auth0Migrator;

class MigrationCommand extends Command
{
    protected $signature = 'auth0:migrate';

    public const CHUNK_SIZE = 500;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports all user identities to auth0 database via management api.';

    public function handle(Auth0Migrator $migrator): int
    {
        $count = User::count();
        $this->output->progressStart($count);

        User::cursor()
            ->chunk(MigrationCommand::CHUNK_SIZE)
            ->map(fn (Collection $usersChunk) => $migrator->jsonFromChunk($usersChunk))
            ->lazy()
            ->each(function (string $chunkJson) use ($migrator) {
                try {
                    $migrator->managementApiClient()
                        ->requestUsersImport($chunkJson);
                } catch (NetworkException|ArgumentException $e) {
                    $this->error($e->getMessage());
                } finally {
                    $this->output->progressAdvance(MigrationCommand::CHUNK_SIZE);
                }
            });

        $this->output->progressFinish();

        return static::SUCCESS;
    }
}
