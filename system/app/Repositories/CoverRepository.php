<?php

namespace App\Repositories;

use App\Menu;
use App\Post;

class CoverRepository {

    public function getByMenuId($id) {
        $menu = Menu::findOrFail($id);
        while (empty($menu->cover)) {
            if ($menu->parent_id == 0) {
                return $menu->cover;
            } else {
                $menu = Menu::findOrFail($menu->parent_id);
            }
        }
        return $menu->cover;
    }

    public function getByPostId($id) {
        $post = Post::with('menu')->findOrFail($id);
        if ($post->cover) {
            return $post->cover;
        } else {
            $menu = Menu::findOrFail($post->menu->id);
            while (empty($menu->cover)) {
                if ($menu->parent_id == 0) {
                    return $menu->cover;
                } else {
                    $menu = Menu::findOrFail($menu->parent_id);
                }
            }
            return $menu->cover;
        }
    }

}
