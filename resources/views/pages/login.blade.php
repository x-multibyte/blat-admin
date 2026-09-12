<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - {{ config('blat-admin.title', 'Blat Admin') }}</title>

    @if(config('blat-admin.assets.mode', 'prebuilt') === 'prebuilt')
        <link rel="stylesheet" href="{{ asset('vendor/blat-admin/blat-admin.css') }}">
        <script defer src="{{ asset('vendor/blat-admin/blat-admin.js') }}"></script>
    @else
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="h-full antialiased text-slate-900 bg-slate-50 dark:bg-slate-950 dark:text-slate-100 flex items-center justify-center p-4">
    <x-blat-admin::login-form />
</body>
</html>
