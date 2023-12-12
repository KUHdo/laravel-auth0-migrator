<?php

declare(strict_types=1);

namespace KUHdo\LaravelAuth0Migrator\Commands;

use Auth0\SDK\Exception\ArgumentException;
use Auth0\SDK\Exception\NetworkException;
use Illuminate\Console\Command;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\LazyCollection;
use KUHdo\LaravelAuth0Migrator\Auth0Migrator;

class MigrationCommand extends Command
{
    protected $signature = 'auth0:migrate '.
    '{--D|dry-run : creates only the json schema file in storage but does not send it to auth0}';

    public const CHUNK_SIZE = 500;

    /**
     * The console command description.
     */
    protected $description = 'Imports all user identities to auth0 database via management api.';

    /**
     * Execute the console command.
     */
    public function handle(Auth0Migrator $migrator): int
    {
        $count = User::count();
        if ($count < 0) {
            $this->error(__('No users found in database. Nothing to migrate.'));

            return static::FAILURE;
        }

        $howManyChunks = (int) ceil($count / static::CHUNK_SIZE);
        $this->output->progressStart($howManyChunks);

        User::lazy()
            ->chunk(self::CHUNK_SIZE)
            ->map(fn (LazyCollection $usersChunk): string => $migrator->jsonFromChunk($usersChunk))
            ->each(function (string $chunkJson) use ($migrator, $count) {
                try {
                    $response = $migrator->requestUsersImport($chunkJson);

                    $this->info(
                        __(
                            'Status :status: Import user job spawned with id :id and and :count users.',
                            ['status' => $response->getStatusCode(), 'id' => $response->getBody(), 'count' => $count]
                        )
                    );
                } catch (NetworkException|ArgumentException $e) {
                    $this->error($e->getMessage());
                    $this->output->progressFinish();
                } finally {
                    $this->output->progressAdvance();
                }
            });

        $this->output->progressFinish();

        return static::SUCCESS;
    }
}
