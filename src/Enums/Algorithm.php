<?php

namespace KUHdo\LaravelAuth0Migrator\Enums;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

enum Algorithm: string implements Jsonable, Arrayable
{
    case ARGON2 = 'argon2';
    case BCRYPT = 'bcrypt';
    case HMAC = 'hmac';
    case LADAP = 'ldap';
    case MD4 = 'md4';
    case MD5 = 'md5';
    case SHA1 = 'sha1';
    case SHA256 = 'sha256';
    case SHA512 = 'sha512';
    case PBKDF2 = 'pbkdf2';

    /**
     * @inheritdoc
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray());
    }

    /**
     * @inheritdoc
     */
    public function toArray()
    {
        return [
            'alogirthm' => $this->value,
        ];
    }
}
