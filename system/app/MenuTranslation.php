<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class MenuTranslation extends Model {

    public $timestamps = false;

    public static function boot() {
        parent::boot();

        static::creating(function($menu) {
            $menu->slug = self::generateSlug($menu);
        });

        static::updating(function($menu) {
            $currentMenu = self::findOrFail($menu->id);

            if ($menu->title !== $currentMenu->title) {
                $menu->slug = self::generateSlug($menu);
            } else {
                $menu->slug = $currentMenu->slug;
            }
        });
    }

    private static function generateSlug($menu) {
        $slug = Str::slug($menu->title, '-');

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

}
