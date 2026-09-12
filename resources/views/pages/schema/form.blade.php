@props(['schema' => []])

<x-blat-admin::layout :title="$schema['title'] ?? 'Form'">
    <x-blat-admin::form :schema="$schema" />
</x-blat-admin::layout>
