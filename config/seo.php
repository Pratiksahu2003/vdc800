<?php

return [

    'min_title_length' => 60,
    'max_title_length' => 70,

    /*
    |--------------------------------------------------------------------------
    | Static public page SEO (route name => meta)
    |--------------------------------------------------------------------------
    |
    | Title values are full document titles (already SEO-formatted).
    | Descriptions should stay within ~155–160 characters where possible.
    |
    */

    'title_boosters' => [
        'Global colocation & cloud connectivity',
        'Tier III+ data centre infrastructure',
    ],

    'entity_title_patterns' => [
        'service' => '{name} | Data Centre Services & Advisory | {company}',
        'solution' => '{name} | Enterprise Data Centre Solutions | {company}',
        'blog' => '{name} | Data Centre Insights & News | {company}',
        'data_centre' => '{name} | Global Data Centre Projects | {company}',
        'about' => 'About {company} | Global Data Centre Operator & Colocation',
    ],

    'pages' => [
        'home' => [
            'title' => 'D³ DataCenters | Global Data Centres, Colocation & Cloud Connectivity',
            'description' => null,
            'keywords' => null,
        ],
        'services.index' => [
            'title' => 'Data Centre Services & Infrastructure Advisory | D³ DataCenters',
            'description' => 'End-to-end data centre and AI infrastructure advisory — strategy, design, procurement, commissioning, and operations from D³ DataCenters.',
            'keywords' => 'data centre services, colocation advisory, AI infrastructure, data center consulting, Global data centres',
        ],
        'solutions.index' => [
            'title' => 'Enterprise Data Centre Solutions & Colocation | D³ DataCenters',
            'description' => 'Scalable data centre solutions for enterprises and cloud providers — colocation, connectivity, hybrid cloud, and mission-critical workloads.',
            'keywords' => 'data centre solutions, enterprise colocation, hybrid cloud, carrier-neutral connectivity, mission-critical hosting',
        ],
        'data-centre.index' => [
            'title' => 'Data Centre Projects & Global Facility Portfolio | D³ DataCenters',
            'description' => 'Explore D³ DataCenters projects and case studies — Global data centre design, build, and infrastructure advisory.',
            'keywords' => 'data centre projects, colocation facilities, Global data centers, infrastructure case studies, Tier III',
        ],
        'about.index' => [
            'title' => 'About D³ DataCenters | Global Data Centre Engineering & Operations',
            'description' => 'Learn about D³ DataCenters — global engineering, enterprise-grade data centre operations, and digital infrastructure worldwide.',
            'keywords' => 'about D³ DataCenters, Global data centre company, colocation operator, digital infrastructure',
        ],
        'blog.index' => [
            'title' => 'Data Centre Blog | Insights, News & Infrastructure Trends | D³',
            'description' => 'Insights on data centres, cloud infrastructure, sustainability, and digital innovation from the D³ DataCenters team.',
            'keywords' => 'data centre blog, colocation insights, cloud infrastructure news, Global data center trends',
        ],
        'contact.index' => [
            'title' => 'Contact D³ DataCenters | Colocation & Infrastructure Enquiries',
            'description' => 'Contact D³ DataCenters to discuss colocation, connectivity, and data centre requirements. Our team responds within one business day.',
            'keywords' => 'contact D³ DataCenters, colocation enquiry, data centre sales, Global infrastructure contact',
        ],
        'legal.privacy' => [
            'title' => 'Privacy Policy | D³ DataCenters GDPR & Personal Data Protection',
            'description' => 'How D³ DataCenters collects, uses, and protects personal data in line with GDPR and applicable privacy laws.',
            'keywords' => 'privacy policy, GDPR, personal data, D³ DataCenters privacy',
        ],
        'legal.terms' => [
            'title' => 'Website Terms of Service | D³ DataCenters Legal & Acceptable Use',
            'description' => 'D³ DataCenters website terms of service — acceptable use, intellectual property, liability, and governing law.',
            'keywords' => 'terms of service, website terms, D³ DataCenters legal',
        ],
        'legal.cookies' => [
            'title' => 'Cookie Policy | D³ DataCenters Cookies & Tracking Preferences',
            'description' => 'How D³ DataCenters uses cookies and similar technologies, and how you can manage your preferences.',
            'keywords' => 'cookie policy, cookies, website tracking, D³ DataCenters',
        ],
    ],

    'entity_keywords' => [
        'service' => ['data centre services', 'infrastructure advisory', 'colocation consulting'],
        'solution' => ['data centre solutions', 'enterprise infrastructure', 'colocation'],
        'blog' => ['data centre blog', 'infrastructure insights', 'industry news'],
        'data_centre' => ['data centre project', 'Global colocation', 'facility design'],
    ],

];
