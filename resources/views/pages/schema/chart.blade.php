@props(['schema' => []])

<x-blat-admin::layout :title="$schema['title'] ?? 'Chart'">
    <x-blat-admin::chart :schema="$schema" />
</x-blat-admin::layout>
