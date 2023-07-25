<?php

namespace KUHdo\LaravelAuth0Migrator\Enums;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

enum Digest: string implements Jsonable, Arrayable
{
    case md4 = 'md4';
    case md5 = 'md5';
    case ripemd160 = 'ripemd160';
    case sha1 = 'sha1';
    case sha224 = 'sha224';
    case sha256 = 'sha256';
    case sha384 = 'sha384';
    case sha512 = 'sha512';
    case whirlpool = 'whirlpool';

    /**
     * @inheritdoc
     */
    public function toArray()
    {
        return [
            'digest' => $this->value
        ];
    }

    /**
     * @inheritdoc
     */
    public function toJson($options = 0)
    {
        json_encode($this->toArray());
    }
}