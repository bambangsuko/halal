<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExternalApp extends Model
{

    protected $fillable = [
        'link', 'title', 'logo'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($app) {
            removeFile($app->logo);
        });
    }
}
