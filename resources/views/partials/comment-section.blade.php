<div class="mt-20">
    <h2
        class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-green-400 via-blue-500 to-purple-600 text-center mb-10">
        💬 Comments
    </h2>
    <div class="bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 p-8 rounded-2xl shadow-2xl">
        <form method="POST" action="#" class="space-y-6">
            @csrf
            <textarea
                class="w-full p-4 rounded-xl bg-gray-700 text-white border-2 border-transparent focus:border-purple-500 transition duration-300 resize-none"
                rows="5" placeholder="Share your thoughts about the movie..."></textarea>
            <div class="flex justify-end">
                <button type="submit"
                    class="cursor-pointer bg-gradient-to-r from-purple-500 via-pink-500 to-red-500 text-white font-bold py-2 px-6 rounded-full hover:scale-105 transition-transform duration-300">
                    Post Comment
                </button>
            </div>
        </form>

        <div class="mt-10 space-y-6">
            {{-- Example Comment --}}
            <div class="flex items-start space-x-4">
                <div class="flex-1 bg-gray-800 p-4 rounded-xl shadow-md">
                    <div class="flex justify-between items-center">
                        <h4 class="text-white font-bold">MovieFan99</h4>
                        <span class="text-xs text-gray-400">2 hours ago</span>
                    </div>
                    <p class="text-gray-300 mt-2">This movie was absolutely mind-blowing. The cinematography alone
                        deserves awards!</p>
                </div>
            </div>
            {{-- Repeat more comments here --}}
        </div>
    </div>
</div>