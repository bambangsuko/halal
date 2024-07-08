<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model {
    
    public $timestamps = false;

    protected $fillable = [
        'post_id', 'title', 'file', 'order', 'is_downloadable'
    ];
    
    public function post() {
        return $this->belongsTo('App\Post');
    }
    
    public function scopeIsDownloadable($query) {
        return $query->where('is_downloadable', 1);
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function($file) {
            removeFile($file->file);
        });
    }

}
