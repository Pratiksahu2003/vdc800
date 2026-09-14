<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\Solution;
use Database\Seeders\Support\LongFormSeoContent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ServiceSolutionSeeder extends Seeder
{
    /** @var array<int, string> Premium realistic images mapped to each advisory service. */
    private const SERVICE_IMAGE_URLS = [
        // Strategy & Advisory — executive planning session
        'https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=1400&h=900&q=85',
        // Investment & Due Diligence — financial analysis dashboard
        'https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?auto=format&fit=crop&w=1400&h=900&q=85',
        // Engineering & Design — high-density data center server hall
        'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?auto=format&fit=crop&w=1400&h=900&q=85',
        // Procurement & Execution — electrical infrastructure & equipment
        'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=1400&h=900&q=85',
        // Demand Generation — business development & client connections
        'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?auto=format&fit=crop&w=1400&h=900&q=85',
    ];

    /** @var array<int, string> */
    private const UNIQUE_IMAGE_URLS = [
        'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1544197150-361451702afe?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1563986768609-322da13575f3?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1550751827-4bd374c3d58b?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1473341304170-971dccb5ac71?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1535223396211-9c8dcf2b6d3a?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1555949963-aa79dcee981c?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?auto=format&fit=crop&w=1400&h=900&q=85',
        'https://images.unsplash.com/photo-1614064641938-3bbee52942c7?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1639322537504-6427a16b0ef8?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1504639725590-34d0984388bd?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?auto=format&fit=crop&w=1400&h=900&q=80',
    ];

    public function run(): void
    {
        $this->seedImages();

        Service::query()->delete();
        Solution::query()->delete();

        foreach ($this->services() as $index => $service) {
            $num = $index + 1;
            $imagePath = "images/services/service-{$num}.jpg";
            $keywords = $service['keywords'];
            $items = $service['items'];
            unset($service['keywords'], $service['items']);

            Service::create(array_merge($service, [
                'featured_image' => $imagePath,
                'og_image' => $imagePath,
                'items' => $items,
                'full_description' => LongFormSeoContent::advisoryServiceBody(
                    $service['title'],
                    $service['short_description'],
                    $items,
                    $keywords,
                ),
                'meta_title' => LongFormSeoContent::metaTitle($service['title']),
                'meta_description' => LongFormSeoContent::metaDescription($service['title'], 'service', $keywords),
            ]));
        }

        foreach ($this->solutions() as $index => $solution) {
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
                'meta_title' => LongFormSeoContent::metaTitle($solution['title']),
                'meta_description' => LongFormSeoContent::metaDescription($solution['title'], 'solution', $keywords),
            ]));
        }
    }

    private function seedImages(bool $force = true): void
    {
        $serviceDir = public_path('images/services');
        $solutionDir = public_path('images/solutions');

        File::ensureDirectoryExists($serviceDir);
        File::ensureDirectoryExists($solutionDir);

        if ($force) {
            foreach (File::glob("{$serviceDir}/*.jpg") as $file) {
                File::delete($file);
            }
            foreach (File::glob("{$solutionDir}/*.jpg") as $file) {
                File::delete($file);
            }
        }

        $serviceSeeds = [
            'VDC800-svc-strategy-advisory-01',
            'VDC800-svc-investment-diligence-02',
            'VDC800-svc-engineering-design-03',
            'VDC800-svc-procurement-execution-04',
            'VDC800-svc-demand-generation-05',
        ];

        foreach ($serviceSeeds as $i => $seed) {
            $this->downloadUniqueImage(
                self::SERVICE_IMAGE_URLS[$i],
                "{$serviceDir}/service-".($i + 1).'.jpg',
                $seed,
            );
        }

        $solutionSeeds = [
            'VDC800-sol-financial-01',
            'VDC800-sol-healthcare-02',
            'VDC800-sol-media-streaming-03',
            'VDC800-sol-government-04',
            'VDC800-sol-ecommerce-05',
            'VDC800-sol-gaming-06',
            'VDC800-sol-telecom-07',
            'VDC800-sol-energy-utilities-08',
            'VDC800-sol-education-09',
            'VDC800-sol-manufacturing-iot-10',
            'VDC800-sol-saas-scale-11',
            'VDC800-sol-research-hpc-12',
        ];

        $allUrls = self::UNIQUE_IMAGE_URLS;

        foreach ($solutionSeeds as $i => $seed) {
            $this->downloadUniqueImage($allUrls[$i + 12], "{$solutionDir}/solution-".($i + 1).'.jpg', $seed);
        }
    }

    private function downloadUniqueImage(string $url, string $destination, string $fallbackSeed): void
    {
        if (File::exists($destination) && File::size($destination) > 10_000) {
            return;
        }

        try {
            $context = stream_context_create([
                'http' => [
                    'method' => 'GET',
                    'header' => "User-Agent: VDC800-CMS-Seeder/1.0\r\n",
                    'timeout' => 60,
                    'ignore_errors' => true,
                ],
            ]);

            $body = @file_get_contents($url, false, $context);

            if ($body !== false && strlen($body) > 10_000) {
                File::put($destination, $body);

                return;
            }
        } catch (\Throwable) {
            // Fall back to local copy below.
        }

        $this->copyFallbackImage($fallbackSeed, $destination);
    }

    private function copyFallbackImage(string $seed, string $destination): void
    {
        $sources = [
            public_path('images/hero-slide-1.jpg'),
            public_path('images/hero-slide-2.jpg'),
            public_path('images/hero-slide-3.jpg'),
            public_path('images/hero-slide-4.jpg'),
            public_path('images/hero-slide-5.jpg'),
            public_path('images/hero-datacenter.jpg'),
            public_path('images/data-centre-facility.jpg'),
            public_path('images/about-technology.jpg'),
        ];

        $available = array_values(array_filter($sources, fn (string $path) => File::exists($path)));

        if ($available === []) {
            return;
        }

        $index = abs(crc32($seed)) % count($available);
        $source = $available[$index];

        if (! extension_loaded('gd')) {
            File::copy($source, $destination);

            return;
        }

        $type = exif_imagetype($source);
        $image = match ($type) {
            IMAGETYPE_JPEG => imagecreatefromjpeg($source),
            IMAGETYPE_PNG => imagecreatefrompng($source),
            IMAGETYPE_WEBP => imagecreatefromwebp($source),
            default => null,
        };

        if (! $image) {
            File::copy($source, $destination);

            return;
        }

        $width = imagesx($image);
        $height = imagesy($image);
        $offsetX = abs(crc32($seed.'-x')) % max(1, $width - 400);
        $offsetY = abs(crc32($seed.'-y')) % max(1, $height - 300);
        $cropWidth = min(1200, $width - $offsetX);
        $cropHeight = min(800, $height - $offsetY);

        $cropped = imagecrop($image, [
            'x' => $offsetX,
            'y' => $offsetY,
            'width' => $cropWidth,
            'height' => $cropHeight,
        ]) ?: $image;

        imagejpeg($cropped, $destination, 88);
        imagedestroy($image);
        if ($cropped !== $image) {
            imagedestroy($cropped);
        }
    }

    /** @return array<int, array<string, mixed>> */
    private function services(): array
    {
        return [
            $this->serviceEntry(
                'Strategy & Advisory',
                'strategy-advisory',
                'Advisory Services',
                'compass',
                'Define the opportunity, test the business case and create a practical path to capacity.',
                ['data center strategy', 'feasibility studies', 'site evaluation', 'development strategy', 'business planning'],
                [
                    [
                        'title' => 'Market & Capacity Assessment',
                        'description' => 'Assess market demand, supply, pricing and competitive dynamics to identify where capacity can be developed or accessed.',
                    ],
                    [
                        'title' => 'Feasibility Studies',
                        'description' => 'Test technical, commercial and development assumptions before significant capital or time is committed.',
                    ],
                    [
                        'title' => 'Site Evaluation',
                        'description' => 'Evaluate power availability, connectivity, land, utilities, approvals and other factors that influence site viability.',
                    ],
                    [
                        'title' => 'Development Strategy',
                        'description' => 'Translate the opportunity into a phased development plan covering capacity, infrastructure, partners and execution priorities.',
                    ],
                    [
                        'title' => 'Business Planning',
                        'description' => 'Build the operating and commercial framework required to take a data center opportunity from concept toward implementation.',
                    ],
                ],
                1,
            ),
            $this->serviceEntry(
                'Investment & Due Diligence',
                'investment-due-diligence',
                'Advisory Services',
                'chart-line',
                'Give investors and decision-makers the technical and financial clarity needed to commit capital.',
                ['investment due diligence', 'financial analysis', 'technical due diligence', 'CAPEX benchmarking', 'project reports'],
                [
                    [
                        'title' => 'Detailed Project Reports',
                        'description' => 'Structure project assumptions, scope, phasing, costs and implementation plans into a decision-ready project report.',
                    ],
                    [
                        'title' => 'Financial Analysis',
                        'description' => 'Evaluate CAPEX, operating costs, revenue assumptions and project economics to understand investment potential.',
                    ],
                    [
                        'title' => 'Technical Due Diligence',
                        'description' => 'Review power, cooling, electrical, mechanical, network and site infrastructure to identify technical risks and gaps.',
                    ],
                    [
                        'title' => 'CAPEX Benchmarking',
                        'description' => 'Test major cost assumptions against project scope, capacity and market benchmarks to improve capital planning.',
                    ],
                    [
                        'title' => 'Investment Decision Support',
                        'description' => 'Convert technical findings into clear commercial implications, risks, opportunities and decision points.',
                    ],
                ],
                2,
            ),
            $this->serviceEntry(
                'Engineering & Design',
                'engineering-design',
                'Advisory Services',
                'blueprint',
                'Translate compute requirements into resilient power, cooling and infrastructure solutions.',
                ['power infrastructure', 'electrical systems', 'cooling design', 'AI infrastructure', 'high-density compute'],
                [
                    [
                        'title' => 'Power Infrastructure',
                        'description' => 'Define utility, generation, substation and distribution strategies aligned with required capacity and resilience.',
                    ],
                    [
                        'title' => 'Electrical Systems',
                        'description' => 'Develop electrical architecture covering MV/LV distribution, UPS, switchgear, busways and critical power paths.',
                    ],
                    [
                        'title' => 'Cooling & Mechanical',
                        'description' => 'Assess cooling architecture and mechanical systems for conventional and high-density compute environments.',
                    ],
                    [
                        'title' => 'AI & High-Density Infrastructure',
                        'description' => 'Plan infrastructure around high-density GPU deployments, rack power, thermal loads and associated network requirements.',
                    ],
                    [
                        'title' => 'Design Coordination',
                        'description' => 'Coordinate technical inputs across disciplines so engineering decisions remain aligned with the commercial and delivery objectives.',
                    ],
                ],
                3,
            ),
            $this->serviceEntry(
                'Procurement & Execution',
                'procurement-execution',
                'Advisory Services',
                'package',
                'Help clients source the right equipment and coordinate the path from technical design to delivery.',
                ['vendor evaluation', 'equipment sourcing', 'procurement support', 'technical compliance', 'project coordination'],
                [
                    [
                        'title' => 'Vendor Evaluation',
                        'description' => 'Identify and assess vendors against technical capability, commercial fit, delivery capacity and project requirements.',
                    ],
                    [
                        'title' => 'Technical Compliance',
                        'description' => 'Review technical offers and specifications to ensure proposed equipment meets the defined performance requirements.',
                    ],
                    [
                        'title' => 'Equipment Sourcing',
                        'description' => 'Support sourcing of critical electrical, mechanical, cooling and data center infrastructure equipment.',
                    ],
                    [
                        'title' => 'Procurement Support',
                        'description' => 'Assist with bid comparisons, technical clarifications, commercial evaluation and procurement decision-making.',
                    ],
                    [
                        'title' => 'Project Coordination',
                        'description' => 'Coordinate stakeholders, suppliers and technical teams to keep key delivery activities aligned with project priorities.',
                    ],
                ],
                4,
            ),
            $this->serviceEntry(
                'Demand Generation',
                'demand-generation',
                'Advisory Services',
                'users',
                'Help data centers connect with qualified potential clients for colocation, GPU capacity and Build to Suit opportunities.',
                ['colocation demand', 'GPU capacity', 'build to suit', 'client qualification', 'opportunity development'],
                [
                    [
                        'title' => 'Colocation Demand',
                        'description' => 'Identify and connect data centers with enterprises and digital businesses looking for reliable colocation capacity.',
                    ],
                    [
                        'title' => 'GPU Capacity Demand',
                        'description' => 'Connect available AI compute capacity with organizations seeking GPU infrastructure for training, inference and other workloads.',
                    ],
                    [
                        'title' => 'Build to Suit Opportunities',
                        'description' => 'Help data center developers identify potential customers with requirements for dedicated or purpose-built infrastructure.',
                    ],
                    [
                        'title' => 'Client Qualification',
                        'description' => 'Understand prospective clients\' capacity, power, density, location, timeline and commercial requirements to improve opportunity quality.',
                    ],
                    [
                        'title' => 'Opportunity Development',
                        'description' => 'Support introductions and commercial discussions that help move qualified data center demand toward actionable opportunities.',
                    ],
                ],
                5,
            ),
        ];
    }

    /** @return array<int, array<string, mixed>> */
    private function solutions(): array
    {
        return [
            $this->solutionEntry(
                'Financial Services',
                'financial-services',
                'landmark',
                'Low-latency, audit-ready infrastructure for banks, fintech, payments, and trading technology teams.',
                ['MiFID II ready hosting', 'Deterministic latency paths', 'Encrypted cross-connects', '24/7 SOC monitoring', 'PCI DSS alignment support'],
                ['financial services hosting', 'fintech colocation', 'trading infrastructure', 'regulated workloads'],
                [
                    ['Latency', '< 2 ms metro options', 'Support electronic trading', 'Diverse fibre paths'],
                    ['Compliance', 'PCI, GDPR, MiFID mapping', 'Shorter audits', 'Evidence libraries'],
                    ['Resilience', 'Active/active designs', 'Minimise settlement risk', 'Concurrent maintainability'],
                    ['Security', 'HSM-ready zones', 'Protect keys & HSMs', 'Dual-control procedures'],
                ],
                1,
            ),
            $this->solutionEntry(
                'Healthcare & Life Sciences',
                'healthcare-life-sciences',
                'heart-pulse',
                'HIPAA-aligned patterns, research data lakes, and imaging pipelines with strict access governance.',
                ['Clinical data residency', 'Research network peering', 'Immutable audit logs', 'BAA-ready documentation'],
                ['healthcare hosting', 'life sciences infrastructure', 'medical data centre', 'HIPAA patterns'],
                [
                    ['Data classes', 'PHI segmentation', 'Reduce blast radius', 'Zone-based access'],
                    ['Research', 'HPC burst capacity', 'Faster genomic pipelines', 'Academic peering'],
                    ['Imaging', 'High-throughput storage paths', 'Responsive PACS workloads', 'Low-latency fabric'],
                    ['Governance', 'Retention policies', 'Regulatory alignment', 'Legal hold support'],
                ],
                2,
            ),
            $this->solutionEntry(
                'Media & Streaming',
                'media-streaming',
                'play-circle',
                'Multi-gigabit delivery, CDN adjacency, and origin shielding for broadcasters and OTT platforms.',
                ['Multi-gigabit uplinks', 'CDN private interconnects', 'Origin shielding', 'Scalable delivery at peak'],
                ['media hosting', 'streaming infrastructure', 'CDN peering', 'OTT platform colocation'],
                [
                    ['Bandwidth', '10–100 GbE scalable', 'Handle live spikes', 'Burstable contracts'],
                    ['CDN', 'Private peering', 'Lower rebuffer rates', 'Regional PoPs'],
                    ['Origin', 'Shield clusters', 'Protect upstreams', 'Cache-friendly design'],
                    ['Reliability', '99.999% uptime target', 'Broadcast-grade SLAs', 'Published availability metrics'],
                ],
                3,
            ),
            $this->solutionEntry(
                'Government & Public Sector',
                'government-public-sector',
                'building-2',
                'Sovereign-ready hosting with EU data residency, supply-chain transparency, and incident coordination.',
                ['EU data residency', 'Supply-chain transparency', 'CERT coordination', 'High-assurance physical security'],
                ['government cloud', 'public sector hosting', 'sovereign data centre', 'EU residency'],
                [
                    ['Residency', 'EU-only processing', 'Meet sovereignty mandates', 'Documented flows'],
                    ['Procurement', 'Framework-friendly', 'Predictable commercials', 'Transparent SLAs'],
                    ['Security', 'Enhanced vetting', 'Protect citizen data', 'Air-gapped options'],
                    ['Continuity', 'Geo-diverse DR', 'Service citizen apps', 'Tested runbooks'],
                ],
                4,
            ),
            $this->solutionEntry(
                'E-commerce & Retail',
                'ecommerce-retail',
                'shopping-cart',
                'Elastic capacity for peak trading, payment isolation, and edge caching partnerships for global storefronts.',
                ['Peak traffic headroom', 'PCI zone segmentation', 'Fraud analytics proximity', 'Fast checkout paths'],
                ['ecommerce hosting', 'retail infrastructure', 'peak season capacity', 'PCI colocation'],
                [
                    ['Peaks', 'Reserved burst power', 'Survive Black Friday', 'Pre-event load tests'],
                    ['Payments', 'Isolated PCI enclaves', 'Reduce scope', 'Tokenisation friendly'],
                    ['Catalogue', 'Low-latency DB tiers', 'Snappy product pages', 'Read replica guidance'],
                    ['Global', 'CDN + origin design', 'International buyers', 'Multi-region DR'],
                ],
                5,
            ),
            $this->solutionEntry(
                'Gaming & Interactive Entertainment',
                'gaming-interactive-entertainment',
                'gamepad-2',
                'Low-latency game backends, matchmaking clusters, and anti-cheat telemetry pipelines.',
                ['Sub-20 ms player latency', 'GPU-dense racks', 'DDoS mitigation handoff', 'Global player matchmaking'],
                ['game server hosting', 'gaming infrastructure', 'low-latency hosting', 'GPU colocation'],
                [
                    ['Latency', 'Regional edge hubs', 'Fair competitive play', 'Anycast options'],
                    ['Compute', 'GPU pods', 'Rich physics & AI NPCs', 'Liquid-ready racks'],
                    ['Security', 'DDoS scrubbing', 'Protect matchmaking', 'Rate-limit integration'],
                    ['Live ops', 'Rolling deploy patterns', 'Minimal player disruption', 'Blue/green guidance'],
                ],
                6,
            ),
            $this->solutionEntry(
                'Telecommunications',
                'telecommunications',
                'radio',
                'NFV hosting, interconnect aggregation, and 5G core adjacency in carrier-neutral facilities.',
                ['NFV infrastructure', 'Interconnect aggregation', '5G core adjacency', 'Carrier-neutral meet-me'],
                ['telecom hosting', 'NFV colocation', '5G infrastructure', 'telco data centre'],
                [
                    ['NFV', 'High-throughput virtualisation', 'Elastic network functions', 'SR-IOV guidance'],
                    ['Interconnect', 'Dense cross-connects', 'Simplify peering', 'Meet-me automation'],
                    ['Timing', 'SyncE / PTP options', 'Stricter mobile SLAs', 'GPS antenna paths'],
                    ['Scale', 'Modular power growth', 'Support rollout waves', 'Reserved capacity'],
                ],
                7,
            ),
            $this->solutionEntry(
                'Energy & Utilities',
                'energy-utilities',
                'zap',
                'OT/IT convergence zones, SCADA isolation, and real-time analytics for grid and utility operators.',
                ['OT/IT segmentation', 'SCADA isolation', 'Real-time analytics', 'NIS2-aligned controls'],
                ['energy sector hosting', 'utilities infrastructure', 'SCADA colocation', 'OT security'],
                [
                    ['Segmentation', 'OT DMZ patterns', 'Protect field assets', 'Unidirectional gateways'],
                    ['Analytics', 'Stream processing', 'Faster grid insights', 'Time-series DB tuning'],
                    ['Resilience', 'N+1 power & cooling', 'Maintain critical ops', 'Black-start planning'],
                    ['Compliance', 'NIS2 mapping', 'Regulator-ready docs', 'Incident reporting'],
                ],
                8,
            ),
            $this->solutionEntry(
                'Education & EdTech',
                'education-edtech',
                'graduation-cap',
                'Campus peering, LMS hosting, and research bursts with academic pricing and student privacy controls.',
                ['National research network peering', 'Student data privacy', 'Burst compute for exams', 'Academic pricing tiers'],
                ['education hosting', 'EdTech infrastructure', 'university colocation', 'research computing'],
                [
                    ['Peering', 'NREN connectivity', 'Fast research collaboration', 'Shared datasets'],
                    ['Privacy', 'FERPA/GDPR patterns', 'Protect student records', 'Role-based access'],
                    ['Exams', 'Burst capacity', 'Reliable online assessment', 'Isolated exam zones'],
                    ['EdTech', 'Multi-tenant guidance', 'Scale SaaS learners', 'API gateway colocation'],
                ],
                9,
            ),
            $this->solutionEntry(
                'Manufacturing & IoT',
                'manufacturing-iot',
                'factory',
                'Edge aggregation, digital twin workloads, and supply-chain integration with deterministic latency.',
                ['Edge aggregation gateways', 'Digital twin compute', 'Supply-chain integration', 'Deterministic factory latency'],
                ['manufacturing IoT', 'industrial hosting', 'digital twin infrastructure', 'edge colocation'],
                [
                    ['Edge', 'Plant-floor aggregation', 'Lower WAN costs', 'Local inference'],
                    ['Twins', 'Simulation clusters', 'Faster design iterations', 'GPU options'],
                    ['Integration', 'ERP/MES proximity', 'Reliable batch sync', 'Message bus patterns'],
                    ['Security', 'Zero-trust OT access', 'Reduce intrusion risk', 'Micro-segmentation'],
                ],
                10,
            ),
            $this->solutionEntry(
                'SaaS & Technology Scale-ups',
                'saas-technology-scaleups',
                'rocket',
                'Growth-ready colocation with predictable unit economics, rapid cross-connects, and investor-grade compliance.',
                ['Predictable unit economics', 'Rapid cross-connect provisioning', 'Investor-grade compliance packs', 'Scale without re-platforming'],
                ['SaaS hosting', 'scale-up infrastructure', 'B2B SaaS colocation', 'growth-ready hosting'],
                [
                    ['Growth', 'Reserved power ramps', 'Avoid emergency migrations', 'Modular suites'],
                    ['Economics', 'Transparent kW pricing', 'Forecast burn accurately', 'No hidden fees'],
                    ['Compliance', 'SOC 2 evidence', 'Accelerate enterprise sales', 'Customer security reviews'],
                    ['DevOps', 'CI/CD adjacent zones', 'Faster release cycles', 'GitOps-friendly network'],
                ],
                11,
            ),
            $this->solutionEntry(
                'Research & HPC',
                'research-hpc',
                'flask-conical',
                'Petascale-friendly density, R&E network fabrics, and high-density compute for universities and national labs.',
                ['Up to 50 kW per rack', 'Liquid cooling available', 'Academic network peering', 'High-density compute'],
                ['research computing', 'HPC colocation', 'scientific computing', 'AI research hosting'],
                [
                    ['Density', '50 kW racks', 'Train larger models', 'Liquid-ready halls'],
                    ['Fabric', 'HDR InfiniBand guidance', 'Lower MPI latency', 'Fat-tree designs'],
                    ['Data', 'Parallel filesystem tuning', 'Faster checkpointing', 'Burst storage tiers'],
                    ['Operations', '24/7 NOC coverage', 'Publish utilisation per job', 'Heat reuse options'],
                ],
                12,
            ),
        ];
    }

    /** @param  array<int, string>  $keywords
     * @param  array<int, array{title: string, description: string}>  $items
     * @return array<string, mixed>
     */
    private function serviceEntry(
        string $title,
        string $slug,
        string $category,
        string $icon,
        string $shortDescription,
        array $keywords,
        array $items,
        int $sortOrder,
    ): array {
        return [
            'title' => $title,
            'slug' => $slug,
            'category' => $category,
            'short_description' => $shortDescription,
            'icon' => $icon,
            'cta_text' => 'Start a Conversation',
            'cta_url' => '/contact',
            'sort_order' => $sortOrder,
            'status' => 'published',
            'keywords' => $keywords,
            'items' => $items,
        ];
    }

    /** @param  array<int, string>  $benefits
     * @param  array<int, string>  $keywords
     * @param  array<int, array<int, string>>  $tableRows
     * @return array<string, mixed>
     */
    private function solutionEntry(
        string $title,
        string $slug,
        string $icon,
        string $shortDescription,
        array $benefits,
        array $keywords,
        array $tableRows,
        int $sortOrder,
    ): array {
        return [
            'title' => $title,
            'slug' => $slug,
            'short_description' => $shortDescription,
            'icon' => $icon,
            'benefits' => $benefits,
            'cta_text' => 'Discuss Your Requirements',
            'cta_url' => '/contact',
            'sort_order' => $sortOrder,
            'status' => 'published',
            'keywords' => $keywords,
            'table_rows' => $tableRows,
        ];
    }
}
