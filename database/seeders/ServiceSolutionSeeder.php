<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * @deprecated Prefer ContentSeeder or individual ServiceSeeder / SolutionSeeder.
 */
class ServiceSolutionSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ServiceSeeder::class,
            SolutionSeeder::class,
        ]);
    }
}
