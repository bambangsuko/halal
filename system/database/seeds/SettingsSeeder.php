<?php

use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            [
                'key' => 'name',
                'value' => 'Bank Capital',
                'created_at' => now()
            ],
            [
                'key' => 'tagline',
                'value' => '-',
                'created_at' => now()
            ],
            [
                'key' => 'description',
                'value' => '-',
                'created_at' => now()
            ],
            [
                'key' => 'icon',
                'value' => '',
                'created_at' => now()
            ],
            [
                'key' => 'logo',
                'value' => '',
                'created_at' => now()
            ],
            [
                'key' => 'address',
                'value' => 'Menara Jamsostek 6th Floor, Jl. Jendral Gatot Subroto Kav 38, Jakarta Selatan 12710',
                'created_at' => now()
            ],
            [
                'key' => 'phone',
                'value' => '+6221-27938989',
                'created_at' => now()
            ],
            [
                'key' => 'fax',
                'value' => '+6221-27938900',
                'created_at' => now()
            ],
            [
                'key' => 'email',
                'value' => 'corporate@bankcapital.co.id',
                'created_at' => now()
            ],
            [
                'key' => 'award',
                'value' => '',
                'created_at' => now()
            ],
            [
                'key' => 'internet_banking_cover',
                'value' => '',
                'created_at' => now()
            ],
            [
                'key' => 'internet_banking_link',
                'value' => '',
                'created_at' => now()
            ],
            [
                'key' => 'mobile_banking_link',
                'value' => '',
                'created_at' => now()
            ]
        ]);
    }
}
