<?php

namespace App\Repositories;

use App\Menu;
use App\Post;

class BreadcrumbRepository {

    public function generateByMenuId($id) {
        $breadcrumb = array();
        $menu = Menu::with('parent')->findOrFail($id);
        while ($menu->parent) {
            array_push($breadcrumb, $menu);
            $menu = Menu::with('parent')->findOrFail($menu->parent->id);
        }
        if ($menu->parent == null) {
            $menu = Menu::findOrFail($menu->id);
            array_push($breadcrumb, $menu);
        }
        return array_reverse($breadcrumb);
    }

    public function generateByPostId($id) {
        $breadcrumb = array();
        $post = Post::with('menu')->findOrFail($id);
        array_push($breadcrumb, $post);
        $menu = Menu::with('parent')->findOrFail($post->menu->id);
        while ($menu->parent) {
            array_push($breadcrumb, $menu);
            $menu = Menu::with('parent')->findOrFail($menu->parent->id);
        }
        if ($menu->parent == null) {
            $menu = Menu::findOrFail($menu->id);
            array_push($breadcrumb, $menu);
        }
        return array_reverse($breadcrumb);
    }

}
