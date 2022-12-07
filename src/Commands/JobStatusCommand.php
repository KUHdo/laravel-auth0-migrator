<?php

namespace KUHdo\LaravelAuth0Migrator\Commands;

use Auth0\SDK\API\Management;
use Auth0\SDK\Contract\API\ManagementInterface;
use Auth0\SDK\Exception\ArgumentException;
use Auth0\SDK\Exception\NetworkException;
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
    protected $description = 'Shows all import jobs in the last 2 hours.';


    /**
     * See short list of jobs.
     *
     * @param Management $management
     * @return int
     * @throws ArgumentException
     * @throws NetworkException
     * @see https://auth0.com/docs/api/management/v2#!/Jobs/get_jobs_by_id
     */
    public function handle(): int
    {
        $this->management = resolve(ManagementInterface::class);
        try {
            $jobs = $this->fetchJobs();
        } catch (NoActiveJobsException $e) {
            $this->warn($e->getMessage());

            return static::INVALID;
        }

        $jobs = collect($jobs)->map(function (object $job): array {
            $summary = collect($job->summary)->reduce(function($msg, $val, $key): string {
              return $msg .= $key.': '.$val.'; ';
            });

            return [
                $job->id,
                $job->type,
                $job->status,
                $summary,
                $job->created_at,
                $job->connection
            ];
        });
        $this->info(__('All captured job in the last two hours.'));
        $this->table(
            ['id', 'type', 'status', 'summary', 'created_at', 'connection name'],
            $jobs->toArray()
        );

        return static::SUCCESS;
    }

    /**
     * @return array
     * @throws NoActiveJobsException
     * @throws ArgumentException
     * @throws NetworkException
     */
    public function fetchJobs(): array
    {
        $jobIds = $this->checkJobs();

        $jobs = [];
        foreach ($jobIds as $jobId) {
            $jobs[] = json_decode($this->management->jobs()->get($jobId)->getBody()->__toString());
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
