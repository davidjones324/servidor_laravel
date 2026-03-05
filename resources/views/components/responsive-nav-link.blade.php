@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-white text-start text-base font-semibold text-white bg-ies-blue-600 focus:outline-none transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-ies-blue-100 hover:text-white hover:bg-ies-blue-600 hover:border-ies-blue-300 focus:outline-none focus:text-white focus:bg-ies-blue-600 focus:border-ies-blue-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
