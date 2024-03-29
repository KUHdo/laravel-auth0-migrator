<?php

namespace KUHdo\LaravelAuth0Migrator\JsonSchema;

use KUHdo\LaravelAuth0Migrator\Enums\Algorithm;

/**
 * A more generic way to provide the users password hash.
 * This can be used in lieu of the password_hash field when the
 * users password hash was created with an alternate algorithm.
 * Note that this field and password_hash are mutually exclusive.
 */
class CustomPasswordHash extends JsonSchema
{
    /**
     * The algorithm that was used to hash the password.
     */
    protected Algorithm $algorithm;

    protected Hash $hash;

    protected ?Salt $salt;

    /**
     * The encoding of the password used to generate the hash.
     * On login, the user-provided password will be transcoded from utf8 before being checked against the provided hash.
     * For example; if your hash was generated from a ucs2 encoded string, then you would supply "encoding":"ucs2".
     */
    protected Password $password;

    public function algorithm(Algorithm $algorithm): self
    {
        $this->algorithm = $algorithm;

        return $this;
    }

    public function hash(Hash $hash): self
    {
        $this->hash = $hash;

        return $this;
    }

    public function salt(Salt $salt): self
    {
        $this->salt = $salt;

        return $this;
    }

    public function password(Password $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function toArray()
    {
        return [
            'algorithm' => $this->algorithm,
            'hash' => $this->hash,
            'salt' => $this->salt,
            'password' => $this->password,
        ];
    }
}
