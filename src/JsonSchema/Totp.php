<?php

namespace Kuhdo\LaravelAuth0Migrator\JsonSchema;

class Totp extends JsonSchema
{
    protected bool $additionalProperties = false;

    protected string $secret;

    public function secret(string $secret): Totp
    {
        $this->secret = $secret;

        return $this;
    }

    public function toArray()
    {
        return [
          "secret" => $this->secret,
        ];
    }
}