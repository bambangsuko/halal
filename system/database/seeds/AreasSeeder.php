<?php

use Illuminate\Database\Seeder;

class AreasSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('areas')->insert([
            [
                'name' => 'Jakarta Timur',
                'created_at' => now()
            ],
            [
                'name' => 'Jakarta Barat',
                'created_at' => now()
            ],
            [
                'name' => 'Jakarta Utara',
                'created_at' => now()
            ],
            [
                'name' => 'Jakarta Selatan',
                'created_at' => now()
            ],
            [
                'name' => 'Jakarta Pusat',
                'created_at' => now()
            ],
            [
                'name' => 'Bandung',
                'created_at' => now()
            ],
            [
                'name' => 'Solo',
                'created_at' => now()
            ],
            [
                'name' => 'Surabaya',
                'created_at' => now()
            ],
        ]);
    }

}
