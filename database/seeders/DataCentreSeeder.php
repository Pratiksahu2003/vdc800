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

        $dataCentre = DataCentre::create([
            'name' => 'D³ DataCenters Oslo DC-1',
            'slug' => 'd3-oslo-dc-1',
            'location' => 'Oslo, Norway',
            'country' => 'Norway',
            'address' => 'Lørenfaret 1C, 0580 Oslo',
            'latitude' => 59.9311,
            'longitude' => 10.7979,
            'short_description' => 'Our flagship 45MW facility in the heart of Oslo, engineered for high-density enterprise colocation.',
            'full_description' => '<p>D³ DataCenters Oslo DC-1 represents the pinnacle of Nordic data centre design. Located in the Løren industrial district with direct access to Norway\'s robust power grid, this facility combines 45MW of available capacity with a PUE of 1.12 — among the lowest in Europe.</p><p>The building features free-air cooling for 70% of the year, advanced fire suppression, and biometric access at every security zone. Carrier-neutral connectivity reaches 42 networks including direct cloud on-ramps to AWS, Azure, and Google Cloud.</p>',
            'meta_title' => 'Oslo Data Centre — D³ DataCenters DC-1',
            'meta_description' => 'Explore D³ DataCenters\'s flagship 45MW data centre in Oslo, Norway. Tier III+ design, 99.999% uptime SLA.',
            'cta_heading' => 'Schedule a facility tour',
            'cta_description' => 'Visit our Oslo campus and see how Nordic engineering delivers world-class digital infrastructure.',
            'cta_button_text' => 'Book a Tour',
            'cta_button_url' => '/contact',
            'sort_order' => 1,
            'status' => 'published',
            'is_featured' => true,
        ]);

        $stockholm = DataCentre::create([
            'name' => 'D³ DataCenters Stockholm DC-2',
            'slug' => 'd3-stockholm-dc-2',
            'location' => 'Stockholm, Sweden',
            'country' => 'Sweden',
            'address' => 'Kista Science Tower, 164 40 Kista',
            'latitude' => 59.4029,
            'longitude' => 17.9436,
            'short_description' => 'A 28MW carrier-neutral campus in Kista serving cloud providers and enterprises across Scandinavia.',
            'full_description' => '<p>D³ DataCenters Stockholm DC-2 extends our Nordic footprint into Sweden\'s premier technology district. The facility delivers 28MW of capacity with direct fibre paths to major European internet exchanges and cloud regions.</p><p>Designed for hybrid cloud workloads, the campus offers high-density colocation, meet-me room services, and 24/7 remote hands support for regional enterprises.</p>',
            'meta_title' => 'Stockholm Data Centre — D³ DataCenters DC-2',
            'meta_description' => 'Explore D³ DataCenters\'s 28MW data centre in Stockholm, Sweden. Carrier-neutral connectivity and Tier III+ design.',
            'cta_heading' => 'Plan your deployment',
            'cta_description' => 'Speak with our Stockholm team about colocation and cross-connect options.',
            'cta_button_text' => 'Contact Us',
            'cta_button_url' => '/contact',
            'sort_order' => 2,
            'status' => 'published',
            'is_featured' => false,
        ]);

        $specs = [
            ['label' => 'Power Capacity', 'value' => '45', 'unit' => 'MW', 'icon' => 'zap', 'sort_order' => 1],
            ['label' => 'Available Capacity', 'value' => '12', 'unit' => 'MW', 'icon' => 'battery-charging', 'sort_order' => 2],
            ['label' => 'Uptime SLA', 'value' => '99.999', 'unit' => '%', 'icon' => 'activity', 'sort_order' => 3],
            ['label' => 'PUE Rating', 'value' => '1.12', 'unit' => '', 'icon' => 'gauge', 'sort_order' => 4],
            ['label' => 'Facility Size', 'value' => '18,500', 'unit' => 'm²', 'icon' => 'building', 'sort_order' => 5],
            ['label' => 'Rack Capacity', 'value' => '3,200', 'unit' => 'racks', 'icon' => 'server', 'sort_order' => 6],
            ['label' => 'Cooling Capacity', 'value' => '52', 'unit' => 'MW', 'icon' => 'snowflake', 'sort_order' => 7],
            ['label' => 'Network Capacity', 'value' => '100', 'unit' => 'Gbps', 'icon' => 'network', 'sort_order' => 8],
            ['label' => 'Security Level', 'value' => 'Tier IV', 'unit' => '', 'icon' => 'shield', 'sort_order' => 9],
            ['label' => 'Availability Target', 'value' => '99.999', 'unit' => '%', 'icon' => 'activity', 'sort_order' => 10],
        ];

        foreach ($specs as $spec) {
            DataCentreSpecification::create(array_merge($spec, [
                'data_centre_id' => $dataCentre->id,
                'is_active' => true,
            ]));
        }

        $features = [
            ['title' => 'Energy', 'slug' => 'energy', 'description' => 'Dual utility feeds, UPS and generator backup, with real-time power monitoring for every kWh consumed.', 'icon' => 'zap', 'sort_order' => 1],
            ['title' => 'Cooling', 'slug' => 'cooling', 'description' => 'Hybrid free-air and chilled water cooling systems optimised for Nordic climate, achieving PUE as low as 1.12.', 'icon' => 'snowflake', 'sort_order' => 2],
            ['title' => 'Connectivity', 'slug' => 'connectivity', 'description' => 'Carrier-neutral meet-me room with 42 network providers, direct cloud on-ramps, and sub-5ms latency to major European hubs.', 'icon' => 'network', 'sort_order' => 3],
            ['title' => 'Security', 'slug' => 'security', 'description' => 'Multi-layer physical security with biometric access, 24/7 CCTV, mantrap entries, and on-site security personnel.', 'icon' => 'shield-check', 'sort_order' => 4],
            ['title' => 'Scalability', 'slug' => 'scalability', 'description' => 'Modular hall design allows expansion from single racks to 500-rack deployments without service interruption.', 'icon' => 'maximize-2', 'sort_order' => 5],
            ['title' => 'Location', 'slug' => 'location', 'description' => 'Strategically positioned in Oslo with excellent fibre infrastructure, political stability, and access to skilled technical workforce.', 'icon' => 'map-pin', 'sort_order' => 6],
        ];

        foreach ($features as $feature) {
            DataCentreFeature::create(array_merge($feature, [
                'data_centre_id' => $dataCentre->id,
                'is_active' => true,
            ]));
        }

        DataCentreSpecification::create([
            'data_centre_id' => $stockholm->id,
            'label' => 'Power Capacity',
            'value' => '28',
            'unit' => 'MW',
            'icon' => 'zap',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        DataCentreFeature::create([
            'data_centre_id' => $stockholm->id,
            'title' => 'Connectivity',
            'slug' => 'connectivity',
            'description' => 'Carrier-neutral meet-me room with direct paths to major European IXPs and cloud on-ramps.',
            'icon' => 'network',
            'sort_order' => 1,
            'is_active' => true,
        ]);
    }
}
