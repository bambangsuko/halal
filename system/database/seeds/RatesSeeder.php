<?php

use Illuminate\Database\Seeder;

class RatesSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('rates')->insert([
            [
                'name' => 'USD',
                'created_at' => now()
            ],
            [
                'name' => 'EUR',
                'created_at' => now()
            ],
            [
                'name' => 'SGD',
                'created_at' => now()
            ],
            [
                'name' => 'AUD',
                'created_at' => now()
            ],
            [
                'name' => 'CNY',
                'created_at' => now()
            ],
            [
                'name' => 'JPY',
                'created_at' => now()
            ]
        ]);
    }

}
