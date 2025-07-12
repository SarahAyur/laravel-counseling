<div class="relative inline-block text-left" x-data="{ open: false, top: 0, left: 0, width: 0 }">
    <button @click="
                        open = !open;
                        if (open) {
                            $nextTick(() => {
                                const rect = $el.getBoundingClientRect();
                                left = rect.left;
                                top = rect.bottom + window.scrollY;
                                width = 224; // 56 * 4 = 224px (w-56)

                                // Check if dropdown would go off-screen to the right
                                if (left + width > window.innerWidth) {
                                    left = rect.right - width;
                                }

                                // Check if dropdown would go off-screen at the bottom
                                const dropdownHeight = $refs.dropdown.offsetHeight;
                                if (rect.bottom + dropdownHeight > window.innerHeight && rect.top > dropdownHeight) {
                                    top = (rect.top + window.scrollY) - dropdownHeight;
                                }
                            });
                        }"
            @click.away="open = false"
            type="button"
            class="inline-flex items-center px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-md transition duration-150 ease-in-out">
        <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
                  stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
        </svg>
        Aksi
    </button>

    <template x-teleport="body">
        <div x-show="open"
             x-ref="dropdown"
             x-transition:enter="transition ease-out duration-100"
             x-transition:enter-start="transform opacity-0 scale-95"
             x-transition:enter-end="transform opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-75"
             x-transition:leave-start="transform opacity-100 scale-100"
             x-transition:leave-end="transform opacity-0 scale-95"
             :style="`position: absolute; top: ${top}px; left: ${left}px; width: ${width}px; z-index: 9999;`"
             class="rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
            <div class="p-2 space-y-1">
                {{ $slot }}
            </div>
        </div>
    </template>
</div>
