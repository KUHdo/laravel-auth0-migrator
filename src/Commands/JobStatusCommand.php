<?php

namespace KUHdo\LaravelAuth0Migrator\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use KUHdo\LaravelAuth0Migrator\Auth0Migrator;

class JobStatusCommand extends Command
{
    protected $signature = 'auth0:jobs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Shows all import jobs.';

    /**
     * See short list of jobs.
     *
     * @param Auth0Migrator $migrator
     * @return int
     * @see https://auth0.com/docs/api/management/v2#!/Jobs/get_jobs_by_id
     */
    public function handle(Auth0Migrator $migrator): int
    {
        $this->table(
            ['id', 'type', 'status', 'created_at', 'connection_id', 'external_id'],
            $this->fetchJobs($migrator)
        );

        return static::SUCCESS;
    }

    /**
     * @param Auth0Migrator $migrator
     * @return array
     */
    public function fetchJobs(Auth0Migrator $migrator): array
    {
        $jobIds = Cache::get('auth0.jobs');
        $jobs = [];
        foreach ($jobIds as $jobId) {
            $jobs[] = $migrator->jobStatus($jobId);
        }

        return $jobs;
    }
}
