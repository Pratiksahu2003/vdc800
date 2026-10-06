@extends('layouts.app')

@section('title', 'Cookie Policy — ' . (settings('company.company_name') ?? 'VDC800'))
@section('meta_description', 'Understand how VDC800 uses cookies and similar technologies on our website, and how you can manage your preferences.')

@section('content')
@php
    $company = settings('company.company_name') ?? 'VDC800';
    $email = settings('company.email') ?? 'hello@vdc800.com';
@endphp

<x-legal-page
    title="Cookie Policy"
    description="Details about the cookies and similar technologies we use, why we use them, and how you can control your preferences."
    :last-updated="$lastUpdated"
>
    <section id="introduction">
        <h2>1. What Are Cookies?</h2>
        <p>
            Cookies are small text files placed on your device when you visit a website. They help websites function properly, remember preferences, improve performance, and understand how visitors interact with content.
        </p>
        <p>
            {{ $company }} uses cookies and similar technologies such as local storage on our website in accordance with this policy and applicable privacy laws.
        </p>
    </section>

    <section id="how-we-use-cookies">
        <h2>2. How We Use Cookies</h2>
        <p>We use cookies for the following purposes:</p>
        <ul>
            <li><strong>Essential operation:</strong> Enabling core website functionality and security</li>
            <li><strong>Preferences:</strong> Remembering choices such as cookie consent status</li>
            <li><strong>Analytics:</strong> Understanding traffic patterns and improving content</li>
            <li><strong>Marketing:</strong> Measuring campaign effectiveness where applicable and permitted</li>
        </ul>
    </section>

    <section id="cookie-types">
        <h2>3. Types of Cookies We Use</h2>
        <table>
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Purpose</th>
                    <th>Examples</th>
                    <th>Duration</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Strictly necessary</strong></td>
                    <td>Required for website security, session management, and load balancing</td>
                    <td>Session ID, CSRF protection, consent storage</td>
                    <td>Session to 12 months</td>
                </tr>
                <tr>
                    <td><strong>Functional</strong></td>
                    <td>Remembers preferences and improves usability</td>
                    <td>Cookie consent choice, language preference</td>
                    <td>Up to 12 months</td>
                </tr>
                <tr>
                    <td><strong>Analytics</strong></td>
                    <td>Helps us measure visits, page performance, and user journeys</td>
                    <td>Google Analytics or similar tools, if enabled</td>
                    <td>Up to 24 months</td>
                </tr>
                <tr>
                    <td><strong>Marketing</strong></td>
                    <td>Supports campaign measurement and relevant advertising, where enabled</td>
                    <td>Conversion pixels, remarketing tags</td>
                    <td>Up to 24 months</td>
                </tr>
            </tbody>
        </table>
    </section>

    <section id="first-third-party">
        <h2>4. First-Party and Third-Party Cookies</h2>
        <p><strong>First-party cookies</strong> are set directly by {{ $company }} and are primarily used for essential functionality and consent management.</p>
        <p><strong>Third-party cookies</strong> may be set by analytics, advertising, or embedded content providers when such services are enabled on our website. These providers process data according to their own privacy policies.</p>
    </section>

    <section id="similar-technologies">
        <h2>5. Similar Technologies</h2>
        <p>In addition to cookies, we may use:</p>
        <ul>
            <li><strong>Local storage:</strong> To store cookie consent preferences in your browser</li>
            <li><strong>Server logs:</strong> To record IP addresses, timestamps, and request metadata for security monitoring</li>
            <li><strong>Pixels and tags:</strong> To measure engagement with emails or campaigns where enabled</li>
        </ul>
    </section>

    <section id="consent">
        <h2>6. Cookie Consent</h2>
        <p>
            When you first visit our website, we display a cookie notice allowing you to accept cookies.
            Non-essential cookies are used only where permitted by law and, where required, after you provide consent.
        </p>
        <p>
            You can reopen the cookie notice at any time using the <strong>Cookies</strong> link in the website footer.
        </p>
    </section>

    <section id="managing-preferences">
        <h2>7. Managing Your Preferences</h2>
        <p>You can control cookies in several ways:</p>
        <ul>
            <li>Use the cookie banner or footer link to review your consent choice</li>
            <li>Adjust browser settings to block or delete cookies</li>
            <li>Use private or incognito browsing modes</li>
            <li>Install browser extensions that manage tracking preferences</li>
        </ul>
        <p>
            Please note that blocking strictly necessary cookies may affect website functionality, including form submissions and secure areas.
        </p>
        <div class="mt-4">
            <button
                type="button"
                onclick="localStorage.removeItem('cookie_accepted'); window.dispatchEvent(new CustomEvent('show-cookie-notice'))"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-red-500 hover:bg-brand-red-600 text-white text-sm font-medium rounded-lg transition"
            >
                <i data-lucide="cookie" class="w-4 h-4"></i>
                Manage Cookie Preferences
            </button>
        </div>
    </section>

    <section id="browser-controls">
        <h2>8. Browser Controls</h2>
        <p>Most browsers allow you to manage cookies through their settings. Useful resources include:</p>
        <ul>
            <li><a href="https://support.google.com/chrome/answer/95647" target="_blank" rel="noopener noreferrer">Google Chrome cookie settings</a></li>
            <li><a href="https://support.mozilla.org/en-US/kb/enhanced-tracking-protection-firefox-desktop" target="_blank" rel="noopener noreferrer">Mozilla Firefox privacy settings</a></li>
            <li><a href="https://support.apple.com/guide/safari/manage-cookies-sfri11471/mac" target="_blank" rel="noopener noreferrer">Safari cookie settings</a></li>
            <li><a href="https://support.microsoft.com/en-us/microsoft-edge/delete-cookies-in-microsoft-edge-63947406-40ac-c3b8-57b9-2a946a29ae09" target="_blank" rel="noopener noreferrer">Microsoft Edge cookie settings</a></li>
        </ul>
    </section>

    <section id="updates">
        <h2>9. Updates to This Policy</h2>
        <p>
            We may update this Cookie Policy to reflect changes in technology, legal requirements, or our website practices.
            The latest version will always be available on this page with an updated revision date.
        </p>
    </section>

    <section id="contact">
        <h2>10. Contact Us</h2>
        <p>If you have questions about our use of cookies, contact us at <a href="mailto:{{ $email }}">{{ $email }}</a> or review our <a href="{{ route('legal.privacy') }}">Privacy Policy</a>.</p>
    </section>
</x-legal-page>
@endsection
