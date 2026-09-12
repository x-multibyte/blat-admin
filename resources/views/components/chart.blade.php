@props(['schema' => []])

@php
    $chartId = 'chart_' . uniqid();
    $title = $schema['title'] ?? null;
    $description = $schema['description'] ?? null;
    $type = $schema['chart_type'] ?? ($schema['type'] ?? 'line');
    $series = $schema['series'] ?? [];
    $categories = $schema['categories'] ?? [];
    $height = $schema['height'] ?? 350;
@endphp

<div class="bg-white dark:bg-slate-900 shadow-sm rounded-xl border border-slate-200 dark:border-slate-800 p-6">
    @if ($title || $description)
        <div class="mb-4">
            @if ($title)
                <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100">{{ $title }}</h3>
            @endif
            @if ($description)
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">{{ $description }}</p>
            @endif
        </div>
    @endif

    <div id="{{ $chartId }}" class="w-full" style="min-height: {{ is_numeric($height) ? $height . 'px' : $height }};"
         data-chart-type="{{ $type }}"
         data-chart-series='@json($series)'
         data-chart-categories='@json($categories)'>
        <!-- Chart Container -->
        <div class="h-64 flex items-center justify-center bg-slate-50 dark:bg-slate-800/50 rounded-lg text-slate-400 text-sm">
            <div class="text-center">
                <svg class="w-8 h-8 mx-auto mb-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                </svg>
                <span>{{ ucfirst($type) }} Chart: {{ $title ?? 'Data visualization' }}</span>
            </div>
        </div>
    </div>
</div>
