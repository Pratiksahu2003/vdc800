<?php

namespace Database\Seeders;

use App\Models\AboutSection;
use App\Models\AboutValue;
use App\Models\CompanySetting;
use App\Models\ContactSubmission;
use App\Models\HomepageBenefit;
use App\Models\HomepageSetting;
use App\Models\HomepageStatistic;
use App\Models\HomepageTestimonial;
use App\Models\SiteSetting;
use App\Models\SocialLink;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(AdminUserSeeder::class);

        CompanySetting::create([
            'company_name' => 'D³ DataCenters',
            'short_name' => 'D³',
            'tagline' => 'IS FUTURE OF DCs',
            'description' => 'D³ DataCenters designs, builds, and operates premium data centre facilities across Northern Europe.',
            'about_company' => 'Founded with a vision to deliver world-class digital infrastructure, D³ DataCenters combines Nordic engineering excellence with enterprise-grade operations. Our facilities serve enterprises, cloud providers, and research institutions who demand reliability, security, and predictable performance.',
            'email' => 'hello@d3.vedmint.com',
            'contact_notification_email' => 'hello@d3.vedmint.com',
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
            'website_name' => 'D³ DataCenters',
            'website_url' => 'http://localhost',
            'default_page_title' => 'D³ DataCenters — Nordic Data Centres',
            'default_meta_description' => 'Premium data centre infrastructure in Northern Europe. Colocation, cloud connectivity, and enterprise hosting with 99.999% uptime.',
            'default_keywords' => 'data centre, nordic, colocation, cloud connectivity, enterprise hosting',
            'timezone' => 'Europe/Oslo',
            'default_language' => 'en',
        ]);

        $socialPlatforms = [
            ['platform' => 'LinkedIn', 'url' => 'https://linkedin.com/company/d3-datacenters', 'icon' => 'linkedin', 'sort_order' => 1],
            ['platform' => 'X', 'url' => 'https://x.com/d3datacenters', 'icon' => 'twitter', 'sort_order' => 2],
            ['platform' => 'Facebook', 'url' => 'https://facebook.com/d3datacenters', 'icon' => 'facebook', 'sort_order' => 3],
            ['platform' => 'Instagram', 'url' => 'https://instagram.com/d3datacenters', 'icon' => 'instagram', 'sort_order' => 4],
            ['platform' => 'GitHub', 'url' => 'https://github.com/d3-datacenters', 'icon' => 'github', 'sort_order' => 5],
            ['platform' => 'YouTube', 'url' => 'https://youtube.com/@d3datacenters', 'icon' => 'youtube', 'sort_order' => 6],
        ];

        foreach ($socialPlatforms as $social) {
            SocialLink::create(array_merge($social, ['is_active' => true]));
        }

        HomepageSetting::create([
            'hero_heading' => 'D³ DataCenters',
            'hero_subtitle' => 'IS FUTURE OF DCs',
            'hero_description' => 'D³ DataCenters delivers enterprise-grade colocation and cloud connectivity from Nordic facilities engineered for uptime, security, and scale.',
            'hero_cta_text' => 'Explore Our Projects',
            'hero_cta_url' => '/projects',
            'hero_secondary_cta_text' => 'View Services',
            'hero_secondary_cta_url' => '/services',
            'intro_heading' => 'Where reliability meets precision',
            'intro_description' => 'Our facilities are engineered for 99.999% uptime while maintaining a PUE below 1.2. Carrier-neutral connectivity, concurrent maintainability, and 24/7 NOC coverage make D³ DataCenters the preferred partner for organisations committed to digital growth.',
            'sustainability_heading' => 'Engineered for uptime. Built for scale.',
            'sustainability_description' => 'From Oslo to Stockholm, every D³ DataCenters facility is designed for high-density workloads, efficient cooling, and operational transparency. We publish real-time availability metrics and hold ourselves accountable to enterprise SLAs.',
            'sustainability_cta_text' => 'Our Operational Commitment',
            'sustainability_cta_url' => '/about',
            'infrastructure_heading' => 'Your business located everywhere your data is.',
            'infrastructure_heading_emphasis' => 'everywhere',
            'infrastructure_description' => 'Deploy workloads in carrier-neutral Nordic facilities with Tier III+ design, direct cloud on-ramps, and 24/7 NOC coverage—so your teams stay connected without compromise.',
            'infrastructure_cta_text' => 'Explore D³ colocation',
            'infrastructure_cta_url' => '/projects',
            'final_cta_heading' => 'Ready to power your next chapter?',
            'final_cta_description' => 'Speak with our infrastructure specialists about colocation, dedicated hosting, or custom enterprise solutions tailored to your requirements.',
            'final_cta_button_text' => 'Get in Touch',
            'final_cta_button_url' => '/contact',
        ]);

        $this->call(HeroSlideSeeder::class);

        $benefits = [
            ['title' => 'High Availability', 'description' => 'Tier III+ design with concurrent maintainability and 99.999% uptime SLA.', 'icon' => 'activity', 'sort_order' => 1],
            ['title' => 'Ready for AI at Scale', 'description' => 'Power, connectivity, and infrastructure designed to support the next generation of AI and high-performance computing.', 'icon' => 'brain-circuit', 'sort_order' => 2],
            ['title' => 'Carrier Neutral', 'description' => 'Connect to 40+ carriers and cloud on-ramps from a single cross-connect.', 'icon' => 'network', 'sort_order' => 3],
            ['title' => 'Enterprise Security', 'description' => 'Multi-layer physical and cyber security protecting your most critical workloads.', 'icon' => 'shield-check', 'sort_order' => 4],
        ];

        foreach ($benefits as $benefit) {
            HomepageBenefit::create(array_merge($benefit, ['is_active' => true]));
        }

        $statistics = [
            ['number' => '2+', 'label' => 'Data centers', 'description' => 'Nordic campuses with room to scale.', 'sort_order' => 1],
            ['number' => '40+', 'label' => 'Cloud & network providers', 'description' => 'On one carrier-neutral platform.', 'sort_order' => 2],
            ['number' => '165+', 'label' => 'MW capacity', 'description' => 'Power engineered for enterprise density.', 'sort_order' => 3],
            ['number' => '1.12', 'label' => 'Average PUE', 'description' => 'Industry-leading efficiency', 'sort_order' => 4],
        ];

        foreach ($statistics as $stat) {
            HomepageStatistic::create(array_merge($stat, ['is_active' => true]));
        }

        $this->call(ServiceSeeder::class);
        $this->call(SolutionSeeder::class);
        $this->call(DataCentreSeeder::class);

        AboutSection::create([
            'hero_heading' => 'Building the backbone of digital Europe',
            'hero_description' => 'D³ DataCenters was founded on a simple belief: digital infrastructure should be reliable, secure, and ready to scale. From our headquarters in Oslo, we design and operate data centres that prove performance and operational excellence go hand in hand.',
            'mission' => 'To deliver world-class digital infrastructure, enabling organisations to grow their digital capabilities with predictable uptime, security, and connectivity.',
            'vision' => 'A future where every byte processed in Europe is hosted in facilities that set the global standard for availability, efficiency, and operational discipline.',
            'story' => '<p>D³ DataCenters began in 2018 when a team of Nordic engineers recognised that the explosive growth of cloud computing demanded a new class of data centre operations. Rather than accept the status quo, they set out to prove that facilities could be both powerful and precise.</p><p>Our first facility in Oslo opened in 2020, immediately achieving a PUE of 1.15 — well below the industry average. Today, we operate across Scandinavia with a pipeline of new facilities, each designed to push the boundaries of what enterprise infrastructure can achieve.</p>',
            'sustainability' => 'Operational excellence is not a feature at D³ DataCenters — it is our foundation. We publish availability metrics, run 24/7 NOC coverage, and design every facility for concurrent maintainability, efficient cooling, and disciplined change control.',
            'cta_heading' => 'Join us in building the next chapter of digital infrastructure',
            'cta_description' => 'Whether you need colocation, cloud connectivity, or a custom enterprise solution, our team is ready to help.',
            'cta_button_text' => 'Contact Our Team',
            'cta_button_url' => '/contact',
            'meta_title' => 'About D³ DataCenters — Nordic Data Centres',
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
                'quote' => 'D³ DataCenters gave us Nordic-grade colocation with latency that works for our European trading desks. Migration was smooth, and their team understood our RBI compliance requirements from day one.',
                'rating' => 5,
                'sort_order' => 1,
            ],
            [
                'name' => 'Arjun Mehta',
                'role' => 'Head of Infrastructure',
                'company' => 'CloudScale India',
                'location' => 'Bengaluru, India',
                'quote' => 'We needed carrier-neutral connectivity and enterprise SLAs for our SaaS platform. D³ DataCenters delivered both — our uptime reporting to enterprise clients has never looked better.',
                'rating' => 5,
                'sort_order' => 2,
            ],
            [
                'name' => 'Rekha Nair',
                'role' => 'VP Engineering',
                'company' => 'MediCare Digital',
                'location' => 'Chennai, India',
                'quote' => 'Hosting healthcare workloads in a Tier III+ facility with 24/7 NOC monitoring gave our hospital partners the confidence they needed. D³ DataCenters\'s security posture exceeded our audit checklist.',
                'rating' => 5,
                'sort_order' => 3,
            ],
            [
                'name' => 'Vikram Singh',
                'role' => 'Director of IT Operations',
                'company' => 'ShopKart India',
                'location' => 'New Delhi, India',
                'quote' => 'During peak festival season, uptime is everything. D³ DataCenters\'s Oslo facility handled our traffic spikes without a single incident. Their support team responds within minutes, not hours.',
                'rating' => 5,
                'sort_order' => 4,
            ],
            [
                'name' => 'Ananya Iyer',
                'role' => 'Head of Cloud Architecture',
                'company' => 'Hyderabad Tech Labs',
                'location' => 'Hyderabad, India',
                'quote' => 'The direct cloud on-ramps to AWS and Azure saved us months of networking work. D³ DataCenters feels like an extension of our engineering team — proactive, transparent, and deeply technical.',
                'rating' => 5,
                'sort_order' => 5,
            ],
            [
                'name' => 'Rohan Kapoor',
                'role' => 'Chief Information Officer',
                'company' => 'Pune Manufacturing Group',
                'location' => 'Pune, India',
                'quote' => 'We evaluated facilities across Europe and chose D³ DataCenters for their operational transparency and biometric security. Our board was impressed by the quarterly SLA reporting they provide.',
                'rating' => 5,
                'sort_order' => 6,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            HomepageTestimonial::create(array_merge($testimonial, ['is_active' => true]));
        }

        $this->call(BlogSeeder::class);
        $this->call(NavMenuSeeder::class);
    }
}
