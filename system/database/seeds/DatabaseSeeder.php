<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(SettingsSeeder::class);
        $this->call(MenusSeeder::class);
        $this->call(AreasSeeder::class);
        $this->call(PageSeeder::class);
        $this->call(AboutUsSeeder::class);
        $this->call(ContactUsSeeder::class);
        $this->call(PeristiwaPentingSeeder::class);
        $this->call(RatesSeeder::class);
        $this->call(InterestRatesSeeder::class);
    }
}
