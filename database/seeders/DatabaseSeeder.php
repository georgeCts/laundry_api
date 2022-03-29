<?php

namespace Database\Seeders;

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
        $this->call(ConfigurationsSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(UnitTypeSeeder::class);
        $this->call(ServicesCatalogSeeder::class);
    }
}
