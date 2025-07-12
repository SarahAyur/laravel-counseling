@props(['items' => []])

<nav class="flex mb-5" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        @foreach($items as $index => $item)
            @if($index === 0)
                <li class="inline-flex items-center">
                    <a href="{{ $item['url'] }}"
                       class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-[#66003a]">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                            <path fill-rule="evenodd"
                                  d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
                                  clip-rule="evenodd"></path>
                        </svg>
                        {{ $item['name'] }}
                    </a>
                </li>
            @else
                <li {{ $index === count($items) - 1 ? 'aria-current="page"' : '' }}>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                  clip-rule="evenodd"></path>
                        </svg>
                        @if(isset($item['url']))
                            <a href="{{ $item['url'] }}"
                               class="ml-1 text-sm font-medium text-gray-700 hover:text-[#66003a] md:ml-2">
                                {{ $item['name'] }}
                            </a>
                        @else
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $item['name'] }}</span>
                        @endif
                    </div>
                </li>
            @endif
        @endforeach
    </ol>
</nav>
