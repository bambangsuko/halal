<?php

namespace App;

class Template {

    public static function menu() {
        $templates = array();
        foreach (\File::allFiles(resource_path('views/templates/menu')) as $file) {
            array_push($templates, "templates.menu.{$file->getBasename('.blade.php')}");
        }

        return $templates;
    }

    public static function post() {
        $templates = array();
        foreach (\File::allFiles(resource_path('views/templates/post/')) as $file) {
            array_push($templates, "templates.post.{$file->getBasename('.blade.php')}");
        }

        return $templates;
    }

}
