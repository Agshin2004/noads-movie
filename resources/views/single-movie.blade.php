@extends('layout.layout')

@section('content')
    <div class="max-w-screen-lg mx-auto p-4 sm:p-8">

        {{-- Movie Header --}}
        <div
            class="flex flex-col sm:flex-row items-center bg-gradient-to-r from-gray-800 via-gray-700 to-gray-800 p-6 rounded-xl shadow-lg">
            <img src="{{ $movie['poster_path'] }}" alt="Movie Poster"
                class="w-full max-w-xs sm:w-48 sm:h-72 object-cover rounded-lg shadow-md mx-auto sm:mx-0">
            <div class="sm:ml-8 mt-6 sm:mt-0 text-center sm:text-left">
                <h1
                    class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-pink-500 mb-2">
                    @if ($movie['original_title'] !== $movie['title'])
                        <div class="text-2xl md:text-xl sm:text-sm">
                            {{ $movie['original_title'] }}
                        </div>
                    @endif
                    <div>
                        {{ $movie['title'] }}
                        <sup class="text-xl font-bold text-yellow-400">{{ $movie['vote_average'] }}</sup>
                    </div>
                </h1>
                <div class="text-gray-400 text-lg mb-4">
                    {{ $movie['release_date'] }} • {{ $movie['runtime'] }} min •
                    <span
                        class="inline-block bg-gradient-to-r from-blue-600 to-indigo-600 text-[15px] text-white text-xs font-semibold px-3 py-1 rounded-full shadow-sm hover:scale-105 transition-transform duration-200">
                        {{ $movie['origin_country'] }}
                    </span>
                </div>
                <div class="flex flex-wrap justify-center sm:justify-start gap-2 mb-4">
                    @foreach ($movie['genres'] as $genre)
                        <span
                            class="bg-gradient-to-r from-pink-500 to-red-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                            {{ $genre }}
                        </span>
                    @endforeach
                </div>
                <p class="text-gray-300 italic mb-6">{{ $movie['tagline'] }}</p>
                <div class="flex justify-center sm:justify-start gap-4">
                    <button
                        class="sm:text-sm cursor-pointer bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-indigo-700 hover:to-blue-700 text-white font-bold py-2 px-6 rounded-full transition duration-300"
                        data-micromodal-trigger="modal-1">
                        🎬 See Trailer
                    </button>
                    <livewire:favorites :id="$movie['id']" :type="$type" />
                </div>
            </div>
        </div>

        {{-- Movie Overview --}}
        <div class="mt-12 bg-gray-800/50 p-6 rounded-lg shadow-lg">
            <h2 class="text-3xl font-extrabold text-white mb-4">Overview</h2>
            <p class="text-gray-300 text-base">{{ $movie['overview'] }}</p>
        </div>

        {{-- Cast --}}
        <div class="mt-12">
            <h2
                class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-600 text-center mb-10">
                Cast
            </h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-6">
                @foreach ($movie['credits'] as $actor)
                    <a href="{{ route('person', ['personId' => $actor['id']]) }}">
                        <div
                            class="text-center bg-gray-800/40 rounded-lg p-4 hover:scale-105 transition-transform duration-300">
                            <img src="https://image.tmdb.org/t/p/w185/{{ $actor['profile_path'] }}" alt="Cast Member"
                                class="w-24 h-24 object-cover rounded-full mx-auto mb-3 border-2 border-pink-500">
                            <p class="text-lg font-semibold text-white">{{ $actor['name'] }}</p>
                            <p class="text-gray-400 text-sm">{{ $actor['character'] }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Trailer Modal --}}
        <div class="micromodal" id="modal-1" aria-hidden="true">
            <div class="micromodal__overlay z-50" tabindex="-1" data-micromodal-close>
                <div class="micromodal__container p-0 m-0 w-full h-full" role="dialog" aria-modal="true"
                    aria-labelledby="modal-1-title">
                    <div class="w-full h-full">
                        <iframe class="w-full h-full" src="https://www.youtube.com/embed/{{ $trailerKey }}"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>

        {{-- Player Tip and Player --}}
        <div class="mt-25 mb-8 flex flex-col items-center space-y-4">
            {{-- Scrolling warning text --}}
            <div class="w-full overflow-hidden px-4 sm:px-6">
                <div class="animate-marquee animate-bgshift font-bold text-black py-2 px-4 sm:px-6 rounded-lg shadow-xl text-center text-sm sm:text-base transition-colors duration-500 leading-snug"
                    style="background: linear-gradient(-45deg, #f87171, #facc15, #4ade80, #60a5fa); background-size: 600% 600%;">
                    ⚠️ Server not working? <span class="block sm:inline">Try switching servers from the dropdown!</span> ⚠️
                </div>
            </div>


            {{-- Dropdown --}}
            <div class="relative inline-block w-72">
                <label for="serverSelect" class="block mb-3 text-pink-400 text-xl font-extrabold text-center tracking-wide">
                    Select Streaming Server
                </label>
                <select id="serverSelect"
                    class="w-full bg-gradient-to-r from-gray-950 via-gray-900 to-gray-950 text-white text-lg font-bold px-6 py-3 rounded-2xl border border-pink-600 shadow-2xl hover:ring-2 hover:ring-pink-400 focus:outline-none focus:ring-4 focus:ring-pink-500/90 transition-all duration-300 ease-in-out">
                    <option value="1">🚀 Server 1</option>
                    <option value="2">🔥 Server 2</option>
                    <option value="3">⚡ Server 3</option>
                    <option value="4">💥 Server 4</option>
                    <option value="5">🌐 Server 5</option>
                </select>
            </div>
        </div>
        <div class="player-container">
            <iframe src="https://vidsrc.cc/v2/embed/movie/{{ $movie['id'] }}?autoPlay=false"
                class="movie-iframe w-full h-[450px] rounded-xl shadow-2xl" allowfullscreen></iframe>
        </div>

        <div
            class="mt-16 mb-10 p-5 bg-gradient-to-r from-red-600 via-yellow-500 to-pink-600 text-white rounded-lg shadow-lg animate-pulse">
            <div class="flex items-center space-x-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <p class="text-lg font-extrabold uppercase tracking-wide">⚡ Player Tip</p>
                    <p class="text-sm font-medium">Some servers provide additional ones that you may change inside the
                        player
                        (top left corner).</p>
                </div>
            </div>
        </div>



        {{-- Star Rating --}}
        <livewire:ratings :movieOrShowId="$movie['id']" />


        {{-- Images --}}
        <section class="mt-20 mb-16">
            <div class="text-center mb-10">
                <h2
                    class="text-4xl sm:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-red-500 to-yellow-500 animate-pulse">
                    Movie Gallery
                </h2>
                <p class="mt-2 text-gray-400 text-sm sm:text-base">Swipe through awesome moments</p>
            </div>

            <div class="images-wrapper px-4">
                <div class="splide" id="image-slider">
                    <div class="splide__track rounded-xl overflow-hidden shadow-lg ring-2 ring-pink-500/50">
                        <ul class="splide__list">
                            @foreach ($movie['images'] as $image)
                                <li class="splide__slide transition-transform duration-500 hover:scale-105">
                                    <img src="https://image.tmdb.org/t/p/w780/{{ $image['file_path'] }}"
                                        class="w-full object-contain">
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </section>


        {{-- TODO: ADD CRITIC REVIEWS --}}

        {{-- Comments Section --}}
        <livewire:comments :id="$movie['id']" />

    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                fetchPlayers({{ $movie['id'] }})
            });
        </script>
    @endpush
@endsection
