@extends('layouts.admin')

@section('title', 'Profile')

@section('content')
<div class="max-w-2xl space-y-6">
    <div>
        <h1 class="text-2xl font-semibold text-brand-900">Profile Settings</h1>
        <p class="text-sm text-brand-500 mt-1">Update your account information and password.</p>
    </div>

    <form method="POST" action="{{ route('admin.profile') }}" class="bg-white rounded-xl border border-brand-200 p-6 space-y-6">
        @csrf
        @method('PUT')

        <div class="flex items-center gap-4 pb-6 border-b border-brand-200">
            <div class="w-16 h-16 bg-brand-teal-600 rounded-full flex items-center justify-center text-white text-xl font-semibold">
                {{ strtoupper(substr($user->name, 0, 2)) }}
            </div>
            <div>
                <p class="font-medium text-brand-900">{{ $user->name }}</p>
                <p class="text-sm text-brand-500">{{ $user->email }}</p>
            </div>
        </div>

        @include('admin.components.input', ['name' => 'name', 'label' => 'Full Name', 'value' => $user->name, 'required' => true])
        @include('admin.components.input', ['name' => 'email', 'label' => 'Email Address', 'type' => 'email', 'value' => $user->email, 'required' => true])

        <hr class="border-brand-200">

        <h3 class="font-medium text-brand-900">Change Password</h3>
        <p class="text-sm text-brand-500">Leave blank to keep your current password.</p>

        @include('admin.components.input', ['name' => 'current_password', 'label' => 'Current Password', 'type' => 'password', 'value' => ''])
        @include('admin.components.input', ['name' => 'password', 'label' => 'New Password', 'type' => 'password', 'value' => ''])
        @include('admin.components.input', ['name' => 'password_confirmation', 'label' => 'Confirm New Password', 'type' => 'password', 'value' => ''])

        <div class="flex justify-end pt-4 border-t border-brand-200">
            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-teal-600 hover:bg-brand-teal-700 text-white text-sm font-medium rounded-lg transition">
                <i data-lucide="save" class="w-4 h-4"></i> Update Profile
            </button>
        </div>
    </form>
</div>
@endsection
