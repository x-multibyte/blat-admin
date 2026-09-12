@props(['schema' => []])

@php
    $errors = $errors ?? new \Illuminate\Support\ViewErrorBag;
    $action = $schema['action'] ?? '';
    $method = strtoupper($schema['method'] ?? 'POST');
    $fields = $schema['fields'] ?? [];
    $actions = $schema['actions'] ?? [];
    $data = $schema['data'] ?? [];
@endphp

<div class="bg-white dark:bg-slate-900 shadow-sm rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden">
    @if (!empty($schema['title']) || !empty($schema['description']))
        <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-800">
            @if (!empty($schema['title']))
                <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100">{{ $schema['title'] }}</h3>
            @endif
            @if (!empty($schema['description']))
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">{{ $schema['description'] }}</p>
            @endif
        </div>
    @endif

    <form action="{{ $action }}" method="{{ in_array($method, ['GET', 'POST']) ? $method : 'POST' }}" class="p-6 space-y-6">
        @if ($method !== 'GET')
            @csrf
            @if (!in_array($method, ['GET', 'POST']))
                @method($method)
            @endif
        @endif

        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
            @foreach ($fields as $field)
                @php
                    $name = $field['name'] ?? '';
                    $label = $field['label'] ?? ucfirst($name);
                    $type = $field['type'] ?? 'text';
                    $span = $field['span'] ?? 12;
                    $value = old($name, $data[$name] ?? ($field['default'] ?? ''));
                    $required = !empty($field['required']);
                    $disabled = !empty($field['disabled']);
                    $readonly = !empty($field['readonly']);
                    $placeholder = $field['placeholder'] ?? '';
                    $options = $field['options'] ?? [];
                    $help = $field['help'] ?? null;
                @endphp

                <div class="col-span-1 md:col-span-{{ $span }} space-y-2">
                    <label for="field_{{ $name }}" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                        {{ $label }}
                        @if ($required)
                            <span class="text-rose-500">*</span>
                        @endif
                    </label>

                    @if ($type === 'select')
                        <select name="{{ $name }}" id="field_{{ $name }}"
                                class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2 px-3"
                                {{ $required ? 'required' : '' }} {{ $disabled ? 'disabled' : '' }}>
                            @if ($placeholder)
                                <option value="">{{ $placeholder }}</option>
                            @endif
                            @foreach ($options as $optKey => $optVal)
                                <option value="{{ $optKey }}" {{ (string)$value === (string)$optKey ? 'selected' : '' }}>
                                    {{ $optVal }}
                                </option>
                            @endforeach
                        </select>
                    @elseif ($type === 'textarea')
                        <textarea name="{{ $name }}" id="field_{{ $name }}" rows="4"
                                  placeholder="{{ $placeholder }}"
                                  class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2 px-3"
                                  {{ $required ? 'required' : '' }} {{ $disabled ? 'disabled' : '' }} {{ $readonly ? 'readonly' : '' }}>{{ $value }}</textarea>
                    @elseif ($type === 'checkbox' || $type === 'switch')
                        <div class="flex items-center gap-2 mt-2">
                            <input type="checkbox" name="{{ $name }}" id="field_{{ $name }}" value="1"
                                   {{ !empty($value) ? 'checked' : '' }}
                                   class="rounded border-slate-300 dark:border-slate-700 text-indigo-600 focus:ring-indigo-500 h-4 w-4"
                                   {{ $disabled ? 'disabled' : '' }}>
                            <span class="text-sm text-slate-600 dark:text-slate-400">{{ $placeholder ?: $label }}</span>
                        </div>
                    @else
                        <input type="{{ $type }}" name="{{ $name }}" id="field_{{ $name }}" value="{{ $value }}"
                               placeholder="{{ $placeholder }}"
                               class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2 px-3"
                               {{ $required ? 'required' : '' }} {{ $disabled ? 'disabled' : '' }} {{ $readonly ? 'readonly' : '' }}>
                    @endif

                    @if ($help)
                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ $help }}</p>
                    @endif

                    @error($name)
                        <p class="text-xs text-rose-600 dark:text-rose-400 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            @endforeach
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200 dark:border-slate-800">
            @if (empty($actions))
                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    Submit
                </button>
            @else
                @foreach ($actions as $act)
                    <button type="{{ $act['type'] ?? 'submit' }}"
                            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors">
                        {{ $act['label'] ?? ($act['name'] ?? 'Action') }}
                    </button>
                @endforeach
            @endif
        </div>
    </form>
</div>
