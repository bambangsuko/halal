<?php

use Illuminate\Database\Seeder;

class PageSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $posts = [
            [
                'id' => 'Syarat & Ketentuan',
                'en' => 'Terms & Conditions'
            ],
            [ 'id' => 'Privacy Statement',
                'en' => 'Privacy Statement'
            ]
        ];

        foreach ($posts as $post) {
            $postId = DB::table('posts')->insertGetId([
                'cover' => null,
                'menu_id' => 6,
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
    }

}
