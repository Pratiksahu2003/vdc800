<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#8cc63f">
    <title>@yield('title', 'Admin') — {{ settings('company.company_name') ?? 'VDC800' }} CMS</title>
    @include('components.favicon')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-white text-brand-800 antialiased" x-data="{ sidebarOpen: false }" @keydown.escape.window="sidebarOpen = false">
    @include('admin.components.sidebar')
    @include('admin.components.header')

    <div class="lg:pl-72 min-h-screen bg-white">
        <main class="p-4 sm:p-6 lg:p-8 bg-white">
            @if(session('success'))
                <div data-flash="success" class="hidden">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div data-flash="error" class="hidden">{{ session('error') }}</div>
            @endif
            @if(isset($errors) && $errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @include('admin.components.toast')
    @stack('scripts')
</body>
</html>
