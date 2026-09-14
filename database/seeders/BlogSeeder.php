<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedImages();

        $categories = [
            ['name' => 'Data Centre Insights', 'slug' => 'data-centre-insights', 'description' => 'Facility design, operations, and Nordic infrastructure trends.', 'sort_order' => 1],
            ['name' => 'Operations', 'slug' => 'operations', 'description' => 'Facility operations, PUE optimisation, and data centre best practices.', 'sort_order' => 2],
            ['name' => 'Cloud & Connectivity', 'slug' => 'cloud-connectivity', 'description' => 'Hybrid cloud, cross-connects, and carrier-neutral networking.', 'sort_order' => 3],
            ['name' => 'Security & Compliance', 'slug' => 'security-compliance', 'description' => 'Security frameworks, physical security, and regulatory readiness.', 'sort_order' => 4],
            ['name' => 'Industry News', 'slug' => 'industry-news', 'description' => 'Market updates and VDC800 announcements from across Northern Europe.', 'sort_order' => 5],
        ];

        $categoryIds = [];
        foreach ($categories as $cat) {
            $categoryIds[] = BlogCategory::create(array_merge($cat, ['status' => 'published']))->id;
        }

        $titles = [
            ['Understanding Tier III+ Architecture in Nordic Facilities', 0],
            ['How Free-Air Cooling Cuts Data Centre Energy Use', 0],
            ['Direct Cloud On-Ramps: AWS, Azure and Google Cloud', 2],
            ['Security Compliance: What It Means for Your Workloads', 3],
            ['Oslo DC-1 Expansion Adds 15MW Capacity', 4],
            ['PUE Benchmarks: Comparing Nordic vs European Averages', 0],
            ['How We Deliver 99.999% Uptime SLAs', 1],
            ['Building Carrier-Neutral Meet-Me Rooms', 2],
            ['Biometric Access Control Best Practices', 3],
            ['Liquid Cooling for High-Density AI Racks', 0],
            ['Capacity Reporting for Enterprise Colocation Clients', 1],
            ['Multi-Cloud Networking Without Internet Transit', 2],
            ['GDPR-Ready Infrastructure for Financial Services', 3],
            ['VDC800 Expands Nordic Interconnect Footprint', 4],
            ['Remote Hands Support: What to Expect 24/7', 0],
            ['Heat Recovery Systems in Urban Data Centres', 1],
            ['Latency Optimisation for Trading Platforms', 2],
            ['Disaster Recovery Planning in Tier III+ Sites', 3],
            ['Nordic Data Centre Market Outlook 2026', 4],
            ['Scaling From Single Racks to Full Suites', 0],
        ];

        foreach ($titles as $index => [$title, $catIndex]) {
            $num = $index + 1;
            BlogPost::create([
                'blog_category_id' => $categoryIds[$catIndex],
                'title' => $title,
                'slug' => \Illuminate\Support\Str::slug($title),
                'excerpt' => $this->excerpt($title),
                'body' => $this->body($title, $categories[$catIndex]['name']),
                'featured_image' => "images/blog/blog-{$num}.jpg",
                'author' => 'VDC800 Team',
                'meta_title' => $title . ' — VDC800 Blog',
                'meta_description' => $this->excerpt($title),
                'published_at' => now()->subDays(20 - $index),
                'sort_order' => $num,
                'status' => 'published',
            ]);
        }
    }

    private function seedImages(): void
    {
        $sources = [
            'hero-slide-1.jpg', 'hero-slide-2.jpg', 'hero-slide-3.jpg',
            'hero-slide-4.jpg', 'hero-slide-5.jpg', 'hero-datacenter.jpg',
            'data-centre-facility.jpg', 'about-technology.jpg',
        ];

        $dir = public_path('images/blog');
        if (! File::isDirectory($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        for ($i = 1; $i <= 20; $i++) {
            $source = public_path('images/'.$sources[($i - 1) % count($sources)]);
            $dest = $dir."/blog-{$i}.jpg";
            if (File::exists($source)) {
                File::copy($source, $dest);
            }
        }
    }

    private function excerpt(string $title): string
    {
        return "Explore {$title} with practical guidance from VDC800 infrastructure specialists operating Nordic data centres.";
    }

    private function body(string $title, string $category): string
    {
        return <<<HTML
<p>{$title} is a critical topic for organisations deploying mission-critical workloads across Northern Europe. At VDC800, we combine engineering discipline with operational excellence to help enterprises make informed infrastructure decisions that balance performance, compliance, and reliability.</p>
<p>Modern data centre strategy requires more than rack space — it demands transparent metrics, resilient design, and partnerships that scale with your business. The following overview summarises key benchmarks our clients evaluate when planning colocation, cloud connectivity, and managed services in the {$category} space.</p>
<h3>Key Metrics at a Glance</h3>
<table>
    <thead>
        <tr>
            <th>Metric</th>
            <th>Industry Average</th>
            <th>VDC800 Target</th>
            <th>Notes</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>PUE</td>
            <td>1.55</td>
            <td>1.12–1.18</td>
            <td>Nordic climate enables free-air cooling</td>
        </tr>
        <tr>
            <td>NOC Coverage</td>
            <td>Business hours</td>
            <td>24/7</td>
            <td>On-site operations and remote hands</td>
        </tr>
        <tr>
            <td>Uptime SLA</td>
            <td>99.99%</td>
            <td>99.999%</td>
            <td>Tier III+ concurrent maintainability</td>
        </tr>
        <tr>
            <td>Power Density</td>
            <td>12 kW/rack</td>
            <td>Up to 50 kW/rack</td>
            <td>Liquid cooling available for HPC</td>
        </tr>
    </tbody>
</table>
<p>Organisations adopting these standards report improved operational predictability, lower total cost of ownership, and stronger alignment with enterprise SLAs. VDC800 publishes real-time operational data so stakeholders can audit capacity and availability alongside traditional performance metrics.</p>
<p>Whether you are evaluating a first colocation deployment or optimising an existing hybrid cloud architecture, our team provides architecture reviews, capacity planning, and hands-on support from our Oslo NOC. Contact VDC800 to discuss how these principles apply to your specific requirements.</p>
HTML;
    }
}
