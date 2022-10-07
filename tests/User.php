<?php

namespace KUHdo\LaravelAuth0Migrator\Tests;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * @var string
     */
    protected $table = 'users';
}
