<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ExperiencesSeeder::class,
            Job_TypesSeeder::class,
            Profile_CategoriesSeeder::class,
            SpecialitiesSeeder::class,
            // Add other seeders here as needed.
        ]);
    }
}