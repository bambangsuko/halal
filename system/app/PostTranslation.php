<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class PostTranslation extends Model
{

    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            $post->slug = self::generateSlug($post);
        });

        static::updating(function ($post) {
            $currentPost = self::findOrFail($post->id);

            if ($post->title !== $currentPost->title) {
                $post->slug = self::generateSlug($post);
            } else {
                $post->slug = $currentPost->slug;
            }
        });
    }

    private static function generateSlug($post)
    {
        $slug = Str::slug($post->title, '-');

        if (!static::where('slug', $slug)->get()->isEmpty()) {
            $i = 1;
            $newSlug = $slug . '-' . $i;
            while (!static::where('slug', $newSlug)->get()->isEmpty()) {
                $i++;
                $newSlug = $slug . '-' . $i;
            }
            $slug = $newSlug;
        }

        return $slug;
    }

    public function post()
    {
        return $this->belongTo(Post::class);
    }
}
