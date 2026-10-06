@extends('layouts.admin')

@section('title', 'Website SEO')

@section('content')
<div class="max-w-4xl space-y-6">
    <div>
        <h1 class="text-2xl font-semibold text-brand-900">Website & SEO Settings</h1>
        <p class="text-sm text-brand-500 mt-1">Configure global SEO, analytics, and website metadata.</p>
    </div>

    <form method="POST" action="{{ route('admin.settings.website') }}" enctype="multipart/form-data" class="bg-white rounded-xl border border-brand-200 p-6 space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @include('admin.components.input', ['name' => 'website_name', 'label' => 'Website Name', 'value' => $website->website_name])
            @include('admin.components.input', ['name' => 'website_url', 'label' => 'Website URL', 'type' => 'url', 'value' => $website->website_url])
            @include('admin.components.input', ['name' => 'default_page_title', 'label' => 'Default Page Title', 'value' => $website->default_page_title])
            @include('admin.components.input', ['name' => 'default_language', 'label' => 'Default Language', 'value' => $website->default_language ?? 'en'])
            @include('admin.components.input', ['name' => 'timezone', 'label' => 'Timezone', 'value' => $website->timezone ?? 'Europe/Oslo'])
        </div>

        @include('admin.components.textarea', ['name' => 'default_meta_description', 'label' => 'Default Meta Description', 'value' => $website->default_meta_description, 'rows' => 3])
        @include('admin.components.textarea', ['name' => 'default_keywords', 'label' => 'Default Keywords', 'value' => $website->default_keywords, 'rows' => 2])

        <hr class="border-brand-200">

        <h3 class="font-medium text-brand-900">Analytics</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @include('admin.components.input', ['name' => 'google_analytics_id', 'label' => 'Google Analytics ID', 'value' => $website->google_analytics_id])
            @include('admin.components.input', ['name' => 'google_tag_manager_id', 'label' => 'Google Tag Manager ID', 'value' => $website->google_tag_manager_id])
        </div>

        @include('admin.components.image-upload', ['name' => 'og_image', 'label' => 'Default OG Image', 'existing' => $website->og_image])

        <div class="flex justify-end pt-4 border-t border-brand-200">
            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-teal-600 hover:bg-brand-teal-700 text-white text-sm font-medium rounded-lg transition">
                <i data-lucide="save" class="w-4 h-4"></i> Save Settings
            </button>
        </div>
    </form>
</div>
@endsection
