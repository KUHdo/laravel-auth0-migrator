<?php

namespace KUHdo\LaravelAuth0Migrator\JsonSchema;

use KUHdo\LaravelAuth0Migrator\Enums\Digest;
use KUHdo\LaravelAuth0Migrator\Enums\Encoding;

class Hash extends JsonSchema
{
    /**
     * The password hash.
     */
    protected ?string $value;

    /**
     * The encoding of the provided hash.
     * Note that both upper and lower case hex variants are supported, as well as url-encoded base64.
     */
    protected ?Encoding $encoding;

    /**
     * The algorithm that was used to generate the HMAC hash.
     */
    protected ?Digest $digest;

    /**
     * The key that was used to generate the HMAC hash.
     */
    protected ?Key $key;

    public function value(?string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function encoding(?Encoding $encoding): self
    {
        $this->encoding = $encoding;

        return $this;
    }

    public function digest(?Digest $digest): self
    {
        $this->digest = $digest;

        return $this;
    }

    public function key(?Key $key): self
    {
        $this->key = $key;

        return $this;
    }

    public function toArray()
    {
        return [
           'value' => $this->value,
           'encoding' => $this->encoding,
           'digest' => $this->digest,
           'key' => $this->key,
       ];
    }
}
