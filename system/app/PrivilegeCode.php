<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrivilegeCode extends Model {

    protected $fillable = [
        'name', 'url', 'description'
    ];

}
