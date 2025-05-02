<nav class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 p-4 shadow-lg">
    <div class="max-w-screen-xl mx-auto flex flex-col lg:flex-row items-center justify-between">
        <!-- Logo -->
        <a href="{{ route('index') }}"
            class="text-5xl font-bold text-white hover:text-indigo-200 transition-all duration-300 mb-4 lg:mb-0">
            ZMA
        </a>

        <!-- Search Dropdown with responsive margin -->
        <div class="mr-5 ml-5 mt-5 mb-5 lg:mt-0 lg:mb-0 sm:mt-5 sm:mb-5">
            <livewire:search-dropdown>
        </div>

        <!-- Navbar Links and Auth Links -->
        <div class="flex items-center space-x-8 text-white justify-center w-full lg:w-auto">
            @auth
                <!-- Navbar Links (Favorites, Logout) -->
                <a href="{{ route('favorites') }}"
                    class="text-base lg:text-lg text-white bg-gradient-to-r from-purple-600 via-indigo-600 to-blue-600 px-6 py-3 rounded-full shadow-lg hover:from-blue-600 hover:to-indigo-600 hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                    Favorites
                </a>
                <a href="{{ route('logout') }}"
                    class="bg-red-600 text-base lg:text-lg px-4 py-2 rounded-full text-white hover:bg-orange-600 hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                    Logout
                </a>
            @else
                <a href="{{ route('login') }}"
                    class="relative inline-block px-4 py-2 sm:px-5 sm:py-2.5 lg:px-6 lg:py-3 text-sm sm:text-base lg:text-lg font-semibold text-white rounded-full overflow-hidden group transition-all duration-300 bg-black bg-opacity-30 border border-white/20 shadow-md hover:shadow-pink-500/50 hover:scale-105 backdrop-blur-md">
                    <span
                        class="absolute inset-0 w-full h-full bg-gradient-to-br from-pink-500 via-purple-600 to-indigo-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-full blur-sm"></span>
                    <span class="relative z-10">Login</span>
                </a>

                <a href="{{ route('register') }}"
                    class="relative inline-block px-4 py-2 sm:px-5 sm:py-2.5 lg:px-6 lg:py-3 text-sm sm:text-base lg:text-lg font-semibold text-gray-900 rounded-full overflow-hidden group transition-all duration-300 bg-white hover:scale-105 shadow-lg hover:shadow-indigo-500/40">
                    <span
                        class="absolute inset-0 w-full h-full bg-gradient-to-br from-white to-gray-100 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-full blur-sm"></span>
                    <span class="relative z-10">Register</span>
                </a>
            @endauth
        </div>
    </div>
</nav>
