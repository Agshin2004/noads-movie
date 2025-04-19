<a href="{{ route('watch', $movieId) }}">
    <div class="relative w-full max-w-[200px] aspect-[2/3] rounded-lg overflow-hidden shadow-md group">
        {{-- TODO: Change original to low resolution in production --}}
        <img src="https://image.tmdb.org/t/p/original/{{ $poster }}" alt="Movie Poster"
            class="w-full h-full object-cover" />

        <!-- Dark overlay -->
        <div class="absolute inset-0 bg-black/50 group-hover:bg-black/60 transition-colors"></div>
        <!-- Text content -->
        <div class="absolute inset-0 flex flex-col justify-end p-3 text-white cursor-pointer">
            <h3 class="text-sm font-bold leading-tight">{{ $title }}</h3>
            <p class="text-xs text-cyan-200">
                @foreach ($genreIds as $genreId)
                    {{ $genresName[$genreId] }}@if (!$loop->last),@endif
                @endforeach
                • {{ \Carbon\Carbon::parse($releaseDate)->format('Y F') }}
            </p>
            <div class="flex items-center justify-between mt-2">
                <span class="text-yellow-400 text-sm font-bold">⭐ {{ round($rating, 1) }}</span>
                <button class="bg-yellow-500 hover:bg-yellow-600 text-xs font-semibold px-2 py-1 rounded">
                    Watch
                </button>
            </div>
        </div>
    </div>
</a>