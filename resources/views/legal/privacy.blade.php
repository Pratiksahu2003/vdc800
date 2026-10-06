@extends('layouts.app')

@section('title', 'Privacy Policy — ' . (settings('company.company_name') ?? 'VDC800'))
@section('meta_description', 'Learn how VDC800 collects, uses, and protects your personal data in accordance with GDPR and applicable privacy laws.')

@section('content')
@php
    $company = settings('company.company_name') ?? 'VDC800';
    $email = settings('company.email') ?? 'hello@vdc800.com';
@endphp

<x-legal-page
    title="Privacy Policy"
    description="How we collect, use, store, and protect your personal information when you visit our website or engage with our data centre services."
    :last-updated="$lastUpdated"
>
    <section id="introduction">
        <h2>1. Introduction</h2>
        <p>
            {{ $company }} ("we", "us", or "our") is committed to protecting your privacy and handling personal data responsibly.
            This Privacy Policy explains what information we collect, why we collect it, how we use it, and the rights you have under applicable data protection laws, including the General Data Protection Regulation (GDPR).
        </p>
        <p>
            This policy applies to visitors of our website, prospective and existing clients, partners, job applicants, and anyone who communicates with us through our digital channels or facilities.
        </p>
    </section>

    <section id="controller">
        <h2>2. Data Controller</h2>
        <p>The data controller responsible for your personal data is:</p>
        <ul>
            <li><strong>Company:</strong> {{ $company }}</li>
            @if(settings('company.address'))
                <li><strong>Address:</strong> {{ settings('company.address') }}@if(settings('company.city')), {{ settings('company.city') }}@endif @if(settings('company.postal_code')){{ settings('company.postal_code') }}@endif @if(settings('company.country')), {{ settings('company.country') }}@endif</li>
            @endif
            <li><strong>Email:</strong> <a href="mailto:{{ $email }}">{{ $email }}</a></li>
            @if(settings('company.phone'))
                <li><strong>Phone:</strong> {{ settings('company.phone') }}</li>
            @endif
        </ul>
    </section>

    <section id="data-we-collect">
        <h2>3. Information We Collect</h2>
        <p>Depending on how you interact with us, we may collect the following categories of personal data:</p>

        <h3>3.1 Information you provide directly</h3>
        <ul>
            <li>Contact details such as name, email address, phone number, and company name</li>
            <li>Messages and inquiries submitted through contact forms or email</li>
            <li>Account credentials for client portals or administrative systems</li>
            <li>Contract, billing, and service-related information for colocation and managed services</li>
            <li>Recruitment information if you apply for a role with us</li>
        </ul>

        <h3>3.2 Information collected automatically</h3>
        <ul>
            <li>IP address, browser type, device information, and operating system</li>
            <li>Pages visited, referral URLs, session duration, and interaction events</li>
            <li>Cookie and analytics data as described in our <a href="{{ route('legal.cookies') }}">Cookie Policy</a></li>
            <li>Security logs related to website access and authentication attempts</li>
        </ul>

        <h3>3.3 Information from third parties</h3>
        <ul>
            <li>Business contact details from partners, resellers, or publicly available professional sources</li>
            <li>Verification or compliance information where required for due diligence</li>
            <li>Payment or invoicing data from authorised payment processors</li>
        </ul>
    </section>

    <section id="how-we-use-data">
        <h2>4. How We Use Your Information</h2>
        <p>We process personal data only where we have a lawful basis to do so. Common purposes include:</p>
        <ul>
            <li>Responding to inquiries and providing sales or technical support</li>
            <li>Delivering colocation, connectivity, and managed infrastructure services</li>
            <li>Managing contracts, billing, and customer accounts</li>
            <li>Improving website performance, security, and user experience</li>
            <li>Sending service updates, operational notices, and marketing communications where permitted</li>
            <li>Meeting legal, regulatory, audit, and security obligations</li>
            <li>Protecting our facilities, systems, personnel, and clients from fraud or misuse</li>
        </ul>
    </section>

    <section id="legal-bases">
        <h2>5. Legal Bases for Processing</h2>
        <p>Under GDPR, we rely on one or more of the following legal bases:</p>
        <ul>
            <li><strong>Contract:</strong> Processing necessary to perform a contract or take steps at your request before entering a contract</li>
            <li><strong>Legitimate interests:</strong> Operating and securing our business, improving services, and communicating with prospects, balanced against your rights</li>
            <li><strong>Consent:</strong> Where required for non-essential cookies, marketing emails, or other optional processing</li>
            <li><strong>Legal obligation:</strong> Compliance with tax, accounting, security, and regulatory requirements</li>
        </ul>
    </section>

    <section id="sharing">
        <h2>6. How We Share Information</h2>
        <p>We do not sell your personal data. We may share information with:</p>
        <ul>
            <li>Trusted service providers such as hosting, analytics, email, CRM, and payment partners</li>
            <li>Professional advisers including lawyers, auditors, and insurers where necessary</li>
            <li>Regulators, courts, or law enforcement when required by law or to protect legal rights</li>
            <li>Affiliates or successors in the event of a corporate transaction, subject to appropriate safeguards</li>
        </ul>
        <p>All third parties are required to process data securely and only for authorised purposes.</p>
    </section>

    <section id="international-transfers">
        <h2>7. International Data Transfers</h2>
        <p>
            {{ $company }} primarily processes data within the European Economic Area (EEA).
            If data is transferred outside the EEA, we implement appropriate safeguards such as Standard Contractual Clauses or other mechanisms approved under applicable law.
        </p>
    </section>

    <section id="retention">
        <h2>8. Data Retention</h2>
        <p>We retain personal data only for as long as necessary for the purposes described in this policy, including:</p>
        <ul>
            <li>Active customer and contract records for the duration of the relationship and applicable limitation periods</li>
            <li>Contact form submissions and sales inquiries typically for up to 24 months unless a business relationship continues</li>
            <li>Website logs and security records for a limited period based on operational and legal requirements</li>
            <li>Marketing preferences until you withdraw consent or object to processing</li>
        </ul>
    </section>

    <section id="security">
        <h2>9. Security Measures</h2>
        <p>
            As a data centre operator, security is central to our business. We apply administrative, technical, and physical safeguards including access controls, encryption where appropriate, monitoring, staff training, and secure facility protocols to protect personal data against unauthorised access, loss, or misuse.
        </p>
    </section>

    <section id="your-rights">
        <h2>10. Your Rights</h2>
        <p>Depending on your location, you may have the right to:</p>
        <ul>
            <li>Access the personal data we hold about you</li>
            <li>Request correction of inaccurate or incomplete data</li>
            <li>Request deletion of data in certain circumstances</li>
            <li>Restrict or object to certain processing activities</li>
            <li>Request data portability where applicable</li>
            <li>Withdraw consent at any time for consent-based processing</li>
            <li>Lodge a complaint with your local data protection authority</li>
        </ul>
        <p>To exercise your rights, contact us at <a href="mailto:{{ $email }}">{{ $email }}</a>. We may need to verify your identity before responding.</p>
    </section>

    <section id="children">
        <h2>11. Children's Privacy</h2>
        <p>Our website and services are not directed at individuals under 16 years of age, and we do not knowingly collect personal data from children.</p>
    </section>

    <section id="changes">
        <h2>12. Changes to This Policy</h2>
        <p>We may update this Privacy Policy from time to time. Material changes will be posted on this page with an updated revision date. We encourage you to review this policy periodically.</p>
    </section>

    <section id="contact">
        <h2>13. Contact Us</h2>
        <p>If you have questions about this Privacy Policy or our data practices, please contact:</p>
        <ul>
            <li><strong>Email:</strong> <a href="mailto:{{ $email }}">{{ $email }}</a></li>
            @if(settings('company.phone'))
                <li><strong>Phone:</strong> {{ settings('company.phone') }}</li>
            @endif
            <li><strong>Contact form:</strong> <a href="{{ route('contact.index') }}">{{ route('contact.index') }}</a></li>
        </ul>
    </section>
</x-legal-page>
@endsection
