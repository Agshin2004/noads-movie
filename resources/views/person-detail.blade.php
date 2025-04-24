@extends('layout.layout')

@section('content')
    <div class="min-h-screen flex items-start justify-center p-8 text-white-900">
        <div class="flex flex-col md:flex-row w-full max-w-5xl overflow-hidden">

            <!-- Actor Image -->
            <div class="w-full md:w-1/3">
                <img src="https://image.tmdb.org/t/p/original/{{ $person['profile_path'] }}" alt="Actor Image"
                    class="w-full h-80 object-cover">
            </div>

            <!-- Info Section -->
            <div class="w-full md:w-2/3 p-6">
                <h1 class="text-3xl font-bold mb-4">{{ $person['name'] }}</h1>

                <ul class="text-base space-y-2 mb-6">
                    <li><span class="font-semibold">Date of Birth:</span> {{ $person['birthday'] }}</li>
                    @if ($person['deathday'])
                        <li><span class="font-semibold">Date of Death:</span> {{ $person['deathday'] }}</li>
                    @endif
                    <li><span class="font-semibold">Place of Birth:</span> {{ $person['place_of_birth'] }}</li>
                </ul>

                <h2 class="text-xl font-semibold mb-2">Biography</h2>
                <div class="mx-auto">
                    <p class="leading-relaxed">
                        {{ substr($person['biography'], 0, 200) }}...
                        <span class="hidden" id="more-text">
                            {{ $person['biography'] }}
                        </span>
                    </p>
                    <button id="toggle-btn" class="mt-4 text-blue-500 focus:outline-none">Read More</button>
                    <button id="hide-btn" class="hidden mt-4 text-blue-500 focus:outline-none">Hide</button>
                </div>
                <p class="text-neutral-400 leading-relaxed"></p>
            </div>

        </div>
    </div>

    <div class="flex flex-wrap gap-5 m-6 justify-center">
        <div class="flex flex-direction flex-wrap gap-5 m-6">
            @foreach ($movieCredits as $movie)
                    @include('partials.card', [
                        'id' => $movie['id'],
                        'title' => $movie['original_title'],
                        'rating' => $movie['vote_average'],
                        'poster' => $movie['poster_path'],
                        'releaseDate' => $movie['release_date'],
                        'genreIds' => $movie['genre_ids'],
                        'movieId' => $movie['id'],
                        'genres' => $movie['genre_ids'],
                        'mediaType' => 'movie'
                    ])
            @endforeach
            </div>
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