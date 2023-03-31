<?php

namespace KUHdo\LaravelAuth0Migrator;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Str;
use JsonSchema\Exception\ValidationException;
use JsonSchema\Validator;
use KUHdo\LaravelAuth0Migrator\Contracts\UserMappingJsonSchema;
use KUHdo\LaravelAuth0Migrator\JsonSchema\User as JsonSchemaUser;
use ReflectionClass;

class Auth0UserSchema
{
    /**
     * Make a json from the users' collection.
     *
     *
     * @throws ValidationException
     */
    public static function makeJson(Collection | LazyCollection $usersChunk): string
    {
        // Mapping database users into auth0 schema with dependency injection of mapping.
        $usersChunk = $usersChunk->map(
            fn (User $user): JsonSchemaUser => resolve(UserMappingJsonSchema::class)->mappingOfOne($user)
        );

        // Check each user against json auth0 schema. If it does not match
        // this throws a ValidationException.
        $usersChunk->each(function (JsonSchemaUser $jsonSchemaUser): bool {
            return static::validateJson($jsonSchemaUser->toJson());
        });

        return $usersChunk->toJson();
    }

    /**
     * Checks the give user json again the auth0 schema.
     *
     *
     * @throws ValidationException
     */
    public static function validateJson(string $json): bool
    {
        // Path of auth0 json schema file.
        $reflector = new ReflectionClass(static::class);
        $path = Str::beforeLast($reflector->getFileName(), '/').'/JsonSchema/JsonUserSchema.json';

        // Validate
        $jsonSchemaObject = json_decode(file_get_contents($path));
        $jsonValidator = new Validator();
        $jsonObject = json_decode($json);
        $jsonValidator->validate($jsonObject, $jsonSchemaObject);

        // Throwing exception if needed.
        if (! $jsonValidator->isValid()) {
            $msg = __("User mapping JSON does not validate. Violations:\n");
            foreach ($jsonValidator->getErrors() as $error) {
                $msg .= sprintf("[%s] %s\n", $error['property'], $error['message']);
            }
            throw new ValidationException($msg);
        }

        return true;
    }

    /**
     * Only return file name schema.
     */
    public static function fileName(): string
    {
        // Filename for storage.
        return 'users_'.now().'.json';
    }

    /**
     * Return the path of the created json schema file.
     */
    public static function createJsonFile(string $jsonContent): string
    {
        $fileName = static::fileName();
        Storage::put($fileName, $jsonContent);

        return Storage::path($fileName);
    }
}
