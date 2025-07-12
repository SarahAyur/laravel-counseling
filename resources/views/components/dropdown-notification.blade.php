@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'py-1 bg-white', 'count' => 0])

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
    <div @click="open = ! open" class="cursor-pointer relative">
        <button
            class="flex items-center p-1 rounded-full bg-white text-[#66003a] hover:bg-gray-50 focus:outline-none transition-colors duration-200 border border-white"
            title="Notifications">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                 xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
            </svg>
        </button>
        @if($count > 0)
            <span
                class="absolute -top-1 -right-1 bg-gray-200 text-[#66003a] text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                                {{ $count > 99 ? '99+' : $count }}
                            </span>
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
        <div class="rounded-md ring-1 ring-black ring-opacity-5 {{ $contentClasses }} max-h-96 overflow-y-auto">
            <div class="px-4 py-2 border-b border-gray-100">
                <h3 class="text-sm font-medium text-gray-700">Notifications</h3>
            </div>

            @if(isset($empty) && count((array)$slot) === 0)
                <div class="px-4 py-6 text-center text-sm text-gray-500">
                    {{ $empty }}
                </div>
            @else
                {{ $slot }}
            @endif

            @if(isset($footer))
                <div class="px-4 py-2 border-t border-gray-100 text-center">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</div>
