@extends('layouts.admin')

@section('title', 'Submission Details')

@section('content')
<div class="max-w-3xl space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.contact-submissions.index') }}" class="p-2 text-brand-500 hover:bg-brand-100 rounded-lg transition">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div class="flex-1">
            <h1 class="text-2xl font-semibold text-brand-900">{{ $submission->name }}</h1>
            <p class="text-sm text-brand-500 mt-1">Received {{ $submission->created_at->format('F j, Y \a\t g:i A') }}</p>
        </div>
        @include('admin.components.status-badge', ['status' => $submission->status ?? 'new'])
    </div>

    <div class="bg-white rounded-xl border border-brand-200 p-6 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-xs font-medium text-brand-500 uppercase tracking-wider mb-1">Email</p>
                <a href="mailto:{{ $submission->email }}" class="text-brand-teal-600 hover:text-brand-teal-700">{{ $submission->email }}</a>
            </div>
            @if($submission->phone)
                <div>
                    <p class="text-xs font-medium text-brand-500 uppercase tracking-wider mb-1">Phone</p>
                    <p class="text-brand-900">{{ $submission->phone }}</p>
                </div>
            @endif
            @if($submission->company)
                <div>
                    <p class="text-xs font-medium text-brand-500 uppercase tracking-wider mb-1">Company</p>
                    <p class="text-brand-900">{{ $submission->company }}</p>
                </div>
            @endif
            @if($submission->project_type)
                <div>
                    <p class="text-xs font-medium text-brand-500 uppercase tracking-wider mb-1">Project Type</p>
                    <p class="text-brand-900">{{ $submission->project_type }}</p>
                </div>
            @endif
        </div>

        <div>
            <p class="text-xs font-medium text-brand-500 uppercase tracking-wider mb-2">Message</p>
            <div class="bg-brand-50 rounded-lg p-4 text-brand-700 whitespace-pre-wrap">{{ $submission->message }}</div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-brand-200 p-6">
        <h3 class="font-medium text-brand-900 mb-4">Update Status</h3>
        <form method="POST" action="{{ route('admin.contact-submissions.status', $submission) }}" class="flex flex-col sm:flex-row gap-3">
            @csrf
            @method('PATCH')
            <select name="status" class="flex-1 rounded-lg border-brand-300 text-sm focus:border-brand-teal-500 focus:ring-brand-teal-500">
                <option value="new" @selected(($submission->status ?? 'new') === 'new')>New</option>
                <option value="contacted" @selected($submission->status === 'contacted')>Contacted</option>
                <option value="closed" @selected($submission->status === 'closed')>Closed</option>
            </select>
            <button type="submit" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-brand-teal-600 hover:bg-brand-teal-700 text-white text-sm font-medium rounded-lg transition">
                <i data-lucide="check" class="w-4 h-4"></i> Update Status
            </button>
        </form>
    </div>

    <div class="flex justify-end">
        <form x-ref="deleteForm" method="POST" action="{{ route('admin.contact-submissions.destroy', $submission) }}" class="hidden">
            @csrf
            @method('DELETE')
        </form>
        <button @click="$dispatch('open-delete-modal', { form: $refs.deleteForm })" type="button" class="inline-flex items-center gap-2 px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition">
            <i data-lucide="trash-2" class="w-4 h-4"></i> Delete Submission
        </button>
    </div>

    @include('admin.components.delete-modal')
</div>
@endsection
