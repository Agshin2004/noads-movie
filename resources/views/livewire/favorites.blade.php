<div>
    @if(!$added)
        <button wire:click="addOrRemove"
            class="cursor-pointer bg-gradient-to-r from-green-400 to-green-600 hover:from-green-600 hover:to-green-400 text-white font-bold py-2 px-6 rounded-full transition duration-300 text-base sm:text-sm">
            ❤️ Add to Favorites
        </button>
    @else
        <button wire:click="addOrRemove"
            class="cursor-pointer bg-gradient-to-r from-orange-300 to-red-600 hover:from-red-600 hover:to-orange-400 text-white font-bold py-2 px-6 rounded-full transition duration-300 text-base sm:text-sm">
            💔 Remove from Favorites
        </button>
    @endif
</div>
