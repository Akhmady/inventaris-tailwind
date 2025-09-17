@if ($paginator->hasPages())
    <nav role="navigation" class="flex items-center justify-between">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-md cursor-not-allowed">Prev</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
                class="px-3 py-2 text-sm bg-teal-600 text-white rounded-md hover:bg-teal-700">Prev</a>
        @endif

        {{-- Numbers --}}
        <div class="flex items-center gap-1">
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="px-3 py-2 text-sm text-gray-500">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span
                                class="px-3 py-2 text-sm font-semibold text-white bg-teal-600 rounded-md">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}"
                                class="px-3 py-2 text-sm text-gray-700 bg-white border rounded-md hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-300">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
                class="px-3 py-2 text-sm bg-teal-600 text-white rounded-md hover:bg-teal-700">Next</a>
        @else
            <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-md cursor-not-allowed">Next</span>
        @endif
    </nav>
@endif
