<?php

namespace KUHdo\LaravelAuth0Migrator\Commands;

use Auth0\SDK\Contract\API\ManagementInterface;
use Auth0\SDK\Exception\ArgumentException;
use Auth0\SDK\Exception\NetworkException;
use Illuminate\Console\Command;

class JobErrorDetailsCommand extends Command
{
    protected $signature = 'auth0:errors {id : The job id of auth0. Starts with "job_"}';

    /**
     * The console command description.
     */
    protected $description = 'Show the errors of a specific job id.';

    /**
     * See short list of jobs.
     *
     * @throws ArgumentException
     * @throws NetworkException
     *
     * @see https://auth0.com/docs/api/management/v2#!/Jobs/get_jobs_by_id
     */
    public function handle(ManagementInterface $management): int
    {
        $jobDetails = $management->jobs()
            ->getErrors($this->argument('id'))
            ->getBody();

        $rows = collect(json_decode($jobDetails->__toString(), true))
            ->map(function (array $userArray): array {
                $errorsText = collect($userArray['errors'])
                    ->reduce(function (string $msg, array $error): string {
                        return $msg.$error['code'].': '.$error['path'].' :'.$error['message'];
                    }, '');

                return [
                    'email' => $userArray['user']['email'],
                    'errors' => $errorsText,
                ];
            });

        $this->table(['email', 'errors', 'payload'], $rows->toArray());

        return static::SUCCESS;
    }
}
