<?php

namespace Database\Seeders;

class SolutionSeeder extends ServiceSolutionSeeder
{
    /**
     * Seed published solutions (images, SEO body, metadata).
     * Run alone: php artisan db:seed --class=SolutionSeeder
     * Then refresh nav: php artisan db:seed --class=NavMenuSeeder
     */
    public function run(): void
    {
        $this->seedSolutionsOnly();
    }
}
