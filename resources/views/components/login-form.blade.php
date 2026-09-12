@props(['action' => null])

@php
    $errors = $errors ?? new \Illuminate\Support\ViewErrorBag;
    $formAction = $action ?? route('blat-admin.login.store');
@endphp

<div class="w-full max-w-md bg-white dark:bg-slate-900 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-800 p-8 space-y-6">
    <div class="text-center space-y-2">
        <div class="w-12 h-12 bg-indigo-600 text-white rounded-xl mx-auto flex items-center justify-center shadow-lg shadow-indigo-500/30">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
        </div>
        <h2 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-slate-100">Admin Sign In</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400">Enter your credentials to access the management portal</p>
    </div>

    @if ($errors->any())
        <div class="p-4 rounded-lg bg-rose-50 text-rose-800 border border-rose-200 dark:bg-rose-950/50 dark:text-rose-300 dark:border-rose-800 text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ $formAction }}" class="space-y-4">
        @csrf

        <div class="space-y-1">
            <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Email Address</label>
            <input type="email" name="email" id="email" required autofocus value="{{ old('email') }}"
                   class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                   placeholder="admin@example.com">
        </div>

        <div class="space-y-1">
            <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Password</label>
            <input type="password" name="password" id="password" required
                   class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                   placeholder="••••••••">
        </div>

        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2">
                <input type="checkbox" name="remember" class="rounded border-slate-300 dark:border-slate-700 text-indigo-600 focus:ring-indigo-500 h-4 w-4">
                <span class="text-sm text-slate-600 dark:text-slate-400">Remember me</span>
            </label>
        </div>

        <button type="submit" class="w-full py-2.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm rounded-lg shadow-sm shadow-indigo-500/30 transition-colors focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            Sign In
        </button>
    </form>
</div>
