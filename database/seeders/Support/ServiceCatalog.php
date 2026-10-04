<?php

namespace Database\Seeders\Support;

final class ServiceCatalog
{
    /** @return array<int, array<string, mixed>> */
    public static function definitions(): array
    {
        return [
self::entry(
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
            self::entry(
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
            self::entry(
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
            self::entry(
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
            self::entry(
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

    /** @param  array<int, string>  $keywords
     * @param  array<int, array{title: string, description: string}>  $items
     * @return array<string, mixed>
     */
    private static function entry(
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
}
