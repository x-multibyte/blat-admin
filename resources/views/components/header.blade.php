@props(['user' => null])

@php
    $guard = config('blat-admin.guard', 'blat-admin');
    $currentUser = $user ?? auth()->guard($guard)->user();
@endphp

<header class="h-16 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between px-6">
    <div class="flex items-center gap-4">
        <!-- Optional Breadcrumb/Heading hook -->
    </div>

    <div class="flex items-center gap-4">
        @if ($currentUser)
            <div class="flex items-center gap-3">
                <div class="text-right">
                    <div class="text-sm font-medium text-slate-900 dark:text-slate-100">{{ $currentUser->name ?? 'Admin' }}</div>
                    <div class="text-xs text-slate-500 dark:text-slate-400 capitalize">{{ $currentUser->role ?? 'admin' }}</div>
                </div>

                <div class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-semibold text-xs">
                    {{ strtoupper(substr($currentUser->name ?? 'A', 0, 1)) }}
                </div>
            </div>

            <!-- Logout button -->
            <form method="POST" action="{{ route('blat-admin.logout') }}">
                @csrf
                <button type="submit" class="p-2 text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 text-sm font-medium rounded-md hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" title="Logout">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                </button>
            </form>
        @endif
    </div>
</header>
