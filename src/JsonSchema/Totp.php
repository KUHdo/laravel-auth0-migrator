<?php

namespace KUHdo\LaravelAuth0Migrator\JsonSchema;

class Totp extends JsonSchema
{
    protected string $secret;

    public function secret(string $secret): self
    {
        $this->secret = $secret;

        return $this;
    }

    public function toArray()
    {
        return [
          'secret' => $this->secret,
        ];
    }
}
