<?php

namespace Kuhdo\LaravelAuth0Migrator\JsonSchema;

use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;

class User extends JsonSchema
{
    protected array $required = [
        'email'
    ];

    protected bool $additionalProperties = false;

    /**
     * The user's email address.
     */
    protected ?string $email;

    /**
     * A more generic way to provide the users password hash.
     * This can be used in lieu of the password_hash field when the users password hash was created with an alternate algorithm.
     * Note that this field and password_hash are mutually exclusive.
     */
    protected ?CustomPasswordHash $custom_password_hash;

    /**
     * Indicates whether the user has verified their email address.
     */
    protected ?bool $email_verified;

    /**
     * The user's family name.
     */
    protected ?string $family_name;

    /**
     * The user's given name.
     */
    protected ?string $given_name;

    /**
     * The user's full name.
     */
    protected ?string $name;

    /**
     * The user's unique identifier. This will be prepended by the connection strategy.
     */
    protected ?string $user_id;

    /**
     * The user's nickname.
     */
    protected ?string $nickname;

    /**
     * URL pointing to the user's profile picture.
     */
    protected ?string $picture;

    /**
     * Indicates whether the user has been blocked.
     */
    protected ?bool $blocked;

    /**
     * The user's username.
     */
    protected ?string $username;

    /**
     * Data related to the user that does affect the application's core functionality.
     */
    protected ?Jsonable $app_metadata;

    /**
     * Data related to the user that does not affect the application's core functionality.
     */
    protected ?Jsonable $user_metadata;

    /**
     * The MFA factors that can be used to authenticate this user.
     */
    protected ?Collection $mfa_factors;

    /**
     * Hashed password for the user. Passwords should be hashed using bcrypt $2a$ or $2b$ and have 10 saltRounds.
     */
    protected ?string $password_hash;

    public function email(?string $email): User
    {
        $this->email = $email;

        return $this;
    }

    public function customPasswordHash(?CustomPasswordHash $custom_password_hash): User
    {
        $this->custom_password_hash = $custom_password_hash;

        return $this;
    }

    public function emailVerified(?bool $email_verified): User
    {
        $this->email_verified = $email_verified;

        return $this;
    }

    public function familyName(?string $family_name): User
    {
        $this->family_name = $family_name;

        return $this;
    }

    public function givenName(?string $given_name): User
    {
        $this->given_name = $given_name;

        return $this;
    }

    public function name(?string $name): User
    {
        $this->name = $name;

        return $this;
    }

    public function userId(?string $user_id): User
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function nickname(?string $nickname): User
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function picture(?string $picture): User
    {
        $this->picture = $picture;

        return $this;
    }

    public function blocked(?bool $blocked): User
    {
        $this->blocked = $blocked;

        return $this;
    }

    public function username(?string $username): User
    {
        $this->username = $username;

        return $this;
    }

    public function appMetadata(Jsonable $app_metadata): User
    {
        $this->app_metadata = $app_metadata;

        return $this;
    }

    public function userMetadata(Jsonable $user_metadata): User
    {
        $this->user_metadata = $user_metadata;

        return $this;
    }

    public function mfaFactors(?Collection $mfa_factors): User
    {
        $this->mfa_factors = $mfa_factors;

        return $this;
    }

    public function passwordHash(?string $password_hash): User
    {
        $this->password_hash = $password_hash;

        return $this;
    }

    public function toArray()
    {
        return [
            'email' => $this->email,
            'email_verified' => $this->email_verified,
            'user_id' => $this->user_id,
            'username' => $this->username,
            'given_name' => $this->given_name,
            'family_name' => $this->family_name,
            'name' => $this->name,
            'nickname' => $this->nickname,
            'picture' => $this->picture,
            'blocked' => $this->blocked,
            'password_hash' => $this->password_hash,
            'app_metadata' => $this->app_metadata,
            'user_metadata' => $this->user_metadata,
            'mfa_factors' => $this->mfa_factors,
        ];
    }
}