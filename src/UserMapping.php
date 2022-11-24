<?php

namespace KUHdo\LaravelAuth0Migrator;

use Illuminate\Foundation\Auth\User;
use KUHdo\LaravelAuth0Migrator\Contracts\UserMappingJsonSchema;
use KUHdo\LaravelAuth0Migrator\JsonSchema\User as JsonSchemaUser;

class UserMapping implements UserMappingJsonSchema
{
    /**
     * Overwrite me for mapping!
     *
     * @param User $user
     *
     * @return JsonSchemaUser
     */
    public function mappingOfOne(User $user): JsonSchemaUser
    {
        return (new JsonSchemaUser())
            ->email($user->email)
            ->userId($user->id)
            ->emailVerified($user->hasVerifiedEmail())
            ->givenName($user->first_name)
            ->name($user->full_name)
            ->familyName($user->last_name)
            ->passwordHash($user->password);
    }
}
