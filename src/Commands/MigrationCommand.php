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
        if ($count < 0) {
            $this->error(__('No users found in database. Nothing to migrate.'));

            return static::FAILURE;
        }

        $this->output->progressStart($count);
        User::lazy()
            ->chunk(self::CHUNK_SIZE)
            ->map(fn (LazyCollection $usersChunk) => $migrator->jsonFromChunk($usersChunk))
            ->each(function (string $chunkJson) use ($migrator, $count) {
                try {
                    $response = $migrator->managementApiClient()
                        ->requestUsersImport($chunkJson);

                    $this->info(
                        __(
                            'Status :status: Import user job spawned with id :id and and :count users.',
                            ['status' => $response->getStatusCode(), 'id' => $response->getBody(), 'count' => $count]
                        )
                    );
                } catch (NetworkException | ArgumentException $e) {
                    $this->error($e->getMessage());
                } finally {
                    $this->output->progressAdvance(self::CHUNK_SIZE);
                }
            });

        $this->output->progressFinish();

        return static::SUCCESS;
    }
}
