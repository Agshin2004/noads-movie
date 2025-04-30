<footer class=" bg-gray-900 text-white py-12">
    <div class="max-w-screen-lg mx-auto px-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">

            <!-- Company/Brand Info -->
            <div>
                <h4
                    class="text-2xl font-semibold text-transparent bg-clip-text bg-gradient-to-r from-pink-500 to-yellow-500 mb-4">
                    <a href="{{ route('index') }}" class="hover:text-indigo-200 transition-all duration-300">
                        ZMA Movies
                    </a>
                </h4>
                <p class="text-sm text-gray-400">
                    No BS Movie Website.
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h5 class="text-lg font-semibold mb-4">Quick Links</h5>
                <ul class="space-y-2 text-gray-400 text-sm">
                    <li>
                        <a href="{{ route('index') }}" class="hover:text-yellow-500 transition-colors">Home</a>
                    </li>
                    <li>
                        <button data-modal-target="contact-modal" data-modal-toggle="contact-modal"
                            class="hover:text-yellow-500 transition-colors cursor-pointer" type="button">
                            Contact Us
                        </button>
                    </li>
                </ul>
            </div>

            <!-- Follow Us -->
            <div>
                <h5 class="text-lg font-semibold mb-4">Follow Us</h5>
                <div class="flex gap-4">
                    <a href="https://t.me/+fcQNozuDlS45ODE6"
                        class="text-gray-400 hover:text-blue-400 transition-colors">
                        Telegram
                    </a>
                </div>
            </div>

            <!-- Newsletter Signup -->
            <div>
                <h5 class="text-lg font-semibold mb-4">Stay Updated</h5>
                <p class="text-sm text-gray-400 mb-4">Join Our Telegram Channel</p>
                <div class="flex items-center gap-4">
                    <a href="https://t.me/+fcQNozuDlS45ODE6"
                        class="cursor-pointer  bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-300 hover:bg-indigo-700">
                        Telegram >
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-12 text-center text-gray-400 text-sm">
            <p>&copy; {{ date('Y') }} ZMA Movies.</p>
        </div>


        {{-- Contact Modal FOrm --}}
        <div id="contact-modal" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-black/70">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                    <!-- Modal header -->
                    <div
                        class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Contact ZMA Movies
                        </h3>
                        <button type="button"
                            class="cursor-pointer end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="contact-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5">
                        <form class="space-y-4" method="post" action="/contact-us">
                            @csrf
                            <div
                                class="text-sm font-bold text-red-600 bg-yellow-100 border border-yellow-400 rounded-md p-2 text-center animate-pulse">
                                🔒 We do <u>not</u> store your email - it is used only to contact you back.
                            </div>
                            <div>
                                <input type="email" name="email" id="email"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                    placeholder="email@mail.com" required />
                            </div>
                            <div>
                                <input type="text" name="subject" id="subject" placeholder="Subject"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                    required />
                            </div>
                            <div>
                                <textarea type="text" name="body" id="body" placeholder="Body"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                    required></textarea>
                            </div>
                            <button type="submit"
                                class="cursor-pointer w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @push('scripts')
            @if (session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        alertify.success('{{ session('success') }}');
                    });
                </script>
            @endif
            @if (session('fail'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        alertify.error('{{ session('fail') }}');
                    });
                </script>
            @endif

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            alertify.error('{{ $error }}')
                        });
                    </script>
                @endforeach
            @endif
        @endpush
</footer>
