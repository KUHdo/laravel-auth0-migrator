<?php

namespace KUHdo\LaravelAuth0Migrator\JsonSchema;

class Email extends JsonSchema
{
    protected array $required = [
        'value',
    ];

    /**
     * The email address for MFA.
     */
    protected string $value;

    public function toArray()
    {
        return [
            'value' => $this->value,
        ];
    }
}
