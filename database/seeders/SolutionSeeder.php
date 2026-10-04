<?php

namespace Database\Seeders;

use App\Models\Solution;
use Database\Seeders\Support\LongFormSeoContent;
use Database\Seeders\Support\SeedsCatalogImages;
use Database\Seeders\Support\SolutionCatalog;
use Illuminate\Database\Seeder;

class SolutionSeeder extends Seeder
{
    use SeedsCatalogImages;

    /**
     * Seed published solutions (images, SEO body, metadata).
     * Run alone: php artisan db:seed --class=SolutionSeeder
     * Then refresh nav: php artisan db:seed --class=NavMenuSeeder
     */
    public function run(): void
    {
        $this->seedSolutionImages();

        Solution::query()->delete();

        foreach (SolutionCatalog::definitions() as $index => $solution) {
            $num = $index + 1;
            $imagePath = "images/solutions/solution-{$num}.jpg";
            $keywords = $solution['keywords'];
            $tableRows = $solution['table_rows'];
            unset($solution['keywords'], $solution['table_rows']);

            Solution::create(array_merge($solution, [
                'featured_image' => $imagePath,
                'og_image' => $imagePath,
                'description' => LongFormSeoContent::solutionBody(
                    $solution['title'],
                    $solution['slug'],
                    $solution['benefits'],
                    $tableRows,
                    $keywords,
                ),
                'meta_title' => LongFormSeoContent::metaTitle($solution['title'], 'D³ DataCenters', 'Enterprise Data Centre Solutions'),
                'meta_description' => LongFormSeoContent::metaDescription($solution['title'], 'solution', $keywords),
            ]));
        }
    }
}
