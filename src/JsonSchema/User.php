<?php

namespace KUHdo\LaravelAuth0Migrator\JsonSchema;

use Illuminate\Support\Collection;

class User extends JsonSchema
{
    public array $required = [
        'email',
    ];

    public bool $additionalProperties = false;

    /**
     * The user's email address.
     */
    protected ?string $email;

    /**
     * A more generic way to provide the users password hash.
     * This can be used in live of the password_hash field when
     * the users password hash was created with an alternate algorithm.
     * Note that this field and password_hash are mutually exclusive.
     */
    protected ?CustomPasswordHash $customPasswordHash = null;

    /**
     * Indicates whether the user has verified their email address.
     */
    protected ?bool $emailVerified = null;

    /**
     * The user's family name.
     */
    protected ?string $familyName = null;

    /**
     * The user's given name.
     */
    protected ?string $givenName = null;

    /**
     * The user's full name.
     */
    protected ?string $name = null;

    /**
     * The user's unique identifier. This will be prepended by the connection strategy.
     */
    protected ?string $userId = null;

    /**
     * The user's nickname.
     */
    protected ?string $nickname = null;

    /**
     * URL pointing to the user's profile picture.
     */
    protected ?string $picture = null;

    /**
     * Indicates whether the user has been blocked.
     */
    protected ?bool $blocked = null;

    /**
     * The user's username.
     */
    protected ?string $username = null;

    /**
     * Data related to the user that does affect the application's core functionality.
     */
    protected AppMetaData $appMetadata;

    /**
     * Data related to the user that does not affect the application's core functionality.
     */
    protected UserMetaData $userMetadata;

    /**
     * The MFA factors that can be used to authenticate this user.
     */
    protected ?Collection $mfaFactors = null;

    /**
     * Hashed password for the user. Passwords should be hashed using bcrypt $2a$ or $2b$ and have 10 saltRounds.
     */
    protected ?string $passwordHash = null;

    public function __construct()
    {
        $this->appMetadata = new AppMetaData();
        $this->userMetadata = new UserMetaData();
    }

    public function email(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function customPasswordHash(?CustomPasswordHash $customPasswordHash): static
    {
        $this->customPasswordHash = $customPasswordHash;

        return $this;
    }

    public function emailVerified(?bool $emailVerified): static
    {
        $this->emailVerified = $emailVerified;

        return $this;
    }

    public function familyName(?string $familyName): static
    {
        $this->familyName = $familyName;

        return $this;
    }

    public function givenName(?string $givenName): static
    {
        $this->givenName = $givenName;

        return $this;
    }

    public function name(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function userId(?string $userId): static
    {
        $this->userId = $userId;

        return $this;
    }

    public function nickname(?string $nickname): static
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function picture(?string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    public function blocked(?bool $blocked): static
    {
        $this->blocked = $blocked;

        return $this;
    }

    public function username(?string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function appMetadata(array $appMetadata): static
    {
        $appMetaData = new AppMetaData($appMetadata);
        $this->appMetadata = $appMetaData;

        return $this;
    }

    public function userMetadata(array $userMetadata): static
    {
        $userMetaData = new UserMetaData($userMetadata);
        $this->userMetadata = $userMetaData;

        return $this;
    }

    public function mfaFactors(?Collection $mfaFactors): static
    {
        $this->mfaFactors = $mfaFactors;

        return $this;
    }

    public function passwordHash(?string $passwordHash): static
    {
        $this->passwordHash = $passwordHash;

        return $this;
    }

    /**
     * array_filter without a callback removes all entries where the value is null.
     * This is needed to be aligned with json schema.
     *
     * @see JsonSchema/JsonUserSchema.json
     */
    public function toArray(): array
    {
        return array_filter([
            'email' => $this->email,
            'email_verified' => $this->emailVerified,
            'user_id' => $this->userId,
            'username' => $this->username,
            'given_name' => $this->givenName,
            'family_name' => $this->familyName,
            'name' => $this->name,
            'nickname' => $this->nickname,
            'picture' => $this->picture,
            'blocked' => $this->blocked,
            'password_hash' => $this->passwordHash,
            'app_metadata' => $this->appMetadata->toArray(),
            'user_metadata' => $this->userMetadata->toArray(),
            'mfa_factors' => $this->mfaFactors,
        ]);
    }
}
