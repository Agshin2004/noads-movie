@extends('layout.layout')

@section('content')
    <div class="min-h-screen flex items-start justify-center bg-gradient-to-b from-gray-900 to-black p-10 text-white">
        <div class="flex flex-col md:flex-row w-full max-w-7xl overflow-hidden rounded-xl shadow-xl bg-opacity-80 backdrop-blur-lg">

            <!-- Actor Image -->
            <div class="w-full md:w-1/2 p-6">
                <img src="https://image.tmdb.org/t/p/original/{{ $person['profile_path'] }}" alt="Actor Image"
                    class="w-full h-full object-cover rounded-xl shadow-2xl transition-transform duration-300 hover:scale-105">
            </div>

            <!-- Info Section -->
            <div class="w-full md:w-1/2 p-8 space-y-6">
                <h1 class="text-4xl font-extrabold text-gray-100">{{ $person['name'] }}</h1>

                <ul class="text-lg space-y-3 text-neutral-300">
                    <li><span class="font-semibold">Date of Birth:</span> {{ $person['birthday'] }}</li>
                    @if ($person['deathday'])
                        <li><span class="font-semibold">Date of Death:</span> {{ $person['deathday'] }}</li>
                    @endif
                    <li><span class="font-semibold">Place of Birth:</span> {{ $person['place_of_birth'] }}</li>
                </ul>

                <h2 class="text-2xl font-semibold text-gray-400">Biography</h2>
                <div class="text-neutral-300">
                    <p class="leading-relaxed">
                        {{ substr($person['biography'], 0, 200) }}...
                        <span class="hidden" id="more-text">
                            {{ $person['biography'] }}
                        </span>
                    </p>
                    <button id="toggle-btn" class="mt-6 text-teal-400 hover:text-teal-300 transition-all duration-300">Read More</button>
                    <button id="hide-btn" class="hidden mt-6 text-teal-400 hover:text-teal-300 transition-all duration-300">Hide</button>
                </div>
            </div>

        </div>
    </div>

    <div class="flex flex-wrap gap-8 m-8 justify-center">
        <div class="flex flex-wrap gap-8 m-8">
            @foreach ($credits as $credit)
                @include('partials.card', [
                    'id' => $credit['id'],
                    'title' => isset($credit['name']) ? $credit['name'] : $credit['title'],
                    'rating' => $credit['vote_average'],
                    'poster' => $credit['poster_path'],
                    'releaseDate' => $credit['release_date'],
                    'movieId' => $credit['id'],
                    'genres' => $credit['genre_ids'],
                    'mediaType' => isset($credit['name']) ? 'tv' : 'movie' // TODO: simplify to null coalescing operator
                ])
            @endforeach
        </div>

        {{-- Pagination links --}}
        {!! $links !!}
    </div>

    @push('scripts')
        <script>
            const moreTextEl = document.getElementById("more-text");
            const toggleBtnEl = document.getElementById("toggle-btn");
            const hideBtnEl = document.getElementById("hide-btn");

            toggleBtnEl.addEventListener("click", () => {
                moreTextEl.classList.toggle("hidden");
                toggleBtnEl.classList.toggle("hidden");
                hideBtnEl.classList.toggle("hidden");
            });

            hideBtnEl.addEventListener("click", () => {
                moreTextEl.classList.toggle("hidden");
                toggleBtnEl.classList.toggle("hidden");
                hideBtnEl.classList.toggle("hidden");
            });
        </script>
    @endpush

@endsection
