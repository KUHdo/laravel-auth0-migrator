<?php

namespace KUHdo\LaravelAuth0Migrator;

use Auth0\SDK\Contract\API\ManagementInterface;
use Auth0\SDK\Contract\Auth0Interface;
use Auth0\SDK\Exception\ArgumentException;
use Auth0\SDK\Exception\NetworkException;
use Closure;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\LazyCollection;
use KUHdo\LaravelAuth0Migrator\Contracts\UserMappingJsonSchema;
use KUHdo\LaravelAuth0Migrator\JsonSchema\User as JsonSchemaUser;
use Illuminate\Foundation\Auth\User;
use Psr\Http\Message\ResponseInterface;

class Auth0Migrator
{
    protected ManagementInterface $managementApi;

    public function __construct(protected Auth0Interface $auth0, protected UserMappingJsonSchema $userMapping)
    {
    }

    public function jsonFromChunk(LazyCollection $usersChunk): string
    {
        $jsonContent = $usersChunk->map(fn(User $user) => $this->userMapping->mappingOfOne($user))
            ->toJson();

        Storage::put('users.json', $jsonContent);

        return Storage::path('users.json');
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
    public function requestUsersImport(string $json): ResponseInterface
    {
        $this->auth0->management()->roles();

        return $this->managementApi->jobs()->createImportUsers(
            $json,
            config('auth0-migrator.auth0.audience'),
        );
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
