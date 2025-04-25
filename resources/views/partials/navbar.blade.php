<nav class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 p-4 shadow-lg">
    <div class="max-w-screen-xl mx-auto flex flex-col lg:flex-row items-center justify-between">
        <!-- Logo -->
        <a href="{{ route('index') }}" class="text-5xl font-bold text-white hover:text-indigo-200 transition-all duration-300 mb-4 lg:mb-0">
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
                <a href="#" class="text-base lg:text-lg hover:text-indigo-200 transition-all duration-300">Favorites</a>
                <a href="{{ route('logout') }}" 
                   class="bg-red-600 text-base lg:text-lg px-4 py-2 rounded-full text-white hover:bg-red-700 transition-all duration-300">
                    Logout
                </a>
            @else
                <!-- Auth Links (Login, Register) -->
                <a href="{{ route('login') }}" class="border border-white text-base lg:text-lg px-4 py-2 rounded-full text-white hover:bg-white hover:text-gray-900 transition-all duration-300">
                    Login
                </a>
                <a href="{{ route('register') }}" class="bg-white text-base lg:text-lg px-4 py-2 rounded-full text-gray-900 hover:bg-gray-100 transition-all duration-300">
                    Register
                </a>
            @endauth
        </div>
    </div>
</nav>
