<div class="flex flex-col items-center">
    {{-- RADIO BUTTONSS --}}
    <div class="flex space-x-4 mb-2">
        <label class="inline-flex items-center cursor-pointer">
            {{--
            wire:model="movieOrTv" directive binds the radio button’s value to the Livewire component's $movieOrTv
            property;
            by default it is 'movie'
            --}}
            <input wire:model="movieOrTv" type="radio" class="peer hidden" value="movie">
            <span
                class="px-4 py-1 rounded-full text-sm border border-gray-500 peer-checked:bg-blue-600 peer-checked:text-white dark:border-gray-400 dark:peer-checked:bg-blue-500 transition">
                Movie
            </span>
        </label>
        <label class="inline-flex items-center cursor-pointer">
            {{--
            wire:model="movieOrTv" directive binds the radio button’s value to the Livewire component's $movieOrTv
            property;
            by default it is 'movie'
            --}}
            <input wire:model="movieOrTv" type="radio" class="peer hidden" value="tv">
            <span
                class="px-4 py-1 rounded-full text-sm border border-gray-500 peer-checked:bg-blue-600 peer-checked:text-white dark:border-gray-400 dark:peer-checked:bg-blue-500 transition">
                TV / Anime
            </span>
        </label>
    </div>
    <div class="relative md:block" x-data="{ isOpen: true }" @click.away="isOpen = false">
        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
            </svg>
            <span class="sr-only">Search icon</span>
        </div>
        <input type="text" id="search-navbar"
            class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="Search..." {{-- send property updates to the server as a user types into an input; set debounce
            750 ms to make less requests to server --}} wire:model.live.debounce.750ms="searchQuery" {{-- When focused
            open the dropdown --}} @focus="isOpen = true">

        <div class="absolute bg-gray-800 text-sm rounded w-53 z-50" x-show="isOpen"
            @keydown.escape.window="isOpen = false">
            <ul>
                {{-- SPINNER --}}
                <div wire:loading role="status">
                    <div class="flex justify-center mt-1 mb-1">
                        <div class="loader"></div> 
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>

                {{-- Results dropdown --}}
                @foreach ($searchResults as $result)
                    <li class="border-b border-gray-700 z-50 flex">
                        @if ($result['poster_path'])
                            <img src="https://image.tmdb.org/t/p/w92/{{ $result['poster_path'] }}" alt="" width="40">
                        @else
                            <img src="{{ asset('images/notfound.jpg') }}" alt="" width="40">
                        @endif
                        <a href="{{ movieOrShowLink($movieOrTv, $result['id']) }}"
                            class="block w-full hover:bg-gray-700 px-3 py-3">
                            {{ $movieOrTv === 'tv' ? $result['name'] : $result['title']  }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>