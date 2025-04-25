<div class="flex flex-col items-center w-full max-w-2xl mx-auto">
    {{-- RADIO BUTTONS --}}
    <div class="flex space-x-6 mb-4">
        <label class="inline-flex items-center cursor-pointer">
            <input wire:model="movieOrTv" type="radio" class="peer hidden" value="movie">
            <span
                class="px-6 py-2 rounded-full text-md font-medium border-2 border-indigo-400 peer-checked:bg-gradient-to-r peer-checked:from-indigo-600 peer-checked:to-purple-600 peer-checked:text-white peer-checked:border-transparent shadow-lg">
                Movie
            </span>
        </label>
        <label class="inline-flex items-center cursor-pointer">
            <input wire:model="movieOrTv" type="radio" class="peer hidden" value="tv">
            <span
                class="px-6 py-2 rounded-full text-md font-medium border-2 border-indigo-400 peer-checked:bg-gradient-to-r peer-checked:from-indigo-600 peer-checked:to-purple-600 peer-checked:text-white peer-checked:border-transparent shadow-lg">
                TV / Anime
            </span>
        </label>
    </div>

    <div class="relative w-full" x-data="{ isOpen: true }" @click.away="isOpen = false">
        <div class="absolute inset-y-0 start-0 flex items-center ps-4 pointer-events-none">
            <svg class="w-5 h-5 text-indigo-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
            </svg>
        </div>

        <input type="text" id="search-navbar"
            class="block w-full p-4 ps-12 text-lg text-white bg-gray-800 border-2 border-indigo-400 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent shadow-lg placeholder-gray-400"
            placeholder="Search..." wire:model.live.debounce.750ms="searchQuery"
            @focus="isOpen = true">

        <div class="absolute bg-gray-800 text-md rounded-xl shadow-2xl w-full mt-2 z-50 overflow-hidden"
            x-show="isOpen" @keydown.escape.window="isOpen = false">
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
                    <li class="border-b border-gray-700 hover:bg-gray-700 flex items-center">
                        @if ($result['poster_path'])
                            <img src="https://image.tmdb.org/t/p/w92/{{ $result['poster_path'] }}" alt="poster"
                                class="w-12 h-16 object-cover">
                        @else
                            <img src="{{ asset('images/notfound.jpg') }}" alt="no poster" class="w-12 h-16 object-cover">
                        @endif
                        <a href="{{ movieOrShowLink($movieOrTv, $result['id']) }}"
                            class="flex-1 px-4 py-4 font-medium hover:text-indigo-300">
                            {{ $movieOrTv === 'tv' ? $result['name'] : $result['title'] }}
                            @if (isset($result['release_date']))
                                <span
                                    class="text-gray-400 text-sm ml-2">({{ \Carbon\Carbon::parse($result['release_date'])->format('Y') }})</span>
                            @endif
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>