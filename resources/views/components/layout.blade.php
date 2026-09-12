@props(['title' => null, 'breadcrumbs' => []])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('blat-admin.title', 'Blat Admin') }}</title>

    @if(config('blat-admin.assets.mode', 'prebuilt') === 'prebuilt')
        <link rel="stylesheet" href="{{ asset('vendor/blat-admin/blat-admin.css') }}">
        <script defer src="{{ asset('vendor/blat-admin/blat-admin.js') }}"></script>
    @else
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="h-full antialiased text-slate-900 bg-slate-50 dark:bg-slate-950 dark:text-slate-100">
    <div class="min-h-full flex flex-col md:flex-row">
        <!-- Sidebar -->
        <x-blat-admin::sidebar />

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Header -->
            <x-blat-admin::header />

            <!-- Page Body -->
            <main class="flex-1 p-4 md:p-6 lg:p-8 max-w-7xl w-full mx-auto">
                @if (session('success'))
                    <div class="mb-4 p-4 rounded-lg bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/50 dark:text-emerald-300 dark:border-emerald-800" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 p-4 rounded-lg bg-rose-50 text-rose-800 border border-rose-200 dark:bg-rose-950/50 dark:text-rose-300 dark:border-rose-800" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                @if (!empty($breadcrumbs))
                    <div class="mb-4">
                        <x-blat-admin::breadcrumb :items="$breadcrumbs" />
                    </div>
                @endif

                <div class="space-y-6">
                    @if ($title)
                        <div class="flex items-center justify-between">
                            <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-slate-100">
                                {{ $title }}
                            </h1>
                        </div>
                    @endif

                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</body>
</html>
