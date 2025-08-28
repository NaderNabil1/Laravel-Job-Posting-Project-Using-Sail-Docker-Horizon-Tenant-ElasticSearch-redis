<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'db_host',
        'db_port',
        'db_database',
        'db_username',
        'db_password'
    ];
}
