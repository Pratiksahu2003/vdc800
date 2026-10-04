<?php

namespace Database\Seeders\Support;

final class SolutionCatalog
{
    /** @return array<int, array<string, mixed>> */
    public static function definitions(): array
    {
        return [
self::entry(
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
            self::entry(
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
            self::entry(
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
            self::entry(
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
            self::entry(
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
            self::entry(
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
            self::entry(
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
            self::entry(
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
            self::entry(
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
            self::entry(
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
            self::entry(
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
            self::entry(
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

    /** @param  array<int, string>  $benefits
     * @param  array<int, string>  $keywords
     * @param  array<int, array<int, string>>  $tableRows
     * @return array<string, mixed>
     */
    private static function entry(
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
