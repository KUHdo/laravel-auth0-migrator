<?php

namespace KUHdo\LaravelAuth0Migrator;

use Auth0\SDK\Contract\API\ManagementInterface;
use Auth0\SDK\Contract\Auth0Interface;
use Auth0\SDK\Exception\ArgumentException;
use Auth0\SDK\Exception\NetworkException;
use Closure;
use Illuminate\Support\Collection;
use KUHdo\LaravelAuth0Migrator\JsonSchema\User as JsonSchemaUser;
use Illuminate\Foundation\Auth\User;

class Auth0Migrator
{
    protected ManagementInterface $managementApi;

    public function __construct(protected Auth0Interface $auth0)
    {
    }

    public function jsonFromChunk(Collection $usersChunk): string
    {
        return $usersChunk->map($this->mapToJsonSchemaUser())
            ->toJson();
    }

    public function managementApiClient(): static
    {
        if (! is_null(env('AUTH0_MANAGEMENT_API_TOKEN'))) {
            $this->auth0->configuration()->setManagementToken(env('AUTH0_MANAGEMENT_API_TOKEN'));
        }

        // Create a configured instance of the `Auth0\SDK\API\Management` class, based on the configuration we set up the SDK ($auth0) using.
        // If no AUTH0_MANAGEMENT_API_TOKEN is configured, this will automatically perform a client credentials exchange to generate one for you, so long as a client secret is configured.
        $this->managementApi = $this->auth0->management();

        return $this;
    }

    /**
     * @throws NetworkException
     * @throws ArgumentException
     */
    public function requestUsersImport(string $json): string
    {
        $this->auth0->management()->roles();
        $response = $this->managementApi->jobs()->createImportUsers(
            $json,
            $this->connection,
        );

        return $response->getBody();
    }

    /**
     * @return Closure
     */
    protected function mapToJsonSchemaUser(): Closure
    {
        return function (User $user) {
            return (new JsonSchemaUser())
                ->email($user->email)
                ->userId($user->id)
                ->blocked($user->status === 'Inactive')
                ->emailVerified($user->hasVerifiedEmail())
                ->givenName($user->first_name)
                ->name($user->full_name)
                ->familyName($user->last_name)
                ->userMetadata(
                    [
                        ...json_decode($user->settings),
                        ...['newsletter' => $user->newletter],
                        ]
                )
                ->appMetadata([
                    'phone_verified_at' => $user->phone_verified_at,
                ]);
        };
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
