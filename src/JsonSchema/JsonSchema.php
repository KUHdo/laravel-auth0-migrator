<?php

namespace KUHdo\LaravelAuth0Migrator\JsonSchema;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

abstract class JsonSchema implements Arrayable, Jsonable
{
    abstract public function toArray();

    public function toJson($options = 0)
    {
        return json_encode($this->toArray());
    }
}