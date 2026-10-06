@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-2xl font-semibold text-brand-900">Dashboard</h1>
        <p class="text-sm text-brand-500 mt-1">Welcome back, {{ auth()->user()->name }}. Here's an overview of your CMS.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        @foreach([
            ['label' => 'Services', 'value' => $stats['services'], 'icon' => 'server', 'color' => 'bg-brand-teal-500'],
            ['label' => 'Solutions', 'value' => $stats['solutions'], 'icon' => 'layers', 'color' => 'bg-blue-500'],
            ['label' => 'Projects', 'value' => $stats['data_centres'], 'icon' => 'database', 'color' => 'bg-violet-500'],
            ['label' => 'Contact Enquiries', 'value' => $stats['contact_enquiries'], 'icon' => 'mail', 'color' => 'bg-amber-500'],
        ] as $stat)
            <div class="bg-white rounded-xl border border-brand-200 p-5 flex items-start gap-4">
                <div class="w-11 h-11 rounded-lg {{ $stat['color'] }} flex items-center justify-center text-white shrink-0">
                    <i data-lucide="{{ $stat['icon'] }}" class="w-5 h-5"></i>
                </div>
                <div>
                    <p class="text-sm text-brand-500">{{ $stat['label'] }}</p>
                    <p class="text-2xl font-semibold text-brand-900 mt-0.5">{{ $stat['value'] }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-xl border border-brand-200">
            <div class="flex items-center justify-between px-6 py-4 border-b border-brand-200">
                <h2 class="font-semibold text-brand-900">Recent Contact Submissions</h2>
                <a href="{{ route('admin.contact-submissions.index') }}" class="text-sm text-brand-teal-600 hover:text-brand-teal-700 font-medium">View all</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($recentContacts as $contact)
                    <a href="{{ route('admin.contact-submissions.show', $contact) }}" class="flex items-center justify-between px-6 py-4 hover:bg-brand-50 transition">
                        <div>
                            <p class="font-medium text-brand-900">{{ $contact->name }}</p>
                            <p class="text-sm text-brand-500">{{ $contact->email }} · {{ $contact->created_at->diffForHumans() }}</p>
                        </div>
                        @include('admin.components.status-badge', ['status' => $contact->status ?? 'new'])
                    </a>
                @empty
                    <p class="px-6 py-8 text-sm text-brand-500 text-center">No contact submissions yet.</p>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-xl border border-brand-200 p-6">
            <h2 class="font-semibold text-brand-900 mb-4">Quick Actions</h2>
            <div class="space-y-2">
                <a href="{{ route('admin.content.homepage') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm hover:bg-brand-50 transition">
                    <i data-lucide="home" class="w-4 h-4 text-brand-teal-600"></i> Edit Homepage
                </a>
                <a href="{{ route('admin.services.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm hover:bg-brand-50 transition">
                    <i data-lucide="plus" class="w-4 h-4 text-brand-teal-600"></i> Add Service
                </a>
                <a href="{{ route('admin.solutions.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm hover:bg-brand-50 transition">
                    <i data-lucide="plus" class="w-4 h-4 text-brand-teal-600"></i> Add Solution
                </a>
                <a href="{{ route('admin.settings.company') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm hover:bg-brand-50 transition">
                    <i data-lucide="building-2" class="w-4 h-4 text-brand-teal-600"></i> Company Settings
                </a>
                <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm hover:bg-brand-50 transition">
                    <i data-lucide="external-link" class="w-4 h-4 text-brand-teal-600"></i> View Website
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
