<?php

namespace KUHdo\LaravelAuth0Migrator;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\LazyCollection;
use KUHdo\LaravelAuth0Migrator\Contracts\UserMappingJsonSchema;
use KUHdo\LaravelAuth0Migrator\JsonSchema\User as JsonSchemaUser;

class Auth0UserSchema
{
    /**
     * Make a json from the users' collection.
     *
     * @param Collection|LazyCollection $usersChunk
     * @return string
     */
    public static function makeJson(Collection|LazyCollection $usersChunk): string
    {
        return $usersChunk->map(
            fn (User $user): JsonSchemaUser => resolve(UserMappingJsonSchema::class)->mappingOfOne($user)
        )->toJson();
    }

    /**
     * Only return file name schema.
     *
     * @param string $jsonContent
     * @return string
     */
    public static function fileName(string $jsonContent): string
    {
        // File to storage.
        return 'users_'.now().'_'.Hash::make($jsonContent).'.json';
    }

    /**
     * Return the path of the created json schema file.
     *
     * @param string $jsonContent
     * @return string path
     */
    public static function createJsonFile(string $jsonContent): string
    {
        $fileName = static::fileName($jsonContent);
        Storage::put(static::fileName($jsonContent), $jsonContent);

        return Storage::path($fileName);
    }
}
