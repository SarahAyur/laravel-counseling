@props(['variant' => 'default'])

@php
    $baseClasses = 'inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150';

    $variants = [
        'default' => 'bg-[#66003a] hover:bg-[#4d002b] focus:bg-[#4d002b] active:bg-[#330025] focus:ring-[#66003a]',
        'gray' => 'bg-gray-800 hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:ring-indigo-500',
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['default']);
@endphp

<button {{ $attributes->merge(['type' => 'submit', 'class' => $classes]) }}>
    {{ $slot }}
</button>
