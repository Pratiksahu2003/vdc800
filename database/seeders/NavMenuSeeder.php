<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\DataCentre;
use App\Models\NavMenuItem;
use App\Models\Service;
use App\Models\Solution;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NavMenuSeeder extends Seeder
{
    public function run(): void
    {
        NavMenuItem::query()->whereNotNull('parent_id')->delete();
        NavMenuItem::query()->whereNull('parent_id')->delete();

        $this->seedServicesMenu();
        $this->seedSolutionsMenu();
        $this->seedDataCentersMenu();
        $this->seedBlogMenu();
        $this->seedAboutMenu();

        NavMenuItem::create([
            'slug' => 'contact-cta',
            'zone' => 'utility',
            'label' => 'Contact',
            'route_name' => 'contact.index',
            'is_cta' => true,
            'sort_order' => 30,
        ]);
    }

    private function seedServicesMenu(): void
    {
        $parent = NavMenuItem::create([
            'slug' => 'services',
            'zone' => 'main',
            'label' => 'Services',
            'dropdown_layout' => 'split',
            'sort_order' => 10,
            'promo_title' => 'Advisory services from strategy through delivery.',
            'promo_cta_label' => 'View all services',
            'promo_route_name' => 'services.index',
        ]);

        $categories = Service::published()
            ->get()
            ->groupBy(fn (Service $s) => $s->category ?: 'Advisory Services');

        $tabOrder = 1;
        foreach ($categories as $categoryName => $services) {
            $key = Str::slug($categoryName);
            NavMenuItem::create([
                'parent_id' => $parent->id,
                'zone' => 'main',
                'is_sidebar_tab' => true,
                'sidebar_key' => $key,
                'label' => $categoryName,
                'sort_order' => $tabOrder++,
            ]);

            NavMenuItem::create([
                'parent_id' => $parent->id,
                'zone' => 'main',
                'sidebar_key' => $key,
                'group_heading' => 'Services',
                'label' => 'All services',
                'description' => 'Browse every advisory service we offer.',
                'route_name' => 'services.index',
                'sort_order' => 5,
            ]);

            $linkOrder = 10;
            foreach ($services as $service) {
                NavMenuItem::create([
                    'parent_id' => $parent->id,
                    'zone' => 'main',
                    'sidebar_key' => $key,
                    'group_heading' => 'Services',
                    'label' => $service->title,
                    'description' => $service->short_description,
                    'route_name' => 'services.show',
                    'route_params' => ['service' => $service->slug],
                    'sort_order' => $linkOrder++,
                ]);
            }
        }

        if ($categories->isEmpty()) {
            NavMenuItem::create([
                'parent_id' => $parent->id,
                'zone' => 'main',
                'is_sidebar_tab' => true,
                'sidebar_key' => 'services',
                'label' => 'Services',
                'sort_order' => 1,
            ]);
            NavMenuItem::create([
                'parent_id' => $parent->id,
                'zone' => 'main',
                'sidebar_key' => 'services',
                'group_heading' => 'Services',
                'label' => 'All services',
                'route_name' => 'services.index',
                'sort_order' => 10,
            ]);
        }
    }

    private function seedSolutionsMenu(): void
    {
        $parent = NavMenuItem::create([
            'slug' => 'solutions',
            'zone' => 'main',
            'label' => 'Solutions',
            'dropdown_layout' => 'split',
            'sort_order' => 20,
            'promo_title' => 'Industry and workload-specific infrastructure blueprints.',
            'promo_cta_label' => 'Explore solutions',
            'promo_route_name' => 'solutions.index',
        ]);

        NavMenuItem::create([
            'parent_id' => $parent->id,
            'zone' => 'main',
            'is_sidebar_tab' => true,
            'sidebar_key' => 'all',
            'label' => 'All solutions',
            'sort_order' => 1,
        ]);

        NavMenuItem::create([
            'parent_id' => $parent->id,
            'zone' => 'main',
            'sidebar_key' => 'all',
            'group_heading' => 'Solutions',
            'label' => 'Solutions overview',
            'description' => 'Compare offerings for cloud, AI, and enterprise workloads.',
            'route_name' => 'solutions.index',
            'sort_order' => 10,
        ]);

        $order = 11;
        foreach (Solution::published()->orderBy('sort_order')->get() as $solution) {
            NavMenuItem::create([
                'parent_id' => $parent->id,
                'zone' => 'main',
                'sidebar_key' => 'all',
                'group_heading' => 'Solutions',
                'label' => $solution->title,
                'description' => $solution->short_description,
                'route_name' => 'solutions.show',
                'route_params' => ['solution' => $solution->slug],
                'sort_order' => $order++,
            ]);
        }
    }

    private function seedDataCentersMenu(): void
    {
        $parent = NavMenuItem::create([
            'slug' => 'data-centers',
            'zone' => 'main',
            'label' => 'Data Centers',
            'dropdown_layout' => 'split',
            'sort_order' => 30,
            'promo_title' => 'Tour Global facilities built for Tier III+ availability.',
            'promo_cta_label' => 'Book a facility tour',
            'promo_route_name' => 'contact.index',
        ]);

        NavMenuItem::create([
            'parent_id' => $parent->id,
            'zone' => 'main',
            'is_sidebar_tab' => true,
            'sidebar_key' => 'projects',
            'label' => 'Projects',
            'sort_order' => 1,
        ]);

        NavMenuItem::create([
            'parent_id' => $parent->id,
            'zone' => 'main',
            'sidebar_key' => 'projects',
            'group_heading' => 'Projects',
            'label' => 'All projects',
            'description' => 'Facilities and case studies across the global regions.',
            'route_name' => 'data-centre.index',
            'sort_order' => 10,
        ]);

        $order = 11;
        foreach (DataCentre::query()->where('status', 'published')->orderBy('sort_order')->get() as $project) {
            NavMenuItem::create([
                'parent_id' => $parent->id,
                'zone' => 'main',
                'sidebar_key' => 'projects',
                'group_heading' => 'Projects',
                'label' => $project->name,
                'description' => $project->short_description,
                'route_name' => 'data-centre.show',
                'route_params' => ['dataCentre' => $project->slug],
                'sort_order' => $order++,
            ]);
        }
    }

    private function seedBlogMenu(): void
    {
        $parent = NavMenuItem::create([
            'slug' => 'blog',
            'zone' => 'main',
            'label' => 'Blog',
            'dropdown_layout' => 'split',
            'sort_order' => 40,
            'promo_title' => 'Insights on operations, connectivity, and Global infrastructure.',
            'promo_cta_label' => 'Read the blog',
            'promo_route_name' => 'blog.index',
        ]);

        NavMenuItem::create([
            'parent_id' => $parent->id,
            'zone' => 'main',
            'is_sidebar_tab' => true,
            'sidebar_key' => 'posts',
            'label' => 'Blog posts',
            'sort_order' => 1,
        ]);

        NavMenuItem::create([
            'parent_id' => $parent->id,
            'zone' => 'main',
            'is_sidebar_tab' => true,
            'sidebar_key' => 'categories',
            'label' => 'Blog categories',
            'sort_order' => 2,
        ]);

        NavMenuItem::create([
            'parent_id' => $parent->id,
            'zone' => 'main',
            'sidebar_key' => 'posts',
            'group_heading' => 'Blog posts',
            'label' => 'All blog posts',
            'description' => 'Articles, guides, and updates from our team.',
            'route_name' => 'blog.index',
            'sort_order' => 10,
        ]);

        $postOrder = 11;
        foreach (BlogPost::query()->where('status', 'published')->orderByDesc('published_at')->limit(8)->get() as $post) {
            NavMenuItem::create([
                'parent_id' => $parent->id,
                'zone' => 'main',
                'sidebar_key' => 'posts',
                'group_heading' => 'Blog posts',
                'label' => $post->title,
                'description' => Str::limit(strip_tags($post->excerpt ?? ''), 120),
                'route_name' => 'blog.show',
                'route_params' => ['post' => $post->slug],
                'sort_order' => $postOrder++,
            ]);
        }

        $catOrder = 10;
        foreach (BlogCategory::query()->where('status', 'published')->orderBy('sort_order')->get() as $category) {
            NavMenuItem::create([
                'parent_id' => $parent->id,
                'zone' => 'main',
                'sidebar_key' => 'categories',
                'group_heading' => 'Blog categories',
                'label' => $category->name,
                'description' => $category->description,
                'route_name' => 'blog.index',
                'route_params' => ['category' => $category->slug],
                'sort_order' => $catOrder++,
            ]);
        }
    }

    private function seedAboutMenu(): void
    {
        $parent = NavMenuItem::create([
            'slug' => 'about-us',
            'zone' => 'main',
            'label' => 'About Us',
            'dropdown_layout' => 'split',
            'sort_order' => 45,
            'promo_title' => 'Global engineering excellence for mission-critical digital infrastructure.',
            'promo_cta_label' => 'Meet D³ DataCenters',
            'promo_route_name' => 'about.index',
        ]);

        NavMenuItem::create([
            'parent_id' => $parent->id,
            'zone' => 'main',
            'is_sidebar_tab' => true,
            'sidebar_key' => 'company',
            'label' => 'Company',
            'sort_order' => 1,
        ]);

        NavMenuItem::create([
            'parent_id' => $parent->id,
            'zone' => 'main',
            'is_sidebar_tab' => true,
            'sidebar_key' => 'legal',
            'label' => 'Legal',
            'sort_order' => 2,
        ]);

        NavMenuItem::create([
            'parent_id' => $parent->id,
            'zone' => 'main',
            'sidebar_key' => 'company',
            'group_heading' => 'Company',
            'label' => 'About us',
            'description' => 'Our mission, story, and values building the backbone of digital Europe.',
            'route_name' => 'about.index',
            'sort_order' => 10,
        ]);

        NavMenuItem::create([
            'parent_id' => $parent->id,
            'zone' => 'main',
            'sidebar_key' => 'company',
            'group_heading' => 'Company',
            'label' => 'Contact',
            'description' => 'Speak with our team about colocation, connectivity, and advisory services.',
            'route_name' => 'contact.index',
            'sort_order' => 11,
        ]);

        NavMenuItem::create([
            'parent_id' => $parent->id,
            'zone' => 'main',
            'sidebar_key' => 'company',
            'group_heading' => 'Company',
            'label' => 'Sitemap',
            'description' => 'Find every page on D³ DataCenters.',
            'route_name' => 'legal.sitemap',
            'sort_order' => 12,
        ]);

        $legalLinks = [
            ['label' => 'Privacy policy', 'description' => 'How we collect, use, and protect your data.', 'route' => 'legal.privacy'],
            ['label' => 'Terms of service', 'description' => 'Terms governing use of our website and services.', 'route' => 'legal.terms'],
            ['label' => 'Cookie policy', 'description' => 'Cookies and similar technologies on this site.', 'route' => 'legal.cookies'],
        ];

        $order = 10;
        foreach ($legalLinks as $link) {
            NavMenuItem::create([
                'parent_id' => $parent->id,
                'zone' => 'main',
                'sidebar_key' => 'legal',
                'group_heading' => 'Legal',
                'label' => $link['label'],
                'description' => $link['description'],
                'route_name' => $link['route'],
                'sort_order' => $order++,
            ]);
        }
    }
}
