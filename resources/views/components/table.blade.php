@props(['schema' => []])

@php
    $columns = $schema['columns'] ?? [];
    $actions = $schema['actions'] ?? [];
    $data = $schema['data'] ?? [];
    $records = is_array($data) && isset($data['data']) ? $data['data'] : (is_array($data) ? $data : []);
@endphp

<div class="bg-white dark:bg-slate-900 shadow-sm rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden">
    @if (!empty($schema['title']) || !empty($schema['searchable']))
        <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                @if (!empty($schema['title']))
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100">{{ $schema['title'] }}</h3>
                @endif
                @if (!empty($schema['description']))
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">{{ $schema['description'] }}</p>
                @endif
            </div>

            @if (!empty($schema['searchable']))
                <form method="GET" class="w-full md:w-64">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search records..."
                           class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 text-sm py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                </form>
            @endif
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300 divide-y divide-slate-200 dark:divide-slate-800">
            <thead class="bg-slate-50 dark:bg-slate-800/50 text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                <tr>
                    @foreach ($columns as $column)
                        @php
                            $align = $column['align'] ?? 'left';
                            $alignClass = $align === 'right' ? 'text-right' : ($align === 'center' ? 'text-center' : 'text-left');
                        @endphp
                        <th scope="col" class="px-6 py-3 {{ $alignClass }}">
                            {{ $column['label'] ?? ($column['key'] ?? '') }}
                        </th>
                    @endforeach

                    @if (!empty($actions))
                        <th scope="col" class="px-6 py-3 text-right">
                            Actions
                        </th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 dark:divide-slate-800 bg-white dark:bg-slate-900">
                @forelse ($records as $row)
                    @php
                        $rowArray = (array) $row;
                    @endphp
                    <tr class="hover:bg-slate-50/75 dark:hover:bg-slate-800/50 transition-colors">
                        @foreach ($columns as $column)
                            @php
                                $key = $column['key'] ?? '';
                                $val = $rowArray[$key] ?? null;
                                $align = $column['align'] ?? 'left';
                                $alignClass = $align === 'right' ? 'text-right' : ($align === 'center' ? 'text-center' : 'text-left');
                                $isBadge = !empty($column['badge']);
                            @endphp
                            <td class="px-6 py-4 whitespace-nowrap {{ $alignClass }}">
                                @if ($isBadge)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800">
                                        {{ (string) $val }}
                                    </span>
                                @else
                                    {{ (string) $val }}
                                @endif
                            </td>
                        @endforeach

                        @if (!empty($actions))
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                @foreach ($actions as $act)
                                    @php
                                        $label = $act['label'] ?? ($act['name'] ?? 'View');
                                        $url = $act['url'] ?? '#';
                                        if (isset($act['route'])) {
                                            $params = $act['params'] ?? [];
                                            $resolvedParams = [];
                                            foreach ($params as $pk => $pv) {
                                                if (is_string($pv) && str_contains($pv, '{') && str_contains($pv, '}')) {
                                                    $field = trim($pv, '{}');
                                                    $resolvedParams[$pk] = $rowArray[$field] ?? $pv;
                                                } else {
                                                    $resolvedParams[$pk] = $pv;
                                                }
                                            }
                                            $url = route($act['route'], $resolvedParams);
                                        } elseif (is_string($url)) {
                                            foreach ($rowArray as $rk => $rv) {
                                                if (is_scalar($rv)) {
                                                    $url = str_replace('{'.$rk.'}', (string) $rv, $url);
                                                }
                                            }
                                        }
                                    @endphp
                                    <a href="{{ $url }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                        {{ $label }}
                                    </a>
                                @endforeach
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($columns) + (!empty($actions) ? 1 : 0) }}" class="px-6 py-8 text-center text-slate-500 dark:text-slate-400">
                            No records found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
