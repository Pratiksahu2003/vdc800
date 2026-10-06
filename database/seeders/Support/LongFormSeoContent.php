<?php

namespace Database\Seeders\Support;

class LongFormSeoContent
{
    public static function wordCount(string $html): int
    {
        return str_word_count(html_entity_decode(strip_tags($html), ENT_QUOTES, 'UTF-8'));
    }

    public static function serviceBody(
        string $title,
        string $category,
        string $slug,
        array $focusKeywords,
        array $tableRows,
    ): string {
        $keywordPhrase = implode(', ', $focusKeywords);
        $html = self::serviceIntro($title, $category, $keywordPhrase);
        $html .= self::comparisonTable("{$title} capability matrix", $tableRows);
        $html .= self::section(
            "Why enterprises choose VDC800 for {$title}",
            self::paragraphs($title, $category, [
                "Organisations across Northern Europe select VDC800 when {$title} must combine predictable performance with verifiable SLAs. Our Nordic facilities deliver carrier-neutral connectivity, concurrent maintainability, and transparent operational reporting that satisfies both technical stakeholders and executive committees.",
                "Unlike generic hosting providers, we engineer {$category} offerings around measurable outcomes: latency budgets, recovery time objectives, power density headroom, and audit-ready documentation. Every deployment includes a structured onboarding workshop, architecture review, and runbook aligned to your internal change-management process.",
                "Clients migrating from legacy facilities frequently cite three drivers: lower PUE in cool-climate sites, direct cloud on-ramps that remove unpredictable internet transit, and remote hands teams who understand enterprise change windows. {$title} at VDC800 is designed to compress time-to-production without sacrificing governance.",
                "Our account teams publish quarterly business reviews covering capacity utilisation, incident trends, availability per workload, and roadmap items such as liquid cooling or additional cross-connects. This operating rhythm keeps {$title} aligned with growth plans rather than reactive ticket queues.",
            ])
        );
        $html .= self::slaTable($title);
        $html .= self::section(
            'Architecture and design principles',
            self::paragraphs($title, $category, [
                "VDC800 halls implement Tier III+ topology: independent power paths, N+1 cooling, segregated security zones, and structured cabling that supports moves, adds, and changes without planned downtime. For {$title}, we map your workload profile to rack placement, power feeds, and network diversity before any equipment ships.",
                "Power delivery supports traditional 230V deployments and high-density configurations up to 50 kW per rack where liquid-assisted cooling is provisioned. Busway and PDU layouts are documented in as-built diagrams delivered through our customer portal, simplifying capacity planning for {$category} expansions.",
                "Network design emphasises east-west efficiency inside the meet-me room and north-south optimisation toward public cloud regions. When {$title} requires hybrid connectivity, we model BGP policies, failover scenarios, and encryption boundaries with your network architects.",
                "Environmental systems leverage free-air economisation for a significant portion of the year, holding facility PUE near 1.12 while maintaining ASHRAE-compliant inlet conditions. Heat rejection strategies are monitored continuously; anomalies trigger automated alerts to the network operations centre.",
            ])
        );
        $html .= self::section(
            'Security, compliance, and operational assurance',
            self::paragraphs($title, $category, [
                "Physical security layers include perimeter controls, mantraps, biometric access, continuous CCTV, and visitor escort policies. Logical controls for {$title} complement physical measures with role-based portal access, MFA enforcement, and tamper-evident logging suitable for SOC 2 and recognised security framework examinations.",
                "Compliance support packages provide control mapping templates, evidence collection cadences, and liaison during external audits. Financial services, healthcare, and public-sector clients rely on these artefacts to demonstrate that {$category} infrastructure meets jurisdictional requirements across the EU and EEA.",
                "Incident response integrates with your major incident process: severity classification, stakeholder notifications, root-cause analysis, and corrective action tracking. Tabletop exercises for {$title} scenarios—utility failure, fibre cut, firmware vulnerability—are offered annually.",
                "Supply chain integrity covers hardware receiving, anti-tamper seals, secure staging, and documented chain-of-custody when equipment moves between loading bays and production halls.",
            ])
        );
        $html .= self::operationsSection($title);
        $html .= self::deploymentPlaybook($title, $category);
        $html .= self::faqSection($title, $focusKeywords);
        $html .= self::conclusion($title, $slug, 'services');

        $sectionIndex = 0;
        while (self::wordCount($html) < 2000) {
            $html .= self::section(
                "Operational deep dive: {$title} (part ".($sectionIndex + 2).')',
                self::paragraphs($title, $category, self::extraParagraphs($title, $category, $sectionIndex))
            );
            $sectionIndex++;
        }

        return $html;
    }

    public static function solutionBody(
        string $title,
        string $slug,
        array $benefits,
        array $tableRows,
        array $focusKeywords,
    ): string {
        $keywordPhrase = implode(', ', $focusKeywords);
        $html = self::solutionIntro($title, $keywordPhrase, $benefits);
        $html .= self::comparisonTable("{$title} solution benchmarks", $tableRows);
        $html .= self::benefitsList($benefits);
        $html .= self::section(
            "Industry context for {$title}",
            self::paragraphs($title, 'vertical solutions', [
                "Digital leaders in {$title} face simultaneous pressure to innovate faster, protect sensitive data, and report environmental impact with the same rigour as financial metrics. VDC800 vertical solutions translate these pressures into an infrastructure blueprint with clear SLAs, compliance pathways, and scalability milestones.",
                "Regulatory evolution across the EU continues to raise expectations for data residency, breach notification, and third-party risk management. Our {$title} reference architectures document how workloads map to geographic zones, encryption standards, and retention policies without creating operational silos.",
                "Buyer committees increasingly include operations and risk officers who require proof that compute growth does not equate to unchecked downtime. Published PUE data and 99.999% availability targets allow {$title} organisations to align infrastructure decisions with board-level SLAs.",
                "Talent shortages in specialised IT roles make managed capabilities attractive: remote hands, observability integration, and vendor coordination become extensions of your team rather than ad hoc escalations.",
            ])
        );
        $html .= self::slaTable($title);
        $html .= self::section(
            'Reference architecture overview',
            self::paragraphs($title, 'vertical solutions', [
                "We begin with a discovery workshop capturing transaction volumes, seasonality, integration endpoints, and recovery objectives. The output is a phased diagram showing production, staging, and analytics tiers with explicit network paths and security controls.",
                "High availability patterns leverage diverse fibre entry, redundant power, and application-level failover guidance. For latency-sensitive {$title} workloads, we validate round-trip times to end users, partners, and cloud regions before hardware procurement.",
                "Data protection layers include encrypted backup targets, immutable snapshots where required, and documented restore drills. RPO and RTO targets are tracked in service dashboards visible to technical and executive sponsors.",
                "Observability hooks support export to your SIEM, APM, and ITSM tools so operational telemetry remains centralised. Runbooks define escalation paths for events that originate in the facility versus application tiers.",
            ])
        );
        $html .= self::section(
            'Governance, risk, and compliance alignment',
            self::paragraphs($title, 'vertical solutions', [
                "Control libraries map facility and managed services controls to frameworks commonly referenced in {$title}, including GDPR, NIS2, SOC 2, and sector-specific annexes. Evidence packs accelerate audits by pre-indexing policies, penetration test summaries, and change records.",
                "Third-party risk assessments receive structured responses covering sub-processor lists, data flow diagrams, and business continuity test results. Legal and procurement teams gain predictable documentation instead of bespoke questionnaires for every review cycle.",
                "Privacy-by-design workshops identify data minimisation opportunities, pseudonymisation strategies, and retention schedules that reduce long-term liability while preserving analytical value.",
            ])
        );
        $html .= self::operationsSection($title);
        $html .= self::section(
            'Commercial models and engagement options',
            self::paragraphs($title, 'vertical solutions', [
                "Engagements may start with a pilot rack or dedicated suite before scaling to multi-megawatt footprints. Transparent unit economics—per kW, per cross-connect, per managed device—help finance teams forecast multi-year totals under different growth scenarios.",
                "Enterprise agreements can bundle power, space, remote hands hours, and cross-connects with annual true-ups tied to actual consumption. This flexibility suits {$title} organisations whose digital demand curves are non-linear.",
                "Professional services augment colocation with migration planning, cutover support, and post-go-live optimisation reviews. Statements of work define deliverables, acceptance criteria, and knowledge transfer milestones.",
            ])
        );
        $html .= self::faqSection($title, $focusKeywords);
        $html .= self::conclusion($title, $slug, 'solutions');

        $sectionIndex = 0;
        while (self::wordCount($html) < 2000) {
            $html .= self::section(
                "Implementation insights for {$title} (volume ".($sectionIndex + 2).')',
                self::paragraphs($title, 'vertical solutions', self::extraParagraphs($title, 'vertical solutions', $sectionIndex))
            );
            $sectionIndex++;
        }

        return $html;
    }

    public static function metaDescription(string $title, string $type, array $keywords): string
    {
        $base = "Explore {$title} with VDC800: ".implode(', ', array_slice($keywords, 0, 3))
            .". Nordic Tier III+ facilities, 99.999% uptime SLA, and expert {$type} support across Europe.";

        return mb_strlen($base) > 158 ? mb_substr($base, 0, 155).'...' : $base;
    }

    public static function metaTitle(string $title, string $suffix = 'VDC800'): string
    {
        $candidate = "{$title} | {$suffix}";
        if (mb_strlen($candidate) <= 60) {
            return $candidate;
        }

        return mb_substr($title, 0, 60 - mb_strlen(" | {$suffix}") - 3).'... | '.$suffix;
    }

    private static function serviceIntro(string $title, string $category, string $keywords): string
    {
        return <<<HTML
<p><strong>{$title}</strong> from VDC800 delivers enterprise-grade {$category} from Nordic data centres engineered for 99.999% availability, enterprise-grade security controls, and 24/7 operational coverage. This comprehensive guide explains how we design, deploy, and operate {$title} for organisations that cannot compromise on resilience, compliance, or performance.</p>
<p>Whether you are consolidating legacy footprints, launching latency-sensitive platforms, or expanding hybrid cloud estates, our specialists align {$keywords} with measurable business outcomes. The following sections cover architecture, SLAs, security controls, operational metrics, and a practical deployment playbook you can share with technical and executive stakeholders.</p>
HTML;
    }

    private static function solutionIntro(string $title, string $keywords, array $benefits): string
    {
        $benefitText = implode(', ', array_slice($benefits, 0, 4));

        return <<<HTML
<p>VDC800's <strong>{$title}</strong> solution combines colocation, connectivity, and managed capabilities into a vertical blueprint tuned for regulated, high-growth, and data-intensive organisations. Built on Nordic Tier III+ infrastructure, the solution addresses {$keywords} while delivering {$benefitText}.</p>
<p>This page documents reference architectures, compliance alignment, operational models, and availability advantages so your team can evaluate fit, prepare internal business cases, and plan phased adoption with confidence.</p>
HTML;
    }

    private static function section(string $heading, string $body): string
    {
        return "<h2>{$heading}</h2>\n{$body}";
    }

    private static function paragraphs(string $title, string $context, array $lines): string
    {
        return implode("\n", array_map(fn (string $line) => "<p>{$line}</p>", $lines));
    }

    private static function comparisonTable(string $caption, array $rows): string
    {
        $header = <<<'HTML'
<table>
    <caption>Table 1. {$caption}</caption>
    <thead>
        <tr>
            <th>Capability</th>
            <th>Specification</th>
            <th>Business outcome</th>
            <th>Notes</th>
        </tr>
    </thead>
    <tbody>
HTML;
        $header = str_replace('{$caption}', $caption, $header);

        $body = '';
        foreach ($rows as $row) {
            $body .= '<tr>'
                .'<td>'.e($row[0]).'</td>'
                .'<td>'.e($row[1]).'</td>'
                .'<td>'.e($row[2]).'</td>'
                .'<td>'.e($row[3]).'</td>'
                .'</tr>';
        }

        return $header.$body.'</tbody></table>';
    }

    private static function slaTable(string $title): string
    {
        return <<<HTML
<h2>Service levels and operational metrics</h2>
<p>The table below summarises standard targets for {$title} deployments at VDC800. Custom enterprise agreements may refine thresholds while preserving core resilience principles.</p>
<table>
    <caption>Table 2. SLA and operational targets</caption>
    <thead>
        <tr>
            <th>Metric</th>
            <th>Target</th>
            <th>Measurement window</th>
            <th>Remediation</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Facility availability</td>
            <td>99.999%</td>
            <td>Calendar month</td>
            <td>Service credits per master agreement</td>
        </tr>
        <tr>
            <td>Critical incident acknowledgement</td>
            <td>&lt; 15 minutes</td>
            <td>Per incident</td>
            <td>Escalation to duty manager</td>
        </tr>
        <tr>
            <td>Remote hands response (standard)</td>
            <td>&lt; 2 hours</td>
            <td>Business hours</td>
            <td>Expedited tiers available 24/7</td>
        </tr>
        <tr>
            <td>PUE (facility average)</td>
            <td>1.12 – 1.18</td>
            <td>Quarterly</td>
            <td>Continuous optimisation programme</td>
        </tr>
        <tr>
            <td>Power redundancy</td>
            <td>N+1</td>
            <td>Continuous</td>
            <td>Dual utility and UPS paths</td>
        </tr>
        <tr>
            <td>Change success rate</td>
            <td>&gt; 99.5%</td>
            <td>Quarterly</td>
            <td>Root-cause review for failed changes</td>
        </tr>
    </tbody>
</table>
HTML;
    }

    private static function benefitsList(array $benefits): string
    {
        $items = implode('', array_map(fn (string $b) => '<li>'.e($b).'</li>', $benefits));

        return "<h2>Core benefits</h2><ul>{$items}</ul>";
    }

    private static function operationsSection(string $title): string
    {
        return <<<HTML
<h2>Operations and availability</h2>
<p>{$title} workloads hosted at VDC800 run in Tier III+ Nordic facilities with concurrent maintainability, 24/7 NOC coverage, and published availability metrics. Customers receive operational reports suitable for internal audits, board reporting, and customer RFP questionnaires.</p>
<p>Cool-climate siting reduces mechanical cooling demand and helps hold facility PUE near 1.12. We publish facility PUE, capacity utilisation, and incident trends so stakeholders can plan growth with confidence.</p>
<p>Choosing Nordic colocation can materially improve latency to European markets and reduce operational risk—an advantage for organisations that need predictable infrastructure while application teams continue to scale.</p>
HTML;
    }

    private static function deploymentPlaybook(string $title, string $category): string
    {
        return <<<HTML
<h2>Deployment playbook</h2>
<ol>
    <li><strong>Discovery:</strong> Capture workload profiles, compliance drivers, connectivity requirements, and growth forecasts for {$title}.</li>
    <li><strong>Design:</strong> Produce rack elevations, power budgets, cable maps, and failover diagrams validated by VDC800 solutions architects.</li>
    <li><strong>Procurement:</strong> Coordinate hardware delivery, customs clearance when needed, and secure staging in designated build rooms.</li>
    <li><strong>Installation:</strong> Execute cabling, power-up, burn-in, and logical turn-up with change tickets aligned to your maintenance windows.</li>
    <li><strong>Test:</strong> Run failover tests, latency baselines, backup restores, and monitoring integrations before production cutover.</li>
    <li><strong>Operate:</strong> Transition to steady-state with quarterly reviews, capacity alerts, and SLA reporting for {$category} stakeholders.</li>
</ol>
HTML;
    }

    private static function faqSection(string $title, array $keywords): string
    {
        $kw = $keywords[0] ?? 'infrastructure';

        return <<<HTML
<h2>Frequently asked questions</h2>
<h3>How quickly can we deploy {$title}?</h3>
<p>Standard rack allocations are typically available within 5–10 business days after contract signature, subject to power and connectivity prerequisites. Custom suites or high-density pods may require additional engineering lead time communicated during design.</p>
<h3>Do you support hybrid cloud for {$kw}?</h3>
<p>Yes. Carrier-neutral meet-me rooms provide direct on-ramps to major public clouds and private links to corporate SD-WAN hubs, reducing reliance on unpredictable internet transit paths.</p>
<h3>What compliance artefacts are included?</h3>
<p>Customers receive SOC reports, compliance certificates, control matrices, and sub-processor documentation. Tailored packs for GDPR, PCI DSS, or sector regulators can be assembled with professional services.</p>
<h3>Can we scale power without migrating sites?</h3>
<p>Modular hall design and reserved busway capacity enable in-place upgrades for many deployments, preserving operational familiarity and avoiding costly relocation projects.</p>
<h3>How is operational performance reported?</h3>
<p>Quarterly operations summaries include PUE trends, capacity utilisation, incident metrics, and optional allocation of power per kW provisioned to your organisation.</p>
HTML;
    }

    /** @param  array<int, array{title: string, description: string}>  $items */
    public static function advisoryServiceBody(
        string $title,
        string $shortDescription,
        array $items,
        array $focusKeywords,
    ): string {
        $keywordPhrase = implode(', ', $focusKeywords);
        $itemsHtml = '';

        foreach ($items as $item) {
            $itemsHtml .= '<h3>'.e($item['title']).'</h3>';
            $itemsHtml .= '<p>'.e($item['description']).'</p>';
        }

        return <<<HTML
<p>{$shortDescription}</p>
<h2>What we deliver</h2>
{$itemsHtml}
<h2>Why it matters</h2>
<p>Data center and AI infrastructure decisions carry significant commercial, technical and execution risk. {$title} brings structured analysis and practical guidance so stakeholders can move from opportunity to action with greater confidence.</p>
<p>Our multidisciplinary team combines commercial understanding, engineering depth and delivery experience across {$keywordPhrase}. We work alongside investors, developers and operators to align assumptions, surface risks early and define clear next steps.</p>
<h2>How we work</h2>
<p>Engagements typically begin with a focused discovery conversation to understand your objectives, constraints and timeline. We then scope the work, assign the right specialists and deliver decision-ready outputs — whether that is a feasibility assessment, due diligence report, design recommendation or procurement plan.</p>
<p>Where projects continue into engineering, procurement or demand development, we maintain continuity so commercial and technical decisions stay connected throughout the journey.</p>
<h2>Get started</h2>
<p>Whether you are evaluating a new data center opportunity, assessing an investment, designing high-density infrastructure or connecting capacity with qualified demand, we can help identify the next critical step. <a href="/contact">Contact us</a> to discuss your requirements.</p>
HTML;
    }

    private static function conclusion(string $title, string $slug, string $type): string
    {
        $path = $type === 'services' ? 'services' : 'solutions';

        return <<<HTML
<h2>Next steps</h2>
<p>VDC800 partners with enterprises, public institutions, and digital natives who require {$title} without trading away availability or compliance readiness. Speak with our solutions team for a tailored workshop, site tour, or proof-of-concept architecture review.</p>
<p>Explore related offerings across our portfolio, review case studies on our blog, or <a href="/contact">contact us</a> to request pricing for <a href="/{$path}/{$slug}">{$title}</a>. We respond to qualified enquiries within one business day.</p>
HTML;
    }

    /** @return array<int, string> */
    private static function extraParagraphs(string $title, string $context, int $seed): array
    {
        $variants = [
            [
                "Capacity planning for {$title} incorporates seasonal demand, hardware refresh cycles, and licence true-ups. VDC800 provides forward-looking power and port utilisation forecasts so finance and engineering teams share a single source of truth.",
                "Integration with ITSM tools allows change records, work orders, and asset tags to synchronise between your CMDB and our operations platform. This reduces manual reconciliation during audits and accelerates mean time to repair when incidents occur.",
                "For multinational programmes, we coordinate staging windows across time zones, ensuring remote hands coverage aligns with your release trains. Escalation paths are documented in bilingual runbooks where required.",
                "Benchmarking studies show Nordic {$context} deployments often achieve lower total cost of ownership over five years when cooling advantages and power economics are modelled honestly alongside list colocation rates.",
            ],
            [
                "Observability for {$title} should span environmental sensors, power draw, network optics, and application golden signals. We provide facility feeds that complement your existing dashboards rather than forcing proprietary silos.",
                "Vendor management is streamlined through approved hardware lists, RMA logistics, and secure disposal services that meet WEEE directives. Asset retirement certificates support compliance programmes that demand traceable destruction.",
                "Training sessions for your operations staff cover emergency procedures, visitor policies, and smart hands request best practices—reducing failed truck rolls and miscommunicated work orders.",
                "Innovation roadmaps include liquid cooling pilots, high-voltage DC research, and AI-assisted capacity optimisation. Early adopters in {$context} can join design partner programmes with transparent feedback loops.",
            ],
            [
                "Business continuity exercises validate failover assumptions for {$title}, including simulated utility loss and fibre path withdrawal. Findings feed into continuous improvement plans tracked at executive review cadences.",
                "Contract structures may include availability-linked incentives tying service credits to published operational KPIs, reinforcing shared responsibility for efficient resource use.",
                "Edge cases—such as delayed shipments, customs holds, or emergency power transfers—are handled through playbooks tested during onboarding. Customers receive single points of contact for cross-functional issues.",
                "Long-term partnerships often evolve from single-site colocation to multi-facility active/active designs; VDC800 documents latency and replication guidance when {$title} expands across campuses.",
            ],
        ];

        return $variants[$seed % count($variants)];
    }
}
