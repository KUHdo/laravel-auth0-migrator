<?php

namespace KUHdo\LaravelAuth0Migrator\JsonSchema;

class Phone extends JsonSchema
{
    protected array $required = [
        'value',
    ];

    protected bool $additionalProperties = false;

    /**
     * The phone number for SMS MFA. The phone number should include a country code
     * and begin with +, such as: +12125550001
     * pattern": "^\\+[0-9]{1,15}$".
     */
    protected string $value;

    public function value(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function toArray()
    {
        return  [
            'value' => $this->value,
        ];
    }
}
