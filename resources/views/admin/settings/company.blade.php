@extends('layouts.admin')

@section('title', 'Company Settings')

@section('content')
<div class="max-w-4xl space-y-6">
    <div>
        <h1 class="text-2xl font-semibold text-brand-900">Company Settings</h1>
        <p class="text-sm text-brand-500 mt-1">Manage your company information and contact details.</p>
    </div>

    <form method="POST" action="{{ route('admin.settings.company') }}" class="bg-white rounded-xl border border-brand-200 p-6 space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @include('admin.components.input', ['name' => 'company_name', 'label' => 'Company Name', 'value' => $company->company_name])
            @include('admin.components.input', ['name' => 'short_name', 'label' => 'Short Name', 'value' => $company->short_name])
            @include('admin.components.input', ['name' => 'tagline', 'label' => 'Tagline', 'value' => $company->tagline])
            @include('admin.components.input', ['name' => 'founded_year', 'label' => 'Founded Year', 'value' => $company->founded_year])
        </div>

        @include('admin.components.textarea', ['name' => 'description', 'label' => 'Description', 'value' => $company->description, 'rows' => 3])
        @include('admin.components.textarea', ['name' => 'about_company', 'label' => 'About Company', 'value' => $company->about_company, 'rows' => 4])

        <hr class="border-brand-200">

        <h3 class="font-medium text-brand-900">Contact Information</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @include('admin.components.input', ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'value' => $company->email])
            @include('admin.components.input', ['name' => 'phone', 'label' => 'Phone', 'value' => $company->phone])
            @include('admin.components.input', ['name' => 'secondary_phone', 'label' => 'Secondary Phone', 'value' => $company->secondary_phone])
        </div>

        @include('admin.components.textarea', ['name' => 'address', 'label' => 'Address', 'value' => $company->address, 'rows' => 2])

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @include('admin.components.input', ['name' => 'city', 'label' => 'City', 'value' => $company->city])
            @include('admin.components.input', ['name' => 'state', 'label' => 'State / Region', 'value' => $company->state])
            @include('admin.components.input', ['name' => 'country', 'label' => 'Country', 'value' => $company->country])
            @include('admin.components.input', ['name' => 'postal_code', 'label' => 'Postal Code', 'value' => $company->postal_code])
        </div>

        <h3 class="font-medium text-brand-900">Map</h3>
        <p class="text-sm text-brand-500 -mt-2">Shown on the contact page. Paste any Google Maps share link — the map embed is generated automatically.</p>
        @include('admin.components.input', [
            'name' => 'map_link',
            'label' => 'Google Maps Link',
            'value' => $company->map_link,
            'placeholder' => 'https://maps.app.goo.gl/... or https://www.google.com/maps/place/...',
        ])
        <p class="text-xs text-brand-500">Supported: Google Maps share links, place URLs, and shortened <code class="text-brand-700">maps.app.goo.gl</code> links. No iframe code needed.</p>

        <hr class="border-brand-200">

        <h3 class="font-medium text-brand-900">Legal Information</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @include('admin.components.input', ['name' => 'vat_number', 'label' => 'VAT Number', 'value' => $company->vat_number])
            @include('admin.components.input', ['name' => 'business_registration_number', 'label' => 'Business Registration Number', 'value' => $company->business_registration_number])
        </div>

        <div class="flex justify-end pt-4">
            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-teal-600 hover:bg-brand-teal-700 text-white text-sm font-medium rounded-lg transition">
                <i data-lucide="save" class="w-4 h-4"></i> Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
