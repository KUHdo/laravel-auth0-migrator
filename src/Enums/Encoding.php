<?php

namespace KUHdo\LaravelAuth0Migrator\Enums;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

enum Encoding: string implements Arrayable, Jsonable
{
    case BASE64 = 'base64';
    case HEX = 'hex';
    case UTF8 = 'utf8';

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
