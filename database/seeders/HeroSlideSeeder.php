<?php

namespace Database\Seeders;

use App\Models\HomepageHeroSlide;
use Illuminate\Database\Seeder;

class HeroSlideSeeder extends Seeder
{
    public function run(): void
    {
        if (HomepageHeroSlide::count() > 0) {
            return;
        }

        $slides = [
            ['category' => 'Data Centre', 'title' => 'VDC800 Oslo DC-1 Delivers 45MW of Enterprise Power', 'description' => 'Our flagship Nordic facility delivers 45MW with a PUE of 1.12 — enterprise-grade colocation built for the future of digital infrastructure.', 'image' => 'images/hero-slide-1.jpg', 'cta_text' => 'Read More', 'cta_url' => '/data-centre', 'sort_order' => 1],
            ['category' => 'Cloud Connectivity', 'title' => 'Direct On-Ramps to AWS, Azure and Google Cloud', 'description' => 'Accelerate hybrid cloud strategies with low-latency cross-connects and carrier-neutral connectivity from our Oslo meet-me room.', 'image' => 'images/hero-slide-2.jpg', 'cta_text' => 'Read More', 'cta_url' => '/services', 'sort_order' => 2],
            ['category' => 'Operations', 'title' => 'Tier III+ Design Across All Nordic Facilities', 'description' => 'Concurrent maintainability, 24/7 NOC monitoring, and published availability metrics for mission-critical workloads.', 'image' => 'images/hero-slide-3.jpg', 'cta_text' => 'Read More', 'cta_url' => '/about', 'sort_order' => 3],
            ['category' => 'Enterprise Security', 'title' => 'Tier III+ Architecture with Defense-in-Depth Security', 'description' => 'Biometric access, 24/7 NOC monitoring, and multi-layer physical security protect your most critical workloads around the clock.', 'image' => 'images/hero-slide-4.jpg', 'cta_text' => 'Read More', 'cta_url' => '/solutions', 'sort_order' => 4],
            ['category' => 'Colocation', 'title' => 'Scale From Single Racks to 500-Rack Deployments', 'description' => 'Flexible power density up to 50kW per rack with modular hall design — grow your infrastructure without service interruption.', 'image' => 'images/hero-slide-5.jpg', 'cta_text' => 'Read More', 'cta_url' => '/contact', 'sort_order' => 5],
        ];

        foreach ($slides as $slide) {
            HomepageHeroSlide::create(array_merge($slide, ['is_active' => true]));
        }
    }
}
