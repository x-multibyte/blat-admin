@props(['items' => []])

@if (!empty($items))
    <nav class="flex text-sm font-medium text-slate-500 dark:text-slate-400" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('blat-admin.dashboard') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                    Dashboard
                </a>
            </li>

            @foreach ($items as $item)
                <li>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-slate-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        @if (isset($item['url']) && !$loop->last)
                            <a href="{{ $item['url'] }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                {{ $item['title'] }}
                            </a>
                        @else
                            <span class="text-slate-700 dark:text-slate-200">
                                {{ $item['title'] }}
                            </span>
                        @endif
                    </div>
                </li>
            @endforeach
        </ol>
    </nav>
@endif
