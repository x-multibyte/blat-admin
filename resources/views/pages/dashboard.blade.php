<x-blat-admin::layout title="Dashboard">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="text-sm font-medium text-slate-500 dark:text-slate-400">Total Administrators</div>
            <div class="text-3xl font-bold text-slate-900 dark:text-slate-100 mt-2">
                {{ \XMultibyte\BlatAdmin\Models\Admin::count() }}
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="text-sm font-medium text-slate-500 dark:text-slate-400">Active Admins</div>
            <div class="text-3xl font-bold text-emerald-600 dark:text-emerald-400 mt-2">
                {{ \XMultibyte\BlatAdmin\Models\Admin::active()->count() }}
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="text-sm font-medium text-slate-500 dark:text-slate-400">Environment</div>
            <div class="text-3xl font-bold text-indigo-600 dark:text-indigo-400 mt-2 uppercase text-xl">
                {{ app()->environment() }}
            </div>
        </div>
    </div>
</x-blat-admin::layout>
