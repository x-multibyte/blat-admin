@props(['items' => [], 'title' => 'Blat Admin'])

<aside class="w-full md:w-64 bg-slate-900 text-slate-200 flex-shrink-0 flex flex-col border-r border-slate-800">
    <!-- Brand -->
    <div class="h-16 flex items-center px-6 border-b border-slate-800">
        <a href="{{ route('blat-admin.dashboard') }}" class="flex items-center gap-2 font-bold text-lg text-white hover:text-indigo-400 transition-colors">
            <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
            </svg>
            <span>{{ $title }}</span>
        </a>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
        @foreach ($items as $item)
            @php
                $url = isset($item['route']) ? route($item['route'], $item['params'] ?? []) : ($item['url'] ?? '#');
                $isActive = request()->url() === $url;
            @endphp
            <a href="{{ $url }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ $isActive ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                @if (isset($item['icon']))
                    <span class="w-5 h-5 flex items-center justify-center">
                        <!-- Generic Icon fallback -->
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </span>
                @endif
                <span>{{ $item['title'] ?? ($item['label'] ?? '') }}</span>
            </a>
        @endforeach
    </nav>

    <!-- Footer / Version -->
    <div class="p-4 border-t border-slate-800 text-xs text-slate-500">
        Blat Admin v1.0
    </div>
</aside>
