<footer class=" bg-gray-900 text-white py-12">
    <div class="max-w-screen-lg mx-auto px-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            
            <!-- Company/Brand Info -->
            <div>
                <h4 class="text-2xl font-semibold text-transparent bg-clip-text bg-gradient-to-r from-pink-500 to-yellow-500 mb-4">
                    ZMA Movies
                </h4>
                <p class="text-sm text-gray-400">
                    No BS Movie Website.
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h5 class="text-lg font-semibold mb-4">Quick Links</h5>
                <ul class="space-y-2 text-gray-400 text-sm">
                    <li><a href="{{ route('index') }}" class="hover:text-yellow-500 transition-colors">Home</a></li>
                    <li><a href="#" class="hover:text-yellow-500 transition-colors">Contact Us</a></li>
                </ul>
            </div>

            <!-- Follow Us -->
            <div>
                <h5 class="text-lg font-semibold mb-4">Follow Us</h5>
                <div class="flex gap-4">
                    <a href="https://t.me/+fcQNozuDlS45ODE6" class="text-gray-400 hover:text-blue-400 transition-colors">
                        Telegram
                    </a>
                </div>
            </div>

            <!-- Newsletter Signup -->
            <div>
                <h5 class="text-lg font-semibold mb-4">Stay Updated</h5>
                <p class="text-sm text-gray-400 mb-4">Join Our Telegram Channel</p>
                <div class="flex items-center gap-4">
                    <a href="https://t.me/+fcQNozuDlS45ODE6" class="cursor-pointer  bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-300 hover:bg-indigo-700">
                        Telegram >
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-12 text-center text-gray-400 text-sm">
            <p>&copy; {{ date('Y') }} ZMA Movies.</p>
        </div>
    </div>
</footer>
