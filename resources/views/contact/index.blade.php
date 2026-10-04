@extends('layouts.app')

@php($seo = seo_for_route('contact.index'))
@section('title', $seo['title'])
@section('meta_description', $seo['description'])
@section('meta_keywords', $seo['keywords'])

@section('content')
@php
    $mapLink = company_map_link();
    $mapEmbed = company_map_embed_url();
@endphp
<x-page-hero fallback="images/hero-slide-2.jpg" alt="Contact" size="md" align="center">
    <x-public.hero-heading
        eyebrow="Contact"
        title="Talk to our team"
        description="Ready to discuss your data centre requirements? We will help you find the right infrastructure path."
    />
</x-page-hero>

<section class="py-20 lg:py-28" x-data="{ submitted: {{ session('success') ? 'true' : 'false' }}, submitting: false }" data-eq-reveal>
    <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-12 lg:gap-20">
            {{-- Contact Info --}}
            <div class="lg:col-span-2 space-y-8">
                <div>
                    <h2 class="eq-headline-section text-brand-900 text-2xl mb-6">Let&rsquo;s talk</h2>
                    <p class="text-brand-600 leading-relaxed">Whether you're planning a new deployment or exploring colocation options, we'd love to hear from you.</p>
                </div>

                <div class="space-y-6">
                    @if(settings('company.email'))
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-lg bg-brand-teal-100 flex items-center justify-center shrink-0">
                                <i data-lucide="mail" class="w-5 h-5 text-brand-teal-700"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-brand-500 mb-1">Email</p>
                                <a href="mailto:{{ settings('company.email') }}" class="text-brand-900 hover:text-brand-teal-700 transition">{{ settings('company.email') }}</a>
                            </div>
                        </div>
                    @endif
                    @if(settings('company.phone'))
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-lg bg-brand-teal-100 flex items-center justify-center shrink-0">
                                <i data-lucide="phone" class="w-5 h-5 text-brand-teal-700"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-brand-500 mb-1">Phone</p>
                                <p class="text-brand-900">{{ settings('company.phone') }}</p>
                            </div>
                        </div>
                    @endif
                    @if(settings('company.address'))
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-lg bg-brand-teal-100 flex items-center justify-center shrink-0">
                                <i data-lucide="map-pin" class="w-5 h-5 text-brand-teal-700"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-brand-500 mb-1">Address</p>
                                <p class="text-brand-900">
                                    {{ settings('company.address') }}<br>
                                    {{ settings('company.city') }}@if(settings('company.postal_code')), {{ settings('company.postal_code') }}@endif<br>
                                    {{ settings('company.country') }}
                                </p>
                                @if($mapLink)
                                    <a href="{{ $mapLink }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 mt-3 text-sm font-medium text-brand-teal-700 hover:text-brand-teal-600 transition">
                                        <i data-lucide="map" class="w-4 h-4"></i>
                                        Open in Google Maps
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Contact Form --}}
            <div class="lg:col-span-3">
                {{-- Success State --}}
                <div x-show="submitted" x-cloak class="border border-brand-teal-200 bg-brand-teal-50 p-10 text-center">
                    <div class="w-16 h-16 rounded-full bg-brand-teal-100 flex items-center justify-center mx-auto mb-6">
                        <i data-lucide="check-circle" class="w-8 h-8 text-brand-teal-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-brand-900 mb-3">Message sent</h3>
                    <p class="text-brand-600 mb-6">{{ session('success') ?? 'Thank you for your message. We will be in touch shortly.' }}</p>
                    <button @click="submitted = false" type="button" class="text-brand-teal-700 font-medium hover:text-brand-teal-600 transition">Send another message</button>
                </div>

                {{-- Form --}}
                <form x-show="!submitted" method="POST" action="{{ route('contact.store') }}" @submit="submitting = true" class="eq-form-panel space-y-6">
                    @csrf

                    @if($errors->any())
                        <div class="p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-brand-700 mb-1">Full Name *</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required class="w-full rounded-lg border-brand-300 focus:border-brand-teal-500 focus:ring-brand-teal-500">
                            @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="company" class="block text-sm font-medium text-brand-700 mb-1">Company</label>
                            <input type="text" name="company" id="company" value="{{ old('company') }}" class="w-full rounded-lg border-brand-300 focus:border-brand-teal-500 focus:ring-brand-teal-500">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-brand-700 mb-1">Email *</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required class="w-full rounded-lg border-brand-300 focus:border-brand-teal-500 focus:ring-brand-teal-500">
                            @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-brand-700 mb-1">Phone</label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" class="w-full rounded-lg border-brand-300 focus:border-brand-teal-500 focus:ring-brand-teal-500">
                        </div>
                    </div>

                    <div>
                        <label for="project_type" class="block text-sm font-medium text-brand-700 mb-1">Project Type</label>
                        <select name="project_type" id="project_type" class="w-full rounded-lg border-brand-300 focus:border-brand-teal-500 focus:ring-brand-teal-500">
                            <option value="">Select a project type</option>
                            @foreach(['Colocation', 'Cloud Infrastructure', 'Dedicated Servers', 'Edge Computing', 'Sustainability Consultation', 'Other'] as $type)
                                <option value="{{ $type }}" @selected(old('project_type') === $type)>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium text-brand-700 mb-1">Message *</label>
                        <textarea name="message" id="message" rows="5" required class="w-full rounded-lg border-brand-300 focus:border-brand-teal-500 focus:ring-brand-teal-500">{{ old('message') }}</textarea>
                        @error('message')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <button type="submit" :disabled="submitting" class="eq-btn-primary w-full sm:w-auto disabled:opacity-60">
                        <span x-show="!submitting">Send Message</span>
                        <span x-show="submitting" x-cloak>Sending...</span>
                        <i data-lucide="send" class="w-4 h-4" x-show="!submitting"></i>
                        <i data-lucide="loader-2" class="w-4 h-4 animate-spin" x-show="submitting" x-cloak></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

@if($mapEmbed)
<section class="pb-24 bg-brand-50 border-t border-brand-200" data-eq-reveal>
    <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-6">
            <div>
                <p class="text-brand-teal-600 text-xs font-bold tracking-widest uppercase mb-2">Location</p>
                <h2 class="eq-headline-section text-brand-900 text-2xl">Visit our office</h2>
                <p class="text-brand-600 mt-2">Find us on the map or get directions to our headquarters.</p>
            </div>
            @if($mapLink)
                <a href="{{ $mapLink }}" target="_blank" rel="noopener noreferrer" class="eq-btn-outline shrink-0">
                    <i data-lucide="navigation" class="w-4 h-4"></i>
                    Get Directions
                </a>
            @endif
        </div>

        <div class="overflow-hidden border border-brand-200 bg-white">
            <iframe
                src="{{ $mapEmbed }}"
                title="D³ DataCenters office location map"
                class="w-full h-[320px] sm:h-[400px] lg:h-[480px] border-0"
                allowfullscreen
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
            ></iframe>
        </div>
    </div>
</section>
@endif
@endsection
