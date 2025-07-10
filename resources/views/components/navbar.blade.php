@auth
    <nav class="bg-white border-b border-gray-200 fixed w-full z-50 shadow-sm" x-data="{ mobileMenuOpen: false, profileOpen: false }" aria-label="Global">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="/" class="flex items-center">
                        <img class="h-10 w-10" src="{{ asset('img/logo.png') }}" alt="Logo" />
                        <span class="ml-2 text-xl font-bold text-[#219ebc]">ECommerce<span class="text-[#ffb703]">Zyy</span>
                        </span>
                    </a>
                </div>
                <!-- Menu tengah (hidden di md ke bawah) -->
                <div class="hidden lg:flex space-x-8 flex-1 justify-center">
                    <a href="/dashboard" class="text-gray-700 hover:text-[#219ebc] font-semibold">Dashboard</a>
                    <a href="/cart" class="text-gray-700 hover:text-[#219ebc] font-semibold relative">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="w-6 h-6 fill-current">
                            <path
                                d="M0 24C0 10.7 10.7 0 24 0L69.5 0c22 0 41.5 12.8 50.6 32l411 0c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3l-288.5 0 5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5L488 336c13.3 0 24 10.7 24 24s-10.7 24-24 24l-288.3 0c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5L24 48C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z" />
                        </svg>
                    </a>
                    <a href="/success" class="text-gray-700 hover:text-[#219ebc] font-semibold">Checkout</a>
                </div>
                <!-- Search bar (hidden di lg ke bawah) -->
                <div class="hidden lg:flex flex-1 justify-end mr-6">
                    <form action="{{ route('product.search') }}" method="GET" class="relative p-4">
                        <input type="text" name="query" placeholder="Cari produk..."
                            class="w-full border border-gray-300 rounded-lg py-2 px-3 pr-10 focus:outline-none focus:ring-2 focus:ring-[#219ebc]"
                            autocomplete="off" />
                        <button type="submit"
                            class="absolute right-6 top-1/2 -translate-y-1/2 text-[#219ebc] hover:text-green-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" />
                            </svg>
                        </button>
                    </form>
                </div>
                <!-- Profile pojok kanan -->
                <div class="hidden lg:flex items-center relative">
                    <button @click="profileOpen = !profileOpen" class="flex items-center space-x-2 focus:outline-none"
                        aria-haspopup="true" aria-expanded="false">
                       @if (auth()->user()->avatar)
    <img src="/avatars/{{ auth()->user()->avatar }}" alt="User Avatar"
        class="w-12 h-12 rounded-full object-cover border-2 border-[#219ebc]">
@else
    <div
        class="w-12 h-12 rounded-full bg-[#219ebc] text-white flex items-center justify-center font-bold text-lg">
        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
    </div>
@endif
                        <span class="text-gray-800 font-semibold">{{ Auth::user()->name }}</span>
                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </button>
                    <!-- Dropdown -->
                    <div x-show="profileOpen" @click.outside="profileOpen = false" x-transition
                        class="absolute right-0 mt-34 w-48 bg-white border border-gray-200 rounded-md shadow-lg py-2"
                        style="display: none;">
                        <a href="{{ route('user.profile') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                            View Profile
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                                Log out
                            </button>
                        </form>
                    </div>
                </div>
                <!-- Mobile menu button -->
                <div class="lg:hidden flex items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-white hover:bg-[#219ebc] focus:outline-none"
                        aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg x-show="!mobileMenuOpen" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg x-show="mobileMenuOpen" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" x-transition class="lg:hidden bg-white border-t border-gray-200 shadow-md"
            style="display: none;">
            <div class="px-4 py-4 border-b border-gray-200 flex items-center space-x-3">
                @if (auth()->user()->avatar)
                    <img src="/avatars/{{ auth()->user()->avatar }}" alt="User Avatar" class="w-10 h-10 rounded-full" />
                @else
                    <div
                        class="w-10 h-10 rounded-full bg-[#219ebc] text-white flex items-center justify-center font-bold text-lg">
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                    </div>
                @endif
                <span class="text-gray-800 font-semibold">{{ auth()->user()->name }}</span>
            </div>
            <form action="{{ route('product.search') }}" method="GET" class="relative p-4">
                <input type="text" name="query" placeholder="Cari produk..."
                    class="w-full border border-gray-300 rounded-lg py-2 px-3 pr-10 focus:outline-none focus:ring-2 focus:ring-blue-400"
                    autocomplete="off" />
                <button type="submit"
                    class="absolute right-6 top-1/2 -translate-y-1/2 text-[#219ebc] hover:text-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" />
                    </svg>
                </button>
            </form>
            <div class="px-4 pb-4 space-y-2">
                <a href="/dashboard" class="block text-gray-700 hover:text-[#219ebc] font-semibold">Dashboard</a>
                <a href="/cart" class="text-gray-700 hover:text-[#219ebc] font-semibold relative">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="w-6 h-6 fill-current">
                        <path
                            d="M0 24C0 10.7 10.7 0 24 0L69.5 0c22 0 41.5 12.8 50.6 32l411 0c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3l-288.5 0 5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5L488 336c13.3 0 24 10.7 24 24s-10.7 24-24 24l-288.3 0c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5L24 48C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z" />
                    </svg>
                </a> <a href="/success" class="block text-gray-700 hover:text-[#219ebc] font-semibold">Checkout</a>
                <hr class="my-2" />
                <a href="{{ route('user.profile') }}"
                    class="block text-gray-700 hover:bg-gray-100 rounded px-3 py-2">View Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 text-gray-700 hover:bg-gray-100 rounded">
                        Log out
                    </button>
                </form>
            </div>
        </div>
    </nav>
@else
    <nav class="bg-white border-b border-gray-200 fixed w-full z-50 shadow-sm" x-data="{ mobileMenuOpen: false }"
        aria-label="Global">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="/" class="flex items-center">
                        <img class="h-10 w-10" src="{{ asset('img/logo.png') }}" alt="Logo" />
                        <span class="ml-2 text-xl font-bold text-[#219ebc]">ECommerce<span
                                class="text-[#ffb703]">Zyy</span> </span>
                    </a>
                </div>
                <!-- Desktop Menu -->
                <div class="hidden lg:flex space-x-8 items-center">
                    <a href="/" class="text-gray-700 hover:text-blue-600 font-semibold">Home</a>
                    <a href="/marketplace" class="text-gray-700 hover:text-blue-600 font-semibold">Marketplace</a>
                    <a href="{{ route('docs') }}" class="text-gray-700 hover:text-blue-600 font-semibold">Docs</a>
                </div>
                <!-- Login button -->
                <div class="hidden lg:flex">
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 rounded-md bg-[#219ebc] text-white font-semibold hover:bg-blue-700">
                        Log in
                    </a>
                </div>
                <!-- Mobile menu button -->
                <div class="lg:hidden flex items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-white hover:bg-[#219ebc] focus:outline-none">
                        <span class="sr-only">Open main menu</span>
                        <svg x-show="!mobileMenuOpen" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg x-show="mobileMenuOpen" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" x-transition class="lg:hidden bg-white border-t border-gray-200 shadow-md"
            style="display: none;">
            <div class="p-4 space-y-4">
                <a href="/" class="block text-gray-700 hover:text-blue-600 font-semibold">Home</a>
                <a href="/marketplace" class="block text-gray-700 hover:text-blue-600 font-semibold">Marketplace</a>
                <a href="{{ route('docs') }}" class="block text-gray-700 hover:text-blue-600 font-semibold">Docs</a>
                <a href="{{ route('login') }}"
                    class="block text-white bg-blue-600 px-4 py-2 rounded-md font-semibold text-center hover:bg-blue-700">
                    Log in
                </a>
            </div>
        </div>
    </nav>
@endauth
