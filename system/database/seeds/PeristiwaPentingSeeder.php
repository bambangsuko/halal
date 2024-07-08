<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class PeristiwaPentingSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $menus = [
            [
                'id' => 'CSR',
                'en' => 'CSR',
            ],
            [
                'id' => 'Event',
                'en' => 'Event',
            ],
            [
                'id' => 'Berita',
                'en' => 'News',
            ]
        ];

        foreach ($menus as $menu) {
            $menuId = DB::table('menus')->insertGetId([
                'parent_id' => 7,
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
