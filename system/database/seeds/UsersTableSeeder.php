<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@bankcapital.com',
            'email_verified_at' => now(),
            'username' => 'admin',
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
            'created_at' => now()
        ]);
    }
}
