@extends('layouts.admin')

@section('title', 'Branding')

@section('content')
<div class="max-w-4xl space-y-6">
    <div>
        <h1 class="text-2xl font-semibold text-brand-900">Branding</h1>
        <p class="text-sm text-brand-500 mt-1">Upload logos and favicon for your website.</p>
    </div>

    <form method="POST" action="{{ route('admin.settings.branding') }}" enctype="multipart/form-data" class="bg-white rounded-xl border border-brand-200 p-6 space-y-8">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @include('admin.components.image-upload', ['name' => 'logo', 'label' => 'Primary Logo', 'existing' => $company->logo])
            @include('admin.components.image-upload', ['name' => 'logo_dark', 'label' => 'Dark Logo', 'existing' => $company->logo_dark])
            @include('admin.components.image-upload', ['name' => 'logo_light', 'label' => 'Light Logo', 'existing' => $company->logo_light])
            @include('admin.components.image-upload', ['name' => 'favicon', 'label' => 'Favicon', 'existing' => $company->favicon])
            @include('admin.components.image-upload', ['name' => 'footer_logo', 'label' => 'Footer Logo', 'existing' => $company->footer_logo])
        </div>

        <div class="flex justify-end pt-4 border-t border-brand-200">
            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-teal-600 hover:bg-brand-teal-700 text-white text-sm font-medium rounded-lg transition">
                <i data-lucide="save" class="w-4 h-4"></i> Save Branding
            </button>
        </div>
    </form>
</div>
@endsection
