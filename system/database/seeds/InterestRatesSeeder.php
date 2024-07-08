<?php

use Illuminate\Database\Seeder;

class InterestRatesSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('interest_rates')->insert([
            [
                'key' => 'minimum',
                'value' => '8000000',
                'created_at' => now()
            ],
            [
                'key' => '1',
                'value' => '4.25',
                'created_at' => now()
            ],
            [
                'key' => '2',
                'value' => '4.25',
                'created_at' => now()
            ],
            [
                'key' => '3',
                'value' => '4.5',
                'created_at' => now()
            ],
            [
                'key' => '4',
                'value' => '4.5',
                'created_at' => now()
            ],
            [
                'key' => '6',
                'value' => '4.25',
                'created_at' => now()
            ],
            [
                'key' => '12',
                'value' => '4.25',
                'created_at' => now()
            ]
        ]);
    }

}
