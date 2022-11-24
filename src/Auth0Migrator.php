<?php

namespace KUHdo\LaravelAuth0Migrator;

use Auth0\SDK\Contract\API\ManagementInterface;
use Auth0\SDK\Contract\Auth0Interface;
use Auth0\SDK\Exception\ArgumentException;
use Auth0\SDK\Exception\NetworkException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\LazyCollection;
use Psr\Http\Message\ResponseInterface;

class Auth0Migrator
{
    protected ManagementInterface $managementApi;

    public function __construct(protected Auth0Interface $auth0)
    {
    }

    public function jsonFromChunk(Collection | LazyCollection $usersChunk): string
    {
        $jsonContent = Auth0UserSchema::makeJson($usersChunk);

        return Auth0UserSchema::createJsonFile($jsonContent);
    }

    public function managementApiClient(): static
    {
        if (! is_null(env('AUTH0_MANAGEMENT_API_TOKEN'))) {
            $this->auth0->configuration()->setManagementToken(env('AUTH0_MANAGEMENT_API_TOKEN'));
        }

        /* Create a configured instance of the `Auth0\SDK\API\Management` class,
         based on the configuration we set up the SDK ($auth0) using.
         If no AUTH0_MANAGEMENT_API_TOKEN is configured, this will automatically perform a client credentials
         exchange to generate one for you, so long as a client secret is configured.
        */
        $this->managementApi = $this->auth0->management();

        return $this;
    }

    /**
     * @throws NetworkException
     * @throws ArgumentException
     */
    public function requestUsersImport(string $filePath): ResponseInterface
    {
        $this->auth0->management()->roles();

        $response = $this->managementApi->jobs()->createImportUsers(
            $filePath,
            config('auth0-migrator.auth0.audience'),
        );

        // Caching created jobs.
        $jobsList = Cache::get('auth0.jobs');
        $jobsList = [...$jobsList, $response->getBody()['id']];

        // TTL is at maximum 2 hours. Auth0 keeps that information no longer.
        Cache::put('auth0.jobs', $jobsList, now()->addHours(2));

        return $response;
    }

    /**
     * Show all jobs may be filtered.
     */
    public function jobStatus(string $id): array
    {
        return json_decode(
            $this->managementApi->jobs()->get($id)->getBody()
        );
    }
}
