<?php

namespace KUHdo\LaravelAuth0Migrator\Enums;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

enum Position: string implements Arrayable, Jsonable
{
    case PREFIX = 'prefix';
    case SUFFIX = 'suffix';

    public function toArray()
    {
        return [

            'position' => $this->value
        ];
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray());
    }
}