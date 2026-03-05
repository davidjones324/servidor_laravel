@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-3 py-2 rounded-md text-sm font-semibold leading-5 text-white bg-ies-blue-700 focus:outline-none transition duration-150 ease-in-out'
            : 'inline-flex items-center px-3 py-2 rounded-md text-sm font-medium leading-5 text-ies-blue-100 hover:text-white hover:bg-ies-blue-500 focus:outline-none focus:text-white transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
