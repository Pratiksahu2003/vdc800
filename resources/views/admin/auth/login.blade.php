<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#ffffff">
    <title>Admin Login — VDC800 CMS</title>
    @include('components.favicon')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased min-h-screen flex items-center justify-center p-4 bg-brand-50" x-data="{ showPassword: false }">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="inline-block bg-white rounded-2xl px-6 py-4 shadow-sm border border-brand-200 mb-6">
                <x-logo :link="false" class="h-14 w-auto mx-auto" />
            </div>
            <h1 class="text-2xl font-semibold text-brand-900">Admin Dashboard</h1>
            <p class="text-brand-teal-600 text-sm mt-1">{{ settings('company.tagline') ?? 'IS FUTURE OF DCs' }}</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-8 border border-brand-200">
            @if($errors->any())
                <div class="mb-6 p-4 bg-brand-red-50 border border-brand-red-200 rounded-xl text-brand-red-700 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-brand-700 mb-1">Email address</label>
                    <div class="relative">
                        <i data-lucide="mail" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-brand-400"></i>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                            class="w-full pl-10 rounded-lg border-brand-300 shadow-sm focus:border-brand-teal-500 focus:ring-brand-teal-500 text-sm bg-white">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-brand-700 mb-1">Password</label>
                    <div class="relative">
                        <i data-lucide="lock" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-brand-400"></i>
                        <input :type="showPassword ? 'text' : 'password'" name="password" id="password" required
                            class="w-full pl-10 pr-10 rounded-lg border-brand-300 shadow-sm focus:border-brand-teal-500 focus:ring-brand-teal-500 text-sm bg-white">
                        <button type="button" @click="showPassword = !showPassword" class="absolute right-3 top-1/2 -translate-y-1/2 text-brand-400 hover:text-brand-600">
                            <i data-lucide="eye" class="w-4 h-4" x-show="!showPassword"></i>
                            <i data-lucide="eye-off" class="w-4 h-4" x-show="showPassword" x-cloak></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" value="1" class="rounded border-brand-300 text-brand-teal-500 focus:ring-brand-teal-500">
                    <label for="remember" class="ml-2 text-sm text-brand-600">Remember me</label>
                </div>

                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-brand-red-500 hover:bg-brand-red-600 text-white text-sm font-medium rounded-lg transition shadow-sm">
                    <i data-lucide="log-in" class="w-4 h-4"></i>
                    Sign in
                </button>
            </form>
        </div>

        <p class="text-center text-brand-500 text-xs mt-6">&copy; {{ date('Y') }} VDC800. All rights reserved.</p>
    </div>
</body>
</html>
