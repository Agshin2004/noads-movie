<ul class="flex flex-wrap justify-center items-center gap-1 sm:gap-2 mt-8 mb-10 px-4">
    <!-- Previous Button -->
    @if ($paginator->onFirstPage())
        <li class="disabled">
            <span class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 bg-gray-200 rounded-full cursor-not-allowed transition-all duration-300 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 sm:w-5 sm:h-5 text-gray-500">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </span>
        </li>
    @else
        <li>
            <a href="{{ $paginator->previousPageUrl() }}" class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-blue-500 to-indigo-600 text-white rounded-full hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 active:scale-95 shadow-md hover:shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 sm:w-5 sm:h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
        </li>
    @endif

    <!-- Pagination Elements -->
    @foreach ($elements as $element)
        <!-- "Three Dots" Separator -->
        @if (is_string($element))
            <li class="hidden sm:block">
                <span class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 text-gray-500 cursor-default">
                    {{ $element }}
                </span>
            </li>
        @endif

        <!-- Array Of Links -->
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if($page == $paginator->currentPage() || 
                   $page == 1 || 
                   $page == $paginator->lastPage() || 
                   abs($page - $paginator->currentPage()) <= 1)
                    <li>
                        <a href="{{ $url }}" class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-full transition-all duration-300 active:scale-95 shadow-sm {{ $page == $paginator->currentPage() ? 'bg-gradient-to-br from-red-500 to-pink-600 text-white shadow-md font-bold' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                            {{ $page }}
                        </a>
                    </li>
                @elseif(abs($page - $paginator->currentPage()) == 2)
                    <li class="hidden sm:block">
                        <span class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 text-gray-500 cursor-default">
                            ...
                        </span>
                    </li>
                @endif
            @endforeach
        @endif
    @endforeach

    <!-- Next Button -->
    @if ($paginator->hasMorePages())
        <li>
            <a href="{{ $paginator->nextPageUrl() }}" class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-blue-500 to-indigo-600 text-white rounded-full hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 active:scale-95 shadow-md hover:shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 sm:w-5 sm:h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </li>
    @else
        <li class="disabled">
            <span class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 bg-gray-200 rounded-full cursor-not-allowed transition-all duration-300 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 sm:w-5 sm:h-5 text-gray-500">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </span>
        </li>
    @endif
</ul>