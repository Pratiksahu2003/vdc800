<?php

namespace Database\Seeders;

use App\Models\AboutSection;
use App\Models\AboutValue;
use App\Models\CompanySetting;
use App\Models\ContactSubmission;
use App\Models\DataCentre;
use App\Models\DataCentreFeature;
use App\Models\DataCentreSpecification;
use App\Models\HomepageBenefit;
use App\Models\HomepageSetting;
use App\Models\HomepageStatistic;
use App\Models\HomepageTestimonial;
use App\Models\SiteSetting;
use App\Models\SocialLink;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => Hash::make(env('ADMIN_PASSWORD', 'password')),
            'is_admin' => true,
        ]);

        CompanySetting::create([
            'company_name' => 'VDC800 Data Centres',
            'short_name' => 'VDC800',
            'tagline' => 'IS FUTURE OF DCs',
            'description' => 'VDC800 designs, builds, and operates premium data centre facilities across Northern Europe.',
            'about_company' => 'Founded with a vision to deliver world-class digital infrastructure, VDC800 combines Nordic engineering excellence with enterprise-grade operations. Our facilities serve enterprises, cloud providers, and research institutions who demand reliability, security, and predictable performance.',
            'email' => 'hello@VDC800.com',
            'phone' => '+47 22 00 00 00',
            'secondary_phone' => '+46 8 00 00 00',
            'address' => 'Akersgata 12',
            'city' => 'Oslo',
            'state' => 'Oslo',
            'country' => 'Norway',
            'postal_code' => '0158',
            'map_link' => 'https://www.google.com/maps/place/Akersgata+12,+0158+Oslo,+Norway',
            'founded_year' => '2026',
            'vat_number' => 'NO123456789MVA',
            'business_registration_number' => '918 765 432',
            'logo' => 'Logo/logo.png',
            'favicon' => 'Logo/favicon.png',
            'footer_logo' => 'Logo/logo.png',
        ]);

        SiteSetting::create([
            'website_name' => 'VDC800',
            'website_url' => 'http://localhost',
            'default_page_title' => 'VDC800 — Nordic Data Centres',
            'default_meta_description' => 'Premium data centre infrastructure in Northern Europe. Colocation, cloud connectivity, and enterprise hosting with 99.999% uptime.',
            'default_keywords' => 'data centre, nordic, colocation, cloud connectivity, enterprise hosting',
            'timezone' => 'Europe/Oslo',
            'default_language' => 'en',
        ]);

        $socialPlatforms = [
            ['platform' => 'LinkedIn', 'url' => 'https://linkedin.com/company/VDC800', 'icon' => 'linkedin', 'sort_order' => 1],
            ['platform' => 'X', 'url' => 'https://x.com/VDC800', 'icon' => 'twitter', 'sort_order' => 2],
            ['platform' => 'Facebook', 'url' => 'https://facebook.com/VDC800', 'icon' => 'facebook', 'sort_order' => 3],
            ['platform' => 'Instagram', 'url' => 'https://instagram.com/VDC800', 'icon' => 'instagram', 'sort_order' => 4],
            ['platform' => 'GitHub', 'url' => 'https://github.com/VDC800', 'icon' => 'github', 'sort_order' => 5],
            ['platform' => 'YouTube', 'url' => 'https://youtube.com/@VDC800', 'icon' => 'youtube', 'sort_order' => 6],
        ];

        foreach ($socialPlatforms as $social) {
            SocialLink::create(array_merge($social, ['is_active' => true]));
        }

        HomepageSetting::create([
            'hero_heading' => 'VDC800',
            'hero_subtitle' => 'IS FUTURE OF DCs',
            'hero_description' => 'VDC800 delivers enterprise-grade colocation and cloud connectivity from Nordic facilities engineered for uptime, security, and scale.',
            'hero_cta_text' => 'Explore Our Projects',
            'hero_cta_url' => '/projects',
            'hero_secondary_cta_text' => 'View Services',
            'hero_secondary_cta_url' => '/services',
            'intro_heading' => 'Where reliability meets precision',
            'intro_description' => 'Our facilities are engineered for 99.999% uptime while maintaining a PUE below 1.2. Carrier-neutral connectivity, concurrent maintainability, and 24/7 NOC coverage make VDC800 the preferred partner for organisations committed to digital growth.',
            'sustainability_heading' => 'Engineered for uptime. Built for scale.',
            'sustainability_description' => 'From Oslo to Stockholm, every VDC800 facility is designed for high-density workloads, efficient cooling, and operational transparency. We publish real-time availability metrics and hold ourselves accountable to enterprise SLAs.',
            'sustainability_cta_text' => 'Our Operational Commitment',
            'sustainability_cta_url' => '/about',
            'infrastructure_heading' => 'Built for scale, designed for security',
            'infrastructure_description' => 'Tier III+ architecture, biometric access controls, 24/7 NOC monitoring, and carrier-neutral connectivity to 40+ networks ensure your critical workloads are protected and always reachable.',
            'final_cta_heading' => 'Ready to power your next chapter?',
            'final_cta_description' => 'Speak with our infrastructure specialists about colocation, dedicated hosting, or custom enterprise solutions tailored to your requirements.',
            'final_cta_button_text' => 'Get in Touch',
            'final_cta_button_url' => '/contact',
        ]);

        $this->call(HeroSlideSeeder::class);

        $benefits = [
            ['title' => 'High Availability', 'description' => 'Tier III+ design with concurrent maintainability and 99.999% uptime SLA.', 'icon' => 'activity', 'sort_order' => 1],
            ['title' => 'Nordic Reliability', 'description' => 'Cool climate reduces cooling costs and enables industry-leading PUE ratings.', 'icon' => 'snowflake', 'sort_order' => 2],
            ['title' => 'Carrier Neutral', 'description' => 'Connect to 40+ carriers and cloud on-ramps from a single cross-connect.', 'icon' => 'network', 'sort_order' => 3],
            ['title' => 'Enterprise Security', 'description' => 'Multi-layer physical and cyber security protecting your most critical workloads.', 'icon' => 'shield-check', 'sort_order' => 4],
        ];

        foreach ($benefits as $benefit) {
            HomepageBenefit::create(array_merge($benefit, ['is_active' => true]));
        }

        $statistics = [
            ['number' => '165+', 'label' => 'MW Capacity', 'description' => 'Total power across Nordic facilities', 'sort_order' => 1],
            ['number' => '24/7', 'label' => 'NOC Coverage', 'description' => 'Always-on operations support', 'sort_order' => 2],
            ['number' => '99.999%', 'label' => 'Uptime SLA', 'description' => 'Tier III+ availability guarantee', 'sort_order' => 3],
            ['number' => '1.12', 'label' => 'Average PUE', 'description' => 'Industry-leading efficiency', 'sort_order' => 4],
        ];

        foreach ($statistics as $stat) {
            HomepageStatistic::create(array_merge($stat, ['is_active' => true]));
        }

        $this->call(ServiceSolutionSeeder::class);

        $dataCentre = DataCentre::create([
            'name' => 'VDC800 Oslo DC-1',
            'slug' => 'VDC800-oslo-dc-1',
            'location' => 'Oslo, Norway',
            'country' => 'Norway',
            'address' => 'Lørenfaret 1C, 0580 Oslo',
            'latitude' => 59.9311,
            'longitude' => 10.7979,
            'short_description' => 'Our flagship 45MW facility in the heart of Oslo, engineered for high-density enterprise colocation.',
            'full_description' => '<p>VDC800 Oslo DC-1 represents the pinnacle of Nordic data centre design. Located in the Løren industrial district with direct access to Norway\'s robust power grid, this facility combines 45MW of available capacity with a PUE of 1.12 — among the lowest in Europe.</p><p>The building features free-air cooling for 70% of the year, advanced fire suppression, and biometric access at every security zone. Carrier-neutral connectivity reaches 42 networks including direct cloud on-ramps to AWS, Azure, and Google Cloud.</p>',
            'meta_title' => 'Oslo Data Centre — VDC800 DC-1',
            'meta_description' => 'Explore VDC800\'s flagship 45MW data centre in Oslo, Norway. Tier III+ design, 99.999% uptime SLA.',
            'cta_heading' => 'Schedule a facility tour',
            'cta_description' => 'Visit our Oslo campus and see how Nordic engineering delivers world-class digital infrastructure.',
            'cta_button_text' => 'Book a Tour',
            'cta_button_url' => '/contact',
            'sort_order' => 1,
            'status' => 'published',
            'is_featured' => true,
        ]);

        $stockholm = DataCentre::create([
            'name' => 'VDC800 Stockholm DC-2',
            'slug' => 'VDC800-stockholm-dc-2',
            'location' => 'Stockholm, Sweden',
            'country' => 'Sweden',
            'address' => 'Kista Science Tower, 164 40 Kista',
            'latitude' => 59.4029,
            'longitude' => 17.9436,
            'short_description' => 'A 28MW carrier-neutral campus in Kista serving cloud providers and enterprises across Scandinavia.',
            'full_description' => '<p>VDC800 Stockholm DC-2 extends our Nordic footprint into Sweden\'s premier technology district. The facility delivers 28MW of capacity with direct fibre paths to major European internet exchanges and cloud regions.</p><p>Designed for hybrid cloud workloads, the campus offers high-density colocation, meet-me room services, and 24/7 remote hands support for regional enterprises.</p>',
            'meta_title' => 'Stockholm Data Centre — VDC800 DC-2',
            'meta_description' => 'Explore VDC800\'s 28MW data centre in Stockholm, Sweden. Carrier-neutral connectivity and Tier III+ design.',
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

        AboutSection::create([
            'hero_heading' => 'Building the backbone of digital Europe',
            'hero_description' => 'VDC800 was founded on a simple belief: digital infrastructure should be reliable, secure, and ready to scale. From our headquarters in Oslo, we design and operate data centres that prove performance and operational excellence go hand in hand.',
            'mission' => 'To deliver world-class digital infrastructure, enabling organisations to grow their digital capabilities with predictable uptime, security, and connectivity.',
            'vision' => 'A future where every byte processed in Europe is hosted in facilities that set the global standard for availability, efficiency, and operational discipline.',
            'story' => '<p>VDC800 began in 2018 when a team of Nordic engineers recognised that the explosive growth of cloud computing demanded a new class of data centre operations. Rather than accept the status quo, they set out to prove that facilities could be both powerful and precise.</p><p>Our first facility in Oslo opened in 2020, immediately achieving a PUE of 1.15 — well below the industry average. Today, we operate across Scandinavia with a pipeline of new facilities, each designed to push the boundaries of what enterprise infrastructure can achieve.</p>',
            'sustainability' => 'Operational excellence is not a feature at VDC800 — it is our foundation. We publish availability metrics, run 24/7 NOC coverage, and design every facility for concurrent maintainability, efficient cooling, and disciplined change control.',
            'cta_heading' => 'Join us in building the next chapter of digital infrastructure',
            'cta_description' => 'Whether you need colocation, cloud connectivity, or a custom enterprise solution, our team is ready to help.',
            'cta_button_text' => 'Contact Our Team',
            'cta_button_url' => '/contact',
            'meta_title' => 'About VDC800 — Nordic Data Centres',
        ]);

        $values = [
            ['title' => 'Integrity', 'description' => 'We operate transparently, publish real metrics, and hold ourselves accountable to the commitments we make.', 'icon' => 'badge-check', 'sort_order' => 1],
            ['title' => 'Innovation', 'description' => 'We continuously invest in cooling, power, and automation technologies that push efficiency boundaries.', 'icon' => 'lightbulb', 'sort_order' => 2],
            ['title' => 'Partnership', 'description' => 'We work alongside our clients as long-term partners, not just vendors, to solve complex infrastructure challenges.', 'icon' => 'handshake', 'sort_order' => 3],
            ['title' => 'Stewardship', 'description' => 'We treat the environments and communities where we operate as responsibilities, not resources to exploit.', 'icon' => 'globe', 'sort_order' => 4],
        ];

        foreach ($values as $value) {
            AboutValue::create(array_merge($value, ['is_active' => true]));
        }

        ContactSubmission::create([
            'name' => 'Erik Johansson',
            'company' => 'Nordic Fintech AS',
            'email' => 'erik.johansson@nordicfintech.no',
            'phone' => '+47 900 00 001',
            'project_type' => 'Colocation',
            'message' => 'We are looking for 20kW of colocation space with direct AWS connectivity. Could you provide availability and pricing for your Oslo facility?',
            'status' => 'new',
        ]);

        ContactSubmission::create([
            'name' => 'Anna Lindström',
            'company' => 'Uppsala University',
            'email' => 'anna.lindstrom@uu.se',
            'phone' => '+46 70 000 0002',
            'project_type' => 'HPC',
            'message' => 'Our research group needs high-density compute capacity for climate modelling. Interested in learning about your HPC solutions and academic pricing.',
            'status' => 'contacted',
        ]);

        $testimonials = [
            [
                'name' => 'Priya Sharma',
                'role' => 'Chief Technology Officer',
                'company' => 'Mumbai FinTech Solutions',
                'location' => 'Mumbai, India',
                'quote' => 'VDC800 gave us Nordic-grade colocation with latency that works for our European trading desks. Migration was smooth, and their team understood our RBI compliance requirements from day one.',
                'rating' => 5,
                'sort_order' => 1,
            ],
            [
                'name' => 'Arjun Mehta',
                'role' => 'Head of Infrastructure',
                'company' => 'CloudScale India',
                'location' => 'Bengaluru, India',
                'quote' => 'We needed carrier-neutral connectivity and enterprise SLAs for our SaaS platform. VDC800 delivered both — our uptime reporting to enterprise clients has never looked better.',
                'rating' => 5,
                'sort_order' => 2,
            ],
            [
                'name' => 'Rekha Nair',
                'role' => 'VP Engineering',
                'company' => 'MediCare Digital',
                'location' => 'Chennai, India',
                'quote' => 'Hosting healthcare workloads in a Tier III+ facility with 24/7 NOC monitoring gave our hospital partners the confidence they needed. VDC800\'s security posture exceeded our audit checklist.',
                'rating' => 5,
                'sort_order' => 3,
            ],
            [
                'name' => 'Vikram Singh',
                'role' => 'Director of IT Operations',
                'company' => 'ShopKart India',
                'location' => 'New Delhi, India',
                'quote' => 'During peak festival season, uptime is everything. VDC800\'s Oslo facility handled our traffic spikes without a single incident. Their support team responds within minutes, not hours.',
                'rating' => 5,
                'sort_order' => 4,
            ],
            [
                'name' => 'Ananya Iyer',
                'role' => 'Head of Cloud Architecture',
                'company' => 'Hyderabad Tech Labs',
                'location' => 'Hyderabad, India',
                'quote' => 'The direct cloud on-ramps to AWS and Azure saved us months of networking work. VDC800 feels like an extension of our engineering team — proactive, transparent, and deeply technical.',
                'rating' => 5,
                'sort_order' => 5,
            ],
            [
                'name' => 'Rohan Kapoor',
                'role' => 'Chief Information Officer',
                'company' => 'Pune Manufacturing Group',
                'location' => 'Pune, India',
                'quote' => 'We evaluated facilities across Europe and chose VDC800 for their operational transparency and biometric security. Our board was impressed by the quarterly SLA reporting they provide.',
                'rating' => 5,
                'sort_order' => 6,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            HomepageTestimonial::create(array_merge($testimonial, ['is_active' => true]));
        }

        $this->call(BlogSeeder::class);
    }
}
