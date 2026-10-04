<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ServiceSeeder::class,
            SolutionSeeder::class,
            DataCentreSeeder::class,
            BlogSeeder::class,
            NavMenuSeeder::class,
        ]);
    }
}
