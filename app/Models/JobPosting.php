<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobPosting extends Model
{
    protected $connection = 'tenant';
    protected $fillable = [
        'uuid',
        'title',
        'description',
        'location',
        'salary'
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (! $model->uuid) $model->uuid = \Ramsey\Uuid\Uuid::uuid4()->toString();
        });
    }
}
