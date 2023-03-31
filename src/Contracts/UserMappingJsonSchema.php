<?php

namespace KUHdo\LaravelAuth0Migrator\Contracts;

use Illuminate\Foundation\Auth\User;
use KUHdo\LaravelAuth0Migrator\JsonSchema\User as JsonSchemaUser;
use KUHdo\LaravelAuth0Migrator\UserMapping;

interface UserMappingJsonSchema
{
    /**
     * In the most cases you will need to rebind this interface to your implementation
     * of the user mapping between your user database instance (Model) and the json schema provided by auth0.
     * You can see one implementation in the UserMapping::class to get a glimpse.
     *
     *
     *
     * @see https://auth0.com/docs/manage-users/user-migration/bulk-user-import-database-schema-and-examples
     * @see UserMapping::mappingOfOne()
     */
    public function mappingOfOne(User $user): JsonSchemaUser;
}
