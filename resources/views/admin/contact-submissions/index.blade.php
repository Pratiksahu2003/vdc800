@extends('layouts.admin')

@section('title', 'Contact Submissions')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-semibold text-brand-900">Contact Submissions</h1>
        <p class="text-sm text-brand-500 mt-1">View and manage contact form enquiries.</p>
    </div>

    <form method="GET" action="{{ route('admin.contact-submissions.index') }}" class="bg-white rounded-xl border border-brand-200 p-4 flex flex-col sm:flex-row gap-3">
        <div class="flex-1">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, email, or company..." class="w-full rounded-lg border-brand-300 text-sm focus:border-brand-teal-500 focus:ring-brand-teal-500">
        </div>
        <select name="status" class="rounded-lg border-brand-300 text-sm focus:border-brand-teal-500 focus:ring-brand-teal-500">
            <option value="">All statuses</option>
            <option value="new" @selected(request('status') === 'new')>New</option>
            <option value="contacted" @selected(request('status') === 'contacted')>Contacted</option>
            <option value="closed" @selected(request('status') === 'closed')>Closed</option>
        </select>
        <input type="date" name="date" value="{{ request('date') }}" class="rounded-lg border-brand-300 text-sm focus:border-brand-teal-500 focus:ring-brand-teal-500">
        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-brand-teal-600 hover:bg-brand-teal-700 text-white text-sm rounded-lg transition">
            <i data-lucide="search" class="w-4 h-4"></i> Filter
        </button>
    </form>

    <div class="bg-white rounded-xl border border-brand-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-brand-50 border-b border-brand-200">
                <tr>
                    <th class="text-left px-6 py-3 font-medium text-brand-600">Contact</th>
                    <th class="text-left px-6 py-3 font-medium text-brand-600">Company</th>
                    <th class="text-left px-6 py-3 font-medium text-brand-600">Status</th>
                    <th class="text-left px-6 py-3 font-medium text-brand-600">Date</th>
                    <th class="text-right px-6 py-3 font-medium text-brand-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($submissions as $submission)
                    <tr class="hover:bg-brand-50">
                        <td class="px-6 py-4">
                            <p class="font-medium text-brand-900">{{ $submission->name }}</p>
                            <p class="text-brand-500 text-xs">{{ $submission->email }}</p>
                        </td>
                        <td class="px-6 py-4 text-brand-600">{{ $submission->company ?? '—' }}</td>
                        <td class="px-6 py-4">@include('admin.components.status-badge', ['status' => $submission->status ?? 'new'])</td>
                        <td class="px-6 py-4 text-brand-600">{{ $submission->created_at->format('M j, Y') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.contact-submissions.show', $submission) }}" class="p-2 text-brand-500 hover:text-brand-teal-600 hover:bg-brand-teal-50 rounded-lg transition">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                                <form x-ref="deleteForm{{ $submission->id }}" method="POST" action="{{ route('admin.contact-submissions.destroy', $submission) }}" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button @click="$dispatch('open-delete-modal', { form: $refs.deleteForm{{ $submission->id }} })" type="button" class="p-2 text-brand-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-brand-500">No submissions found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($submissions->hasPages())
        <div class="mt-4">{{ $submissions->links() }}</div>
    @endif

    @include('admin.components.delete-modal')
</div>
@endsection
