<?php

namespace Kuhdo\LaravelAuth0Migrator\JsonSchema;

use Kuhdo\LaravelAuth0Migrator\Enums\Digest;
use Kuhdo\LaravelAuth0Migrator\Enums\Encoding;

class Hash  extends JsonSchema
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

    public function value(?string $value): Hash
    {
        $this->value = $value;

        return $this;
    }

    public function encoding(?Encoding $encoding): Hash
    {
        $this->encoding = $encoding;

        return $this;
    }

    public function digest(?Digest $digest): Hash
    {
        $this->digest = $digest;

        return $this;
    }

    public function key(?Key $key): Hash
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