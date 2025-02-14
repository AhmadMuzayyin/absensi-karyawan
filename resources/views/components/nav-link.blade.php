@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'bg-indigo-50 text-indigo-600 hover:text-indigo-900 hover:bg-indigo-100'
            : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
