<?php

namespace Database\Seeders;

use App\Models\HomepageHeroSlide;
use Illuminate\Database\Seeder;

class HeroSlideSeeder extends Seeder
{
    public function run(): void
    {
        $slides = self::slides();

        HomepageHeroSlide::query()->whereNotIn('sort_order', collect($slides)->pluck('sort_order'))->delete();

        foreach ($slides as $slide) {
            HomepageHeroSlide::updateOrCreate(
                ['sort_order' => $slide['sort_order']],
                array_merge($slide, ['is_active' => true])
            );
        }
    }

    /** @return array<int, array<string, mixed>> */
    public static function slides(): array
    {
        return [
            [
                'category' => '01',
                'title' => 'Data Center Planning & Consulting',
                'description' => 'Expert guidance from initial concept, feasibility, site selection, and capacity planning.',
                'image' => 'Video/home-hero.mp4',
                'cta_text' => 'Read More',
                'cta_url' => '/services',
                'sort_order' => 1,
            ],
            [
                'category' => '02',
                'title' => 'Design & Infrastructure Engineering',
                'description' => 'Complete design support for power, cooling, networking, security, fire protection, and IT infrastructure.',
                'image' => 'Video/home-hero.mp4',
                'cta_text' => 'Read More',
                'cta_url' => '/services',
                'sort_order' => 2,
            ],
            [
                'category' => '03',
                'title' => 'Data Center Build & Implementation',
                'description' => 'End-to-end support for construction, infrastructure installation, equipment deployment, and commissioning.',
                'image' => 'Video/home-hero.mp4',
                'cta_text' => 'Read More',
                'cta_url' => '/services',
                'sort_order' => 3,
            ],
            [
                'category' => '04',
                'title' => 'Power, Cooling & Critical Systems',
                'description' => 'Design and implementation of reliable UPS, generators, electrical systems, cooling, monitoring, and redundancy.',
                'image' => 'Video/home-hero.mp4',
                'cta_text' => 'Read More',
                'cta_url' => '/services',
                'sort_order' => 4,
            ],
            [
                'category' => '05',
                'title' => 'Testing, Commissioning & Operational Support',
                'description' => 'Comprehensive testing, system validation, commissioning, documentation, and ongoing technical support.',
                'image' => 'Video/home-hero.mp4',
                'cta_text' => 'Read More',
                'cta_url' => '/services',
                'sort_order' => 5,
            ],
        ];
    }
}
