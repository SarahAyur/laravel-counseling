@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'py-1 bg-white', 'image' => null, 'name' => '', 'initial' => ''])

@php
    $alignmentClasses = match ($align) {
        'left' => 'ltr:origin-top-left rtl:origin-top-right start-0',
        'top' => 'origin-top',
        default => 'ltr:origin-top-right rtl:origin-top-left end-0',
    };

    $width = match ($width) {
        '48' => 'w-48',
        default => $width,
    };
@endphp

<div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
    <div @click="open = ! open" class="cursor-pointer">
        @if($image)
            <img src="{{ $image }}" alt="{{ $name }}"
                 class="h-9 w-9 rounded-full object-cover border-2 border-white hover:border-[#66003a] transition-colors duration-200">
        @else
            <div
                class="h-9 w-9 rounded-full bg-[#66003a] text-white flex items-center justify-center text-sm font-medium border-2 border-white hover:bg-[#7a0047] transition-colors duration-200">
                {{ $initial ?? substr($name, 0, 1) }}
            </div>
        @endif
    </div>

    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute z-50 mt-2 {{ $width }} rounded-md shadow-lg {{ $alignmentClasses }}"
         style="display: none;"
         @click="open = false">
        <div class="rounded-md ring-1 ring-black ring-opacity-5 {{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>
