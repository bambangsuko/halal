<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model {

    protected $fillable = [
        'role_id', 'privilege_code_id'
    ];
    
    public function role() {
        return $this->belongsTo('App\Role');
    }
    
    public function privilegecode() {
        return $this->belongsTo('App\PrivilegeCode', 'privilege_code_id');
    }

}
