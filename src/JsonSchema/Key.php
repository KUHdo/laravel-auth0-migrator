<?php

namespace KUHdo\LaravelAuth0Migrator\JsonSchema;

use KUHdo\LaravelAuth0Migrator\Enums\Encoding;

class Key  extends JsonSchema
{
    protected array $required = [
      'value'
    ];

    protected string $value;

    protected ?Encoding $encoding;

    public function encoding(?Encoding $encoding): Key
    {
        $this->encoding = $encoding;

        return $this;
    }

    public function value(string $value): Key
    {
        $this->value = $value;

        return $this;
    }

    public function toArray()
    {
        return [
          'value' => $this->value,
          'encoding' => $this->encoding,
        ];
    }
}