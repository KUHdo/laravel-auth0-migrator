<?php

namespace KUHdo\LaravelAuth0Migrator\JsonSchema;

use Illuminate\Support\Traits\Macroable;

abstract class MetaData extends JsonSchema
{
    use Macroable;

    public function __construct(protected ?array $properties = null)
    {
        if ($this->isEmpty()) {
           $this->properties = null;
        }
    }

    public function isEmpty(): bool
    {
        return empty($this->properties);
    }

    public function toArray(): ?array
    {
        return $this->properties;
    }
}
