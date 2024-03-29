<?php

namespace KUHdo\LaravelAuth0Migrator\Enums;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

enum PasswordEncoding: string implements Arrayable, Jsonable
{
    case ASCII = 'ascii';
    case UTF8 = 'utf8';
    case UTF16LE = 'utf16le';
    case UCS2 = 'ucs2';
    case LATIN1 = 'latin1';
    case BINARY = 'binary';

    /**
     * {@inheritdoc}
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray());
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return [
            'encoding' => $this->value,
        ];
    }
}
