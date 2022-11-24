<?php

namespace KUHdo\LaravelAuth0Migrator\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use KUHdo\LaravelAuth0Migrator\Auth0Migrator;
use KUHdo\LaravelAuth0Migrator\Exceptions\NoActiveJobsException;

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
        try {
            $jobs = $this->fetchJobs($migrator);
        } catch (NoActiveJobsException $e) {
            $this->warn($e->getMessage());

            return static::INVALID;
        }
        $this->table(
            ['id', 'type', 'status', 'created_at', 'connection_id', 'external_id'],
            $jobs
        );

        return static::SUCCESS;
    }

    /**
     * @param Auth0Migrator $migrator
     *
     * @return array
     * @throws NoActiveJobsException
     */
    public function fetchJobs(Auth0Migrator $migrator): array
    {
        $jobIds = $this->checkJobs();

        $jobs = [];
        foreach ($jobIds as $jobId) {
            $jobs[] = $migrator->jobStatus($jobId);
        }

        return $jobs;
    }

    /**
     * Checks if there are job id´s in the cache.
     * If so return them or  throw exception.
     *
     * @return array
     * @throws NoActiveJobsException
     */
    public function checkJobs(): array
    {
        $jobIds = Cache::get('auth0.jobs');
        if (empty($jobIds)) {
            throw new NoActiveJobsException(__('No jobs found in the last 2 hours.'));
        }

        return $jobIds;
    }
}
