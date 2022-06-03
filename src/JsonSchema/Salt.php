<?php

namespace KUHdo\LaravelAuth0Migrator\JsonSchema;

use KUHdo\LaravelAuth0Migrator\Enums\Encoding;
use KUHdo\LaravelAuth0Migrator\Enums\Position;

class Salt extends JsonSchema
{
    protected array $required = [
        'value',
        'position',
    ];

    protected ?string $value;

    protected ?Position $position;

    protected ?Encoding $encoding;

    public function value(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function position(Position $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function encoding(?Encoding $encoding): self
    {
        $this->encoding = $encoding;

        return $this;
    }

    public function toArray()
    {
        return [
            'value' => $this->value,
            'encoding' => $this->encoding,
            'position' => $this->position,
        ];
    }
}
