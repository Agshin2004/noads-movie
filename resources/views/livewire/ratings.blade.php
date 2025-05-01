<div class="mt-10 bg-gray-900/70 rounded-xl p-4 sm:p-6 shadow-lg">
    <h2 class="text-xl sm:text-2xl font-extrabold text-white text-center mb-2">Rate This Movie</h2>

    {{-- Average Rating Display --}}
    <div class="text-center mb-4 sm:mb-6">
        <div class="text-yellow-400 text-2xl sm:text-3xl font-bold">
            {{ $ratingAverage }}/10
        </div>
        <div class="text-sm text-gray-400">
            Based on {{ $ratingCount }} {{ Str::plural('rating', $ratingCount ) }}
        </div>
    </div>

    <div class="flex flex-col items-center">
        @if ($rated)
            <div class="mt-4 sm:mt-6 text-center">
                <p class="text-2xl sm:text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 via-pink-500 to-red-500 animate-pulse">
                    ⭐ You rated this movie {{ $rated['rating'] }}/10!
                </p>
            </div>
        @else
            <!-- Responsive star rating -->
            <fieldset class="flex justify-center flex-row-reverse gap-1 sm:gap-2 mt-4 overflow-x-auto">
                @for ($i = 10; $i >= 1; $i--)
                    <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}"
                        class="hidden peer" required wire:model="rating" />
                    <label for="star{{ $i }}"
                        class="text-xl xs:text-2xl sm:text-3xl md:text-4xl cursor-pointer text-gray-500 transition-all duration-300 
                            peer-hover:text-yellow-400 peer-checked:text-yellow-500 
                            peer-hover:scale-105 peer-checked:scale-110">&#9733;</label>
                @endfor
            </fieldset>
            

            <button type="submit"
                class="cursor-pointer mt-4 sm:mt-6 bg-gradient-to-r from-yellow-500 to-pink-500 text-white font-semibold py-2 px-5 sm:px-6 rounded-full hover:scale-105 transition-transform duration-300 shadow-md"
                wire:click="submitRating">
                Submit Rating
            </button>
        @endif
    </div>
</div>
