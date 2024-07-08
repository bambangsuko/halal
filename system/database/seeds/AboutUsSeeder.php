<?php

use Illuminate\Database\Seeder;

class AboutUsSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $posts = [
            [
                'id' => 'Lokasi',
                'en' => 'Location'
            ]
        ];

        foreach ($posts as $post) {
            $postId = DB::table('posts')->insertGetId([
                'cover' => null,
                'menu_id' => 3,
                'is_published' => 1,
                'is_running_text' => 0,
                'template' => 'templates.post.index',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            foreach (['id', 'en'] as $locale) {
                DB::table('post_translations')->insert([
                    [
                        'post_id' => $postId,
                        'title' => $post[$locale],
                        'slug' => Str::slug($post[$locale], '-'),
                        'description' => '-',
                        'locale' => $locale
                    ]
                ]);
            }
        }

        $menus = [
            [
                'id' => 'Peristiwa Penting',
                'en' => 'Peristiwa Penting',
            ],
            [
                'id' => 'Karir',
                'en' => 'Career',
            ]
        ];

        foreach ($menus as $menu) {
            $menuId = DB::table('menus')->insertGetId([
                'parent_id' => 3,
                'cover' => null,
                'is_published' => 1,
                'template' => 'templates.menu.tile',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            foreach (['id', 'en'] as $locale) {
                DB::table('menu_translations')->insert([
                    [
                        'menu_id' => $menuId,
                        'title' => $menu[$locale],
                        'slug' => Str::slug($menu[$locale], '-'),
                        'description' => '-',
                        'locale' => $locale
                    ]
                ]);
            }
        }
    }

}
