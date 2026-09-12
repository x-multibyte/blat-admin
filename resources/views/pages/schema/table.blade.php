@props(['schema' => []])

<x-blat-admin::layout :title="$schema['title'] ?? 'Table'">
    <x-blat-admin::table :schema="$schema" />
</x-blat-admin::layout>
