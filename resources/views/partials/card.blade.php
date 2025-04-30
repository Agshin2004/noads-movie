<a href="{{ movieOrShowLink($mediaType, $id) }}">
    <div class="relative w-full max-w-xs aspect-[2/3] rounded-xl overflow-hidden shadow-lg group transform transition-all duration-300 hover:scale-105 hover:shadow-2xl">
        <img src="{{ $poster }}" alt="Movie Poster" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110" />


        <!-- Dark overlay with smooth hover effect -->
        <div class="absolute inset-0 bg-black/60 group-hover:bg-black/80 transition-colors"></div>

        <!-- Text content with stylish overlay -->
        <div class="absolute inset-0 flex flex-col justify-end p-4 text-white cursor-pointer">
            <h3 class="text-lg font-bold text-white truncate">{{ $title }}</h3>
            <p class="text-sm text-cyan-300 mt-1 truncate">
                {{ $genres }} • {{ $releaseDate }}
            </p>

            <!-- Rating and Watch Button -->
            <div class="flex items-center justify-between mt-3">
                <span class="text-yellow-400 text-sm font-semibold">⭐ {{ $rating }}</span>
                <button class="cursor-pointer bg-gradient-to-r from-yellow-500 to-yellow-600 hover:bg-gradient-to-l text-xs font-semibold px-4 py-2 rounded-lg transform transition duration-300 hover:scale-105">
                    Watch Now
                </button>
            </div>
        </div>
    </div>
</a>
