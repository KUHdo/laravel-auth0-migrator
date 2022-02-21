<?php

namespace Kuhdo\LaravelAuth0Migrator\JsonSchema;

use Kuhdo\LaravelAuth0Migrator\Enums\Encoding;
use Kuhdo\LaravelAuth0Migrator\Enums\Position;

class Salt extends JsonSchema
{
    protected array $required = [
        'value',
        'position',
    ];

    protected ?string $value;

    protected ?Position $position;

    protected ?Encoding $encoding;

     public function value(string $value): Salt
    {
        $this->value = $value;

        return $this;
    }

    public function position(Position $position): Salt
    {
        $this->position = $position;

        return $this;
    }

    public function encoding(?Encoding $encoding): Salt
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