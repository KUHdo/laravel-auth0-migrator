<?php

namespace KUHdo\LaravelAuth0Migrator;

use Auth0\SDK\Contract\API\ManagementInterface;
use Auth0\SDK\Exception\ArgumentException;
use Auth0\SDK\Exception\NetworkException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\LazyCollection;
use JsonException;
use Psr\Http\Message\ResponseInterface;

class Auth0Migrator
{
    public function __construct(protected ManagementInterface $management)
    {
    }

    public function jsonFromChunk(Collection | LazyCollection $usersChunk): string
    {
        $jsonContent = Auth0UserSchema::makeJson($usersChunk);

        return Auth0UserSchema::createJsonFile($jsonContent);
    }

    /**
     * @throws NetworkException
     * @throws ArgumentException
     * @throws JsonException
     */
    public function requestUsersImport(string $filePath): ResponseInterface
    {
        $response = $this->management->jobs()->createImportUsers(
            $filePath,
            config('auth0-migrator.auth0.audience'),
        );
        // Does the status code of the response indicate failure?
        if ($response->getStatusCode() !== 202) {
            throw new NetworkException(__(
                __('Status :status: :body.'),
                ['status' => $response->getStatusCode(), 'body' => $response->getBody()]
            ));
        }

        // Decode the JSON response into a PHP array:
        $responseData = json_decode(
            $response->getBody()->__toString(),
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        // Caching created jobs.
        $jobsList = Cache::get('auth0.jobs') ?? [];
        $jobsList = array_merge($jobsList, [$responseData['id']]);

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
            $this->management->jobs()->get($id)->getBody()
        );
    }
}
