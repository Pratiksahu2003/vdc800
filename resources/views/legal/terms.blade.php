@extends('layouts.app')

@section('title', 'Terms of Service — ' . (settings('company.company_name') ?? 'VDC800'))
@section('meta_description', 'Read the VDC800 website terms of service covering acceptable use, intellectual property, liability, and governing law.')

@section('content')
@php
    $company = settings('company.company_name') ?? 'VDC800';
    $email = settings('company.email') ?? 'hello@vdc800.com';
@endphp

<x-legal-page
    title="Terms of Service"
    description="The terms and conditions governing your access to and use of the VDC800 website and related digital services."
    :last-updated="$lastUpdated"
>
    <section id="acceptance">
        <h2>1. Acceptance of Terms</h2>
        <p>
            By accessing or using the website operated by {{ $company }} ("we", "us", or "our"), you agree to be bound by these Terms of Service ("Terms").
            If you do not agree with these Terms, you must not use our website.
        </p>
        <p>
            Separate written agreements, service orders, master service agreements, or colocation contracts govern the provision of infrastructure and professional services. Where there is a conflict between these Terms and a signed service agreement, the signed agreement prevails for that service.
        </p>
    </section>

    <section id="services">
        <h2>2. About Our Services</h2>
        <p>
            {{ $company }} provides enterprise data centre infrastructure, colocation, cloud connectivity, and related managed services across Nordic facilities.
            Information on this website is provided for general informational purposes and does not constitute a binding offer unless expressly confirmed in writing.
        </p>
    </section>

    <section id="eligibility">
        <h2>3. Eligibility and Account Use</h2>
        <p>You represent that you are at least 18 years old and have authority to enter into these Terms on behalf of yourself or the organisation you represent.</p>
        <p>If you receive access credentials to a client portal or administrative system, you are responsible for maintaining the confidentiality of your login details and for all activity under your account.</p>
    </section>

    <section id="acceptable-use">
        <h2>4. Acceptable Use</h2>
        <p>You agree not to use our website or digital systems to:</p>
        <ul>
            <li>Violate applicable laws, regulations, or third-party rights</li>
            <li>Upload or transmit malicious code, spam, or harmful content</li>
            <li>Attempt unauthorised access to our systems, networks, or data</li>
            <li>Interfere with website availability, security, or performance</li>
            <li>Scrape, harvest, or automate access in a manner that exceeds reasonable use</li>
            <li>Misrepresent your identity or affiliation with {{ $company }}</li>
        </ul>
        <p>We reserve the right to suspend or restrict access where we reasonably believe these Terms have been violated.</p>
    </section>

    <section id="intellectual-property">
        <h2>5. Intellectual Property</h2>
        <p>
            All content on this website — including text, graphics, logos, images, software, and design elements — is owned by or licensed to {{ $company }} and protected by intellectual property laws.
            You may view and download content for personal or internal business reference only. You may not copy, modify, distribute, sell, or create derivative works without our prior written consent.
        </p>
        <p>The VDC800 name, logo, and related branding may not be used without express permission.</p>
    </section>

    <section id="third-party-links">
        <h2>6. Third-Party Links</h2>
        <p>
            Our website may contain links to third-party websites or services. We do not control and are not responsible for the content, privacy practices, or availability of those external sites.
            Accessing third-party links is at your own risk.
        </p>
    </section>

    <section id="disclaimers">
        <h2>7. Disclaimers</h2>
        <p>
            We strive to keep website content accurate and up to date, but we make no warranties that information is complete, current, or error-free.
            The website and its content are provided on an "as is" and "as available" basis to the fullest extent permitted by law.
        </p>
        <p>
            Performance metrics, facility specifications, availability figures, and sustainability data are indicative and may change. Final service commitments are defined only in applicable contracts and service level agreements.
        </p>
    </section>

    <section id="liability">
        <h2>8. Limitation of Liability</h2>
        <p>
            To the maximum extent permitted by applicable law, {{ $company }} shall not be liable for any indirect, incidental, special, consequential, or punitive damages arising from your use of the website.
        </p>
        <p>
            Nothing in these Terms excludes or limits liability that cannot be excluded under applicable law, including liability for fraud, wilful misconduct, or death or personal injury caused by negligence.
        </p>
    </section>

    <section id="indemnity">
        <h2>9. Indemnity</h2>
        <p>
            You agree to indemnify and hold harmless {{ $company }}, its directors, employees, and affiliates from claims, losses, or expenses arising from your misuse of the website or breach of these Terms, except to the extent caused by our own negligence or wilful misconduct.
        </p>
    </section>

    <section id="privacy">
        <h2>10. Privacy and Cookies</h2>
        <p>
            Your use of the website is also governed by our <a href="{{ route('legal.privacy') }}">Privacy Policy</a> and <a href="{{ route('legal.cookies') }}">Cookie Policy</a>, which explain how we process personal data and use cookies.
        </p>
    </section>

    <section id="termination">
        <h2>11. Suspension and Termination</h2>
        <p>
            We may modify, suspend, or discontinue any part of the website at any time without notice.
            We may also terminate or restrict your access if you breach these Terms or if continued access poses a security or legal risk.
        </p>
    </section>

    <section id="governing-law">
        <h2>12. Governing Law and Disputes</h2>
        <p>
            These Terms are governed by the laws of Norway, without regard to conflict of law principles, unless mandatory local consumer protection laws require otherwise.
            Disputes arising from these Terms shall be subject to the exclusive jurisdiction of the courts of Oslo, Norway, unless applicable law provides otherwise.
        </p>
    </section>

    <section id="changes">
        <h2>13. Changes to These Terms</h2>
        <p>
            We may revise these Terms from time to time. Updated Terms will be posted on this page with a revised date.
            Continued use of the website after changes become effective constitutes acceptance of the updated Terms.
        </p>
    </section>

    <section id="contact">
        <h2>14. Contact</h2>
        <p>For questions regarding these Terms, please contact:</p>
        <ul>
            <li><strong>Email:</strong> <a href="mailto:{{ $email }}">{{ $email }}</a></li>
            @if(settings('company.phone'))
                <li><strong>Phone:</strong> {{ settings('company.phone') }}</li>
            @endif
            <li><strong>Website:</strong> <a href="{{ route('contact.index') }}">Contact page</a></li>
        </ul>
    </section>
</x-legal-page>
@endsection
