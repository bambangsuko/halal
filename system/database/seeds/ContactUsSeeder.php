<?php

use Illuminate\Database\Seeder;

class ContactUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = [
            [
                'id' => 'Butuh Bantuan ?',
                'en' => 'Need Help ?'
            ]
        ];

        foreach ($posts as $post) {
            $postId = DB::table('posts')->insertGetId([
                'cover' => null,
                'menu_id' => 5,
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
