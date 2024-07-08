<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'image', 'caption', 'link', 'order'
    ];

    public static function boot()
    {
        parent::boot();

        static::deleting(function($slider) {
            removeFile($slider->image);
        });
    }

    public function scopeOrder($query)
    {
        return $query->orderBy('order', 'asc');
    }

    public function next(){
        return $this->order()
                ->where('order', '>', $this->order)
                ->first();

    }
    public function previous(){
        return $this->order()
                ->where('order', '<', $this->order)
                ->get()->last();
    }
}
