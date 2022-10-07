<?php

namespace KUHdo\LaravelAuth0Migrator;

use Illuminate\Contracts\Support\Jsonable;
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
            ->blocked($user->status === 'Inactive')
            ->emailVerified($user->hasVerifiedEmail())
            ->givenName($user->first_name)
            ->name($user->full_name)
            ->familyName($user->last_name)
            ->userMetadata(new class() implements Jsonable {
                public function toJson($options = 0)
                {
                    return json_encode([
                        //...json_decode($user->settings, true),
                        //...['newsletter' => $user->newletter],
                    ]);
                }
            })
            ->appMetadata(
                new class() implements Jsonable {
                    public function toJson($options = 0)
                    {
                        return json_encode([
                            //'phone_verified_at' => $user->phone_verified_at,
                        ]);
                    }
                }
            );
    }
}
