<?php

namespace Database\Seeders;

use App\Models\Service;
use Database\Seeders\Support\LongFormSeoContent;
use Database\Seeders\Support\ServiceCatalog;
use Database\Seeders\Support\SeedsCatalogImages;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    use SeedsCatalogImages;

    /**
     * Seed published advisory services.
     * Run alone: php artisan db:seed --class=ServiceSeeder
     */
    public function run(): void
    {
        $this->seedServiceImages();

        Service::query()->delete();

        foreach (ServiceCatalog::definitions() as $index => $service) {
            $num = $index + 1;
            $imagePath = "images/services/service-{$num}.jpg";
            $keywords = $service['keywords'];
            $items = $service['items'];
            unset($service['keywords'], $service['items']);

            Service::create(array_merge($service, [
                'featured_image' => $imagePath,
                'og_image' => $imagePath,
                'items' => $items,
                'full_description' => LongFormSeoContent::advisoryServiceBody(
                    $service['title'],
                    $service['short_description'],
                    $items,
                    $keywords,
                ),
                'meta_title' => LongFormSeoContent::metaTitle($service['title']),
                'meta_description' => LongFormSeoContent::metaDescription($service['title'], 'service', $keywords),
            ]));
        }
    }
}
