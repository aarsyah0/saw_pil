<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            // AllTablesSeeder::class,
            // UsersSeeder::class,
            // HeroSlidesTableSeeder::class,
            // HeroFeaturesTableSeeder::class,
            // PurposesTableSeeder::class,
            // RequirementsTableSeeder::class,
            // SchedulesTableSeeder::class,
            // PesertaDummySeeder::class,
            RekapitulasiTahunanSeeder::class,
        ]);

    }
}
// Compare this snippet from database/seeders/SchedulesTableSeeder.php:
