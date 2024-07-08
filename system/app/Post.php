<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{

    use Translatable;

    protected $fillable = [
        'cover',
        'menu_id',
        'is_published',
        'template',
        'external_link',
        'is_pinned',
        'created_at'
    ];
    protected $dates = ['created_at'];
    public $translatedAttributes = [
        'title', 'slug', 'description'
    ];

    public function menu()
    {
        return $this->belongsTo('App\Menu');
    }

    public function files()
    {
        return $this->hasMany('App\File')->orderBy('order', 'desc');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($post) {
            removeFile($post->cover);
            removeFile($post->thumbnail);
            foreach ($post->files as $file) {
                removeFile($file->file);
            }
            $post->files()->delete();
        });
    }

    public function getFormattedPublishedAtAttribute()
    {
        if (app()->getLocale() == 'id') {
            setlocale(LC_TIME, app()->getLocale());
        }
        return \Carbon\Carbon::parse($this->created_at)->formatLocalized('%d %B %Y');
    }

    public function scopeIsActive($query)
    {
        return $query->where('is_published', 1);
    }

    public function scopeIsPinned($query)
    {
        return $query->where('is_pinned', 1);
    }

    // public function scopeIsRunningText($query) {
    //     return $query->where('is_running_text', 1);
    // }

    // public function scopeIsFeaturedProduct($query) {
    //     return $query->where('is_featured_product', 1);
    // }

    public function translations()
    {
        return $this->hasMany(PostTranslation::class);
    }
}
