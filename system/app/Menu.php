<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class Menu extends Model
{

    use Translatable;

    protected $fillable = [
        'cover',
        'is_published',
        'template',
        'parent_id',
        'place',
        'type',
        'link',
        'order',
        'address',
        'phone',
        'fax',
        'email',
        'website',
        'is_homepage'
    ];
    public $translatedAttributes = [
        'title', 'slug', 'description'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($menu) {
            removeFile($menu->cover);
        });
    }

    // public function posts() {
    //     return $this->hasMany('App\Post')->where('is_published', 1);
    // }
    // public function submenu() {
    //     return $this->hasMany('App\Menu', 'parent_id', 'id')->where('is_published', 1);
    // }    
    public function posts()
    {
        return $this->hasMany('App\Post')->orderBy('created_at', 'DESC');
    }

    public function submenus()
    {
        return $this->hasMany('App\Menu', 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo('App\Menu', 'parent_id', 'id');
    }

    public function scopeIsMainMenu($query)
    {
        return $query->where('place', 'mainmenu');
    }

    public function scopeIsSecondaryMenu($query)
    {
        return $query->where('place', 'secondarymenu');
    }

    public function scopeIsHomepageMenu($query)
    {
        return $query->where('place', 'homepage');
    }

    public function scopeIsOnHomepage($query)
    {
        return $query->where('is_homepage', 1);
    }

    public function scopeIsActive($query)
    {
        return $query->where('is_published', 1);
    }

    public function scopeOrder($query)
    {
        return $query->orderBy('order', 'asc');
    }

    public function next()
    {
        return $this->order()
            ->where('order', '>', $this->order)
            ->where('type', $this->type)
            ->where('parent_id', $this->parent_id)
            ->first();
    }

    public function previous()
    {
        return $this->order()
            ->where('order', '<', $this->order)
            ->where('type', $this->type)
            ->where('parent_id', $this->parent_id)
            ->get()->last();
    }

    public function getFormattedPublishedAtAttribute()
    {
        if (app()->getLocale() == 'id') {
            setlocale(LC_TIME, app()->getLocale());
        }
        return \Carbon\Carbon::parse($this->created_at)->formatLocalized('%d %B %Y');
    }
    // public function scopeIsIndividual($query)
    // {
    //     return $query->where('id', 1);
    // }

    // public function scopeIsBusiness($query)
    // {
    //     return $query->where('id', 2);
    // }

    // public function scopeIsAboutUs($query)
    // {
    //     return $query->where('id', 3);
    // }

    // public function scopeIsSpecialProgram($query)
    // {
    //     return $query->where('id', 4);
    // }
}
