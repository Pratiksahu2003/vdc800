<?php

namespace Database\Seeders;

use App\Models\AboutSection;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\CompanySetting;
use App\Models\DataCentre;
use App\Models\DataCentreFeature;
use App\Models\DataCentreSpecification;
use App\Models\HomepageBenefit;
use App\Models\HomepageHeroSlide;
use App\Models\HomepageSetting;
use App\Models\HomepageStatistic;
use App\Models\HomepageTestimonial;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\Solution;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UpdateContentCopySeeder extends Seeder
{
    public function run(): void
    {
        CompanySetting::query()->update([
            'description' => 'VDC800 designs, builds, and operates premium data centre facilities across Northern Europe.',
            'about_company' => 'Founded with a vision to deliver world-class digital infrastructure, VDC800 combines Nordic engineering excellence with enterprise-grade operations. Our facilities serve enterprises, cloud providers, and research institutions who demand reliability, security, and predictable performance.',
        ]);

        SiteSetting::query()->update([
            'default_page_title' => 'VDC800 — Nordic Data Centres',
            'default_meta_description' => 'Premium data centre infrastructure in Northern Europe. Colocation, cloud connectivity, and enterprise hosting with 99.999% uptime.',
            'default_keywords' => 'data centre, nordic, colocation, cloud connectivity, enterprise hosting',
        ]);

        HomepageSetting::query()->update([
            'hero_description' => 'VDC800 delivers enterprise-grade colocation and cloud connectivity from Nordic facilities engineered for uptime, security, and scale.',
            'intro_heading' => 'Where reliability meets precision',
            'intro_description' => 'Our facilities are engineered for 99.999% uptime while maintaining a PUE below 1.2. Carrier-neutral connectivity, concurrent maintainability, and 24/7 NOC coverage make VDC800 the preferred partner for organisations committed to digital growth.',
            'sustainability_heading' => 'Engineered for uptime. Built for scale.',
            'sustainability_description' => 'From Oslo to Stockholm, every VDC800 facility is designed for high-density workloads, efficient cooling, and operational transparency. We publish real-time availability metrics and hold ourselves accountable to enterprise SLAs.',
            'sustainability_cta_text' => 'Our Operational Commitment',
        ]);

        HomepageHeroSlide::query()->where('sort_order', 1)->update([
            'title' => 'VDC800 Oslo DC-1 Delivers 45MW of Enterprise Power',
            'description' => 'Our flagship Nordic facility delivers 45MW with a PUE of 1.12 — enterprise-grade colocation built for the future of digital infrastructure.',
        ]);

        HomepageHeroSlide::query()->where('sort_order', 3)->update([
            'category' => 'Operations',
            'title' => 'Tier III+ Design Across All Nordic Facilities',
            'description' => 'Concurrent maintainability, 24/7 NOC monitoring, and published availability metrics for mission-critical workloads.',
        ]);

        HomepageBenefit::query()->where('title', 'Renewable Energy')->update([
            'title' => 'High Availability',
            'description' => 'Tier III+ design with concurrent maintainability and 99.999% uptime SLA.',
            'icon' => 'activity',
        ]);

        HomepageStatistic::query()->where('label', 'Renewable Energy')->update([
            'number' => '24/7',
            'label' => 'NOC Coverage',
            'description' => 'Always-on operations support',
        ]);

        DataCentre::query()->where('slug', 'VDC800-oslo-dc-1')->update([
            'short_description' => 'Our flagship 45MW facility in the heart of Oslo, engineered for high-density enterprise colocation.',
            'full_description' => '<p>VDC800 Oslo DC-1 represents the pinnacle of Nordic data centre design. Located in the Løren industrial district with direct access to Norway\'s robust power grid, this facility combines 45MW of available capacity with a PUE of 1.12 — among the lowest in Europe.</p><p>The building features free-air cooling for 70% of the year, advanced fire suppression, and biometric access at every security zone. Carrier-neutral connectivity reaches 42 networks including direct cloud on-ramps to AWS, Azure, and Google Cloud.</p>',
            'meta_description' => 'Explore VDC800\'s flagship 45MW data centre in Oslo, Norway. Tier III+ design, 99.999% uptime SLA.',
        ]);

        DataCentre::query()->where('slug', 'VDC800-stockholm-dc-2')->update([
            'full_description' => '<p>VDC800 Stockholm DC-2 extends our Nordic footprint into Sweden\'s premier technology district. The facility delivers 28MW of capacity with direct fibre paths to major European internet exchanges and cloud regions.</p><p>Designed for hybrid cloud workloads, the campus offers high-density colocation, meet-me room services, and 24/7 remote hands support for regional enterprises.</p>',
            'meta_description' => 'Explore VDC800\'s 28MW data centre in Stockholm, Sweden. Carrier-neutral connectivity and Tier III+ design.',
        ]);

        DataCentreSpecification::query()->where('label', 'Renewable Energy')->update([
            'label' => 'Uptime SLA',
            'value' => '99.999',
            'unit' => '%',
            'icon' => 'activity',
        ]);

        DataCentreFeature::query()->where('slug', 'energy')->update([
            'description' => 'Dual utility feeds, UPS and generator backup, with real-time power monitoring for every kWh consumed.',
        ]);

        AboutSection::query()->update([
            'hero_heading' => 'Building the backbone of digital Europe',
            'hero_description' => 'VDC800 was founded on a simple belief: digital infrastructure should be reliable, secure, and ready to scale. From our headquarters in Oslo, we design and operate data centres that prove performance and operational excellence go hand in hand.',
            'mission' => 'To deliver world-class digital infrastructure, enabling organisations to grow their digital capabilities with predictable uptime, security, and connectivity.',
            'vision' => 'A future where every byte processed in Europe is hosted in facilities that set the global standard for availability, efficiency, and operational discipline.',
            'story' => '<p>VDC800 began in 2018 when a team of Nordic engineers recognised that the explosive growth of cloud computing demanded a new class of data centre operations. Rather than accept the status quo, they set out to prove that facilities could be both powerful and precise.</p><p>Our first facility in Oslo opened in 2020, immediately achieving a PUE of 1.15 — well below the industry average. Today, we operate across Scandinavia with a pipeline of new facilities, each designed to push the boundaries of what enterprise infrastructure can achieve.</p>',
            'sustainability' => 'Operational excellence is not a feature at VDC800 — it is our foundation. We publish availability metrics, run 24/7 NOC coverage, and design every facility for concurrent maintainability, efficient cooling, and disciplined change control.',
            'cta_heading' => 'Join us in building the next chapter of digital infrastructure',
            'meta_title' => 'About VDC800 — Nordic Data Centres',
        ]);

        HomepageTestimonial::query()
            ->where('quote', 'like', '%renewable energy credentials%')
            ->update([
                'quote' => 'We needed carrier-neutral connectivity and enterprise SLAs for our SaaS platform. VDC800 delivered both — our uptime reporting to enterprise clients has never looked better.',
            ]);

        HomepageTestimonial::query()
            ->where('quote', 'like', '%sustainability credentials%')
            ->update([
                'quote' => 'We evaluated facilities across Europe and chose VDC800 for their operational transparency and biometric security. Our board was impressed by the quarterly SLA reporting they provide.',
            ]);

        BlogCategory::query()->where('slug', 'sustainability')->update([
            'name' => 'Operations',
            'slug' => 'operations',
            'description' => 'Facility operations, PUE optimisation, and data centre best practices.',
        ]);

        $blogRenames = [
            'Oslo DC-1 Expansion Adds 15MW Renewable Capacity' => 'Oslo DC-1 Expansion Adds 15MW Capacity',
            '100% Renewable Energy Matching Explained' => 'How We Deliver 99.999% Uptime SLAs',
            'Carbon Reporting for Enterprise Colocation Clients' => 'Capacity Reporting for Enterprise Colocation Clients',
            'VDC800 Partners with Scandinavian Wind Farms' => 'VDC800 Expands Nordic Interconnect Footprint',
        ];

        foreach ($blogRenames as $oldTitle => $newTitle) {
            $post = BlogPost::query()->where('title', $oldTitle)->orWhere('slug', Str::slug($oldTitle))->first();
            if (! $post) {
                continue;
            }

            $post->update([
                'title' => $newTitle,
                'slug' => Str::slug($newTitle),
                'excerpt' => "Explore {$newTitle} with practical guidance from VDC800 infrastructure specialists operating Nordic data centres.",
                'meta_title' => $newTitle.' — VDC800 Blog',
                'meta_description' => "Explore {$newTitle} with practical guidance from VDC800 infrastructure specialists operating Nordic data centres.",
            ]);
        }

        $this->scrubTextColumns();
    }

    private function scrubTextColumns(): void
    {
        $replacements = [
            '15MW Renewable Capacity' => '15MW Capacity',
            '100% Renewable Energy' => '99.999% Uptime',
            '100% renewable energy' => '99.999% uptime',
            'renewable-powered' => 'enterprise-grade',
            'Renewable Energy' => 'High Availability',
            'renewable energy matching' => 'availability reporting',
            'Renewable energy matching' => 'Power redundancy',
            'renewable energy certificates' => 'power monitoring',
            'renewable energy economics' => 'power economics',
            'renewable energy credentials' => 'enterprise SLAs',
            'renewable energy' => 'enterprise infrastructure',
            'Renewable energy' => 'Enterprise infrastructure',
            '100% renewables' => '24/7 NOC coverage',
            '100% renewable matching' => '99.999% availability targets',
            '100% renewable power matching' => '24/7 operational coverage',
            '100% renewable Nordic' => 'Nordic Tier III+',
            '100% renewable' => '99.999% uptime',
            'certified renewable generation' => 'utility power',
            'renewable generation' => 'utility power',
            'renewable matching certificates' => 'availability reports',
            'renewable matching' => 'availability reporting',
            'renewable power matching' => '24/7 operational coverage',
            'renewable-powered capacity' => 'capacity',
            'Green energy matching' => '99.999% uptime target',
            'green energy matching' => 'uptime reporting',
            'Green energy for compute' => 'High-density compute',
            'green energy' => 'utility power',
            'grid and renewables operators' => 'grid and utility operators',
            'renewables operators' => 'utility operators',
            'powered entirely by renewable energy' => 'engineered for enterprise workloads',
        ];

        $targets = [
            [CompanySetting::class, ['description', 'about_company']],
            [SiteSetting::class, ['default_page_title', 'default_meta_description', 'default_keywords']],
            [HomepageSetting::class, ['hero_description', 'intro_description', 'sustainability_heading', 'sustainability_description', 'final_cta_description']],
            [HomepageHeroSlide::class, ['category', 'title', 'description']],
            [HomepageBenefit::class, ['title', 'description']],
            [HomepageStatistic::class, ['label', 'description']],
            [HomepageTestimonial::class, ['quote']],
            [DataCentre::class, ['short_description', 'full_description', 'meta_description']],
            [DataCentreSpecification::class, ['label']],
            [DataCentreFeature::class, ['title', 'description']],
            [AboutSection::class, ['hero_heading', 'hero_description', 'mission', 'vision', 'story', 'sustainability', 'cta_heading', 'meta_title']],
            [BlogCategory::class, ['name', 'description']],
            [BlogPost::class, ['title', 'excerpt', 'body', 'meta_title', 'meta_description']],
            [Service::class, ['short_description', 'full_description', 'meta_title', 'meta_description']],
            [Solution::class, ['short_description', 'description', 'meta_title', 'meta_description']],
        ];

        foreach ($targets as [$model, $columns]) {
            $model::query()->each(function ($record) use ($columns, $replacements) {
                $dirty = false;
                foreach ($columns as $column) {
                    $value = $record->{$column};
                    if (! is_string($value) || $value === '') {
                        continue;
                    }
                    $updated = str_replace(array_keys($replacements), array_values($replacements), $value);
                    if ($updated !== $value) {
                        $record->{$column} = $updated;
                        $dirty = true;
                    }
                }
                if ($dirty) {
                    $record->save();
                }
            });
        }

        Solution::query()->each(function (Solution $solution) use ($replacements) {
            $benefits = $solution->benefits;
            if (! is_array($benefits)) {
                return;
            }
            $updated = json_decode(str_replace(array_keys($replacements), array_values($replacements), json_encode($benefits)), true);
            if ($updated !== $benefits) {
                $solution->benefits = $updated;
                $solution->save();
            }
        });

        Service::query()->each(function (Service $service) use ($replacements) {
            $items = $service->items;
            if (! is_array($items)) {
                return;
            }
            $updated = json_decode(str_replace(array_keys($replacements), array_values($replacements), json_encode($items)), true);
            if ($updated !== $items) {
                $service->items = $updated;
                $service->save();
            }
        });
    }
}
