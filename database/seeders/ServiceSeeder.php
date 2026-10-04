<?php

namespace Database\Seeders;

class ServiceSeeder extends ServiceSolutionSeeder
{
    /**
     * Seed published advisory services.
     * Run alone: php artisan db:seed --class=ServiceSeeder
     */
    public function run(): void
    {
        $this->seedServicesOnly();
    }
}
