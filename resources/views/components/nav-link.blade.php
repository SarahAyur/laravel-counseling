@props(['active'])

@php
    $classes = ($active ?? false)
                ? 'inline-flex items-center px-3 py-2 border-b-2 border-[#66003a] text-sm font-medium leading-5 text-[#66003a] focus:outline-none transition duration-150 ease-in-out'
                : 'inline-flex items-center px-3 py-2 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
