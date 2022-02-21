<?php

namespace Kuhdo\LaravelAuth0Migrator\JsonSchema;

use Kuhdo\LaravelAuth0Migrator\Enums\PasswordEncoding;

class Password extends JsonSchema
{
    public ?PasswordEncoding $encoding;

    public function encoding(?PasswordEncoding $encoding): Password
    {
        $this->encoding = $encoding;

        return $this;
    }

    public function toArray()
    {
        return [
            'encoding' => $this->encoding,
        ];
    }
}