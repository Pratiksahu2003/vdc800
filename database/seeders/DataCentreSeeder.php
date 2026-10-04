<?php

namespace Database\Seeders;

use App\Models\DataCentre;
use App\Models\DataCentreFeature;
use App\Models\DataCentreSpecification;
use Illuminate\Database\Seeder;

class DataCentreSeeder extends Seeder
{
    public function run(): void
    {
        DataCentreFeature::query()->delete();
        DataCentreSpecification::query()->delete();
        DataCentre::query()->delete();

        $facilities = [
            [
                'name' => 'D³ DataCenters Oslo DC-1',
                'slug' => 'd3-oslo-dc-1',
                'location' => 'Oslo, Norway',
                'country' => 'Norway',
                'address' => 'Lørenfaret 1C, 0580 Oslo',
                'latitude' => 59.9311,
                'longitude' => 10.7979,
                'hero_image' => 'images/data-centres/dc-oslo.jpg',
                'short_description' => 'Our flagship 45MW facility in the heart of Oslo, engineered for high-density enterprise colocation.',
                'full_description' => '<p>D³ DataCenters Oslo DC-1 represents the pinnacle of Nordic data centre design. Located in the Løren industrial district with direct access to Norway\'s robust power grid, this facility combines 45MW of available capacity with a PUE of 1.12 — among the lowest in Europe.</p><p>The building features free-air cooling for 70% of the year, advanced fire suppression, and biometric access at every security zone. Carrier-neutral connectivity reaches 42 networks including direct cloud on-ramps to AWS, Azure, and Google Cloud.</p>',
                'meta_title' => 'Oslo Data Centre — D³ DataCenters DC-1',
                'meta_description' => 'Explore D³ DataCenters\'s flagship 45MW data centre in Oslo, Norway. Tier III+ design, 99.999% uptime SLA.',
                'cta_heading' => 'Schedule a facility tour',
                'cta_description' => 'Visit our Oslo campus and see how Nordic engineering delivers world-class digital infrastructure.',
                'cta_button_text' => 'Book a Tour',
                'sort_order' => 1,
                'is_featured' => true,
                'power_mw' => '45',
                'available_mw' => '12',
            ],
            [
                'name' => 'D³ DataCenters Stockholm DC-2',
                'slug' => 'd3-stockholm-dc-2',
                'location' => 'Stockholm, Sweden',
                'country' => 'Sweden',
                'address' => 'Kista Science Tower, 164 40 Kista',
                'latitude' => 59.4029,
                'longitude' => 17.9436,
                'hero_image' => 'images/data-centres/dc-stockholm.jpg',
                'short_description' => 'A 28MW carrier-neutral campus in Kista serving cloud providers and enterprises across Scandinavia.',
                'full_description' => '<p>D³ DataCenters Stockholm DC-2 extends our Nordic footprint into Sweden\'s premier technology district. The facility delivers 28MW of capacity with direct fibre paths to major European internet exchanges and cloud regions.</p><p>Designed for hybrid cloud workloads, the campus offers high-density colocation, meet-me room services, and 24/7 remote hands support for regional enterprises.</p>',
                'meta_title' => 'Stockholm Data Centre — D³ DataCenters DC-2',
                'meta_description' => 'Explore D³ DataCenters\'s 28MW data centre in Stockholm, Sweden. Carrier-neutral connectivity and Tier III+ design.',
                'cta_heading' => 'Plan your deployment',
                'cta_description' => 'Speak with our Stockholm team about colocation and cross-connect options.',
                'cta_button_text' => 'Contact Us',
                'sort_order' => 2,
                'is_featured' => false,
                'power_mw' => '28',
                'available_mw' => '8',
            ],
            [
                'name' => 'D³ DataCenters Copenhagen DC-3',
                'slug' => 'd3-copenhagen-dc-3',
                'location' => 'Copenhagen, Denmark',
                'country' => 'Denmark',
                'address' => 'Bryggegade 8, 2300 København S',
                'latitude' => 55.6761,
                'longitude' => 12.5683,
                'hero_image' => 'images/data-centres/dc-copenhagen.jpg',
                'short_description' => 'Harbour-adjacent 22MW site with subsea cable diversity and low-latency paths to the UK and continental Europe.',
                'full_description' => '<p>Copenhagen DC-3 anchors D³\'s Danish presence with dual utility feeds, district heating integration, and direct access to major subsea landing stations. The facility is optimised for latency-sensitive financial and SaaS workloads requiring EU data residency.</p><p>Modular halls support rapid expansion from quarter racks to multi-megawatt deployments with concurrent maintainability throughout.</p>',
                'meta_title' => 'Copenhagen Data Centre — D³ DataCenters DC-3',
                'meta_description' => '22MW Copenhagen colocation with subsea diversity, district heat recovery, and Tier III+ resilience.',
                'cta_heading' => 'Explore Copenhagen capacity',
                'cta_description' => 'Review power, cross-connects, and deployment timelines with our Danish operations team.',
                'cta_button_text' => 'Talk to sales',
                'sort_order' => 3,
                'is_featured' => false,
                'power_mw' => '22',
                'available_mw' => '6',
            ],
            [
                'name' => 'D³ DataCenters Helsinki DC-4',
                'slug' => 'd3-helsinki-dc-4',
                'location' => 'Helsinki, Finland',
                'country' => 'Finland',
                'address' => 'Radiokatu 3, 00240 Helsinki',
                'latitude' => 60.1699,
                'longitude' => 24.9384,
                'hero_image' => 'images/data-centres/dc-helsinki.jpg',
                'short_description' => '18MW AI-ready facility with high-density liquid cooling and R&E network peering for research workloads.',
                'full_description' => '<p>Helsinki DC-4 combines Nordic renewable power with advanced liquid-to-chip cooling for GPU-dense clusters. The site peers with national research networks and offers dedicated zones for regulated public-sector workloads.</p><p>Free-air economisation and heat reuse keep annualised PUE below 1.15 even at elevated rack densities.</p>',
                'meta_title' => 'Helsinki Data Centre — D³ DataCenters DC-4',
                'meta_description' => 'AI-ready 18MW Helsinki data centre with liquid cooling, R&E peering, and Tier III+ operations.',
                'cta_heading' => 'Plan an AI deployment',
                'cta_description' => 'Discuss high-density power, cooling, and network design with our Helsinki engineering team.',
                'cta_button_text' => 'Contact Us',
                'sort_order' => 4,
                'is_featured' => true,
                'power_mw' => '18',
                'available_mw' => '5',
            ],
            [
                'name' => 'D³ DataCenters Frankfurt DC-5',
                'slug' => 'd3-frankfurt-dc-5',
                'location' => 'Frankfurt, Germany',
                'country' => 'Germany',
                'address' => 'Hanauer Landstraße 182, 60314 Frankfurt am Main',
                'latitude' => 50.1109,
                'longitude' => 8.6821,
                'hero_image' => 'images/data-centres/dc-frankfurt.jpg',
                'short_description' => '32MW DE-CIX-adjacent hub for trading, cloud on-ramps, and enterprise hybrid workloads across the EU.',
                'full_description' => '<p>Frankfurt DC-5 places customers minutes from Europe\'s largest internet exchange with diverse metro fibre and multi-cloud on-ramps. The campus delivers deterministic latency for capital markets, payment, and real-time analytics platforms.</p><p>ISO-aligned security controls, carrier-neutral meet-me space, and 2N power topology support mission-critical SLAs.</p>',
                'meta_title' => 'Frankfurt Data Centre — D³ DataCenters DC-5',
                'meta_description' => '32MW Frankfurt colocation near DE-CIX with cloud on-ramps and ultra-low latency connectivity.',
                'cta_heading' => 'Secure Frankfurt capacity',
                'cta_description' => 'Map cross-connects, power density, and compliance requirements with our German team.',
                'cta_button_text' => 'Book a Tour',
                'sort_order' => 5,
                'is_featured' => false,
                'power_mw' => '32',
                'available_mw' => '9',
            ],
            [
                'name' => 'D³ DataCenters Amsterdam DC-6',
                'slug' => 'd3-amsterdam-dc-6',
                'location' => 'Amsterdam, Netherlands',
                'country' => 'Netherlands',
                'address' => 'Science Park 121, 1098 XG Amsterdam',
                'latitude' => 52.3676,
                'longitude' => 4.9041,
                'hero_image' => 'images/data-centres/dc-amsterdam.jpg',
                'short_description' => '26MW AMS-IX-proximate campus for hyperscale adjacency, media delivery, and global SaaS footprints.',
                'full_description' => '<p>Amsterdam DC-6 offers carrier-dense connectivity with direct paths to AMS-IX and major subsea systems. The facility supports burst-heavy streaming, gaming, and SaaS platforms that require elastic cross-connects and rapid provisioning.</p><p>Sustainability features include renewable power contracts, water-efficient cooling, and transparent carbon reporting for ESG programmes.</p>',
                'meta_title' => 'Amsterdam Data Centre — D³ DataCenters DC-6',
                'meta_description' => '26MW Amsterdam data centre with AMS-IX proximity, media-grade connectivity, and Tier III+ design.',
                'cta_heading' => 'Scale in Amsterdam',
                'cta_description' => 'Review available suites, meet-me room options, and deployment lead times with our Benelux team.',
                'cta_button_text' => 'Contact Us',
                'sort_order' => 6,
                'is_featured' => false,
                'power_mw' => '26',
                'available_mw' => '7',
            ],
        ];

        foreach ($facilities as $facility) {
            $powerMw = $facility['power_mw'];
            $availableMw = $facility['available_mw'];
            unset($facility['power_mw'], $facility['available_mw']);

            $dataCentre = DataCentre::create(array_merge($facility, [
                'cta_button_url' => '/contact',
                'status' => 'published',
                'show_map' => true,
            ]));

            DataCentreSpecification::create([
                'data_centre_id' => $dataCentre->id,
                'label' => 'Power Capacity',
                'value' => $powerMw,
                'unit' => 'MW',
                'icon' => 'zap',
                'sort_order' => 1,
                'is_active' => true,
            ]);

            DataCentreSpecification::create([
                'data_centre_id' => $dataCentre->id,
                'label' => 'Available Capacity',
                'value' => $availableMw,
                'unit' => 'MW',
                'icon' => 'battery-charging',
                'sort_order' => 2,
                'is_active' => true,
            ]);

            DataCentreSpecification::create([
                'data_centre_id' => $dataCentre->id,
                'label' => 'Uptime SLA',
                'value' => '99.999',
                'unit' => '%',
                'icon' => 'activity',
                'sort_order' => 3,
                'is_active' => true,
            ]);

            $features = [
                ['title' => 'Connectivity', 'slug' => 'connectivity', 'description' => 'Carrier-neutral meet-me room with cloud on-ramps and diverse fibre entry paths.', 'icon' => 'network'],
                ['title' => 'Security', 'slug' => 'security', 'description' => 'Layered physical security with biometric access, CCTV, and 24/7 on-site personnel.', 'icon' => 'shield-check'],
                ['title' => 'Sustainability', 'slug' => 'sustainability', 'description' => 'Renewable power sourcing, heat reuse, and transparent efficiency reporting.', 'icon' => 'leaf'],
            ];

            foreach ($features as $index => $feature) {
                DataCentreFeature::create(array_merge($feature, [
                    'data_centre_id' => $dataCentre->id,
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]));
            }
        }
    }
}
