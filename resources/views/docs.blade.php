<x-layout>
    @section('content')
    <div class="max-w-4xl mx-auto p-6 pt-20" data-aos="fade-up">
        <h1 class="text-4xl font-bold mb-6 text-center animate-fade-in">📄 ECommerceZyy Documentation</h1>

        <div class="space-y-4">
            {{-- Table of Contents --}}
            <div>
                <h2 class="text-2xl font-semibold mb-4">📚 Daftar Isi</h2>
                <ul class="list-disc list-inside space-y-2">
                    @foreach (['Dashboard', 'Cart', 'Checkout', 'Profile', 'Search Produk', 'Mobile Navigation', 'Authentication'] as $index => $title)
                    <li>
                        <a href="#{{ Str::slug($title) }}" class="text-blue-600 hover:underline transition-colors duration-300">{{ $index + 1 }}. {{ $title }}</a>
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Documentation Sections --}}
            @php
                $docs = [
                    [
                        'id' => 'dashboard',
                        'title' => 'Dashboard',
                        'url' => '/dashboard',
                        'content' => 'Halaman utama setelah pengguna login. Menampilkan informasi umum dan produk yang tersedia.',
                    ],
                    [
                        'id' => 'cart',
                        'title' => 'Cart',
                        'url' => '/cart',
                        'content' => 'Halaman keranjang yang menampilkan produk yang telah ditambahkan.',
                        'items' => ['Menampilkan daftar produk di keranjang', 'Menghapus produk dari keranjang', 'Melanjutkan ke proses checkout'],
                    ],
                    [
                        'id' => 'checkout',
                        'title' => 'Checkout',
                        'url' => '/success',
                        'content' => 'Halaman konfirmasi pembelian.',
                        'items' => ['Menampilkan detail produk yang dibeli', 'Menyelesaikan proses pembelian'],
                    ],
                    [
                        'id' => 'profile',
                        'title' => 'Profile',
                        'url' => '/user/profile',
                        'content' => 'Halaman profil pengguna yang sudah login.',
                        'items' => ['Melihat detail informasi pengguna', 'Logout dari sistem'],
                    ],
                    [
                        'id' => 'search-produk',
                        'title' => 'Search Produk',
                        'url' => '/product/search?query=nama_produk',
                        'content' => 'Fitur pencarian produk berdasarkan kata kunci.',
                        'items' => ['Mencari produk dengan nama tertentu', 'Menampilkan hasil pencarian sesuai kata kunci'],
                    ],
                    [
                        'id' => 'mobile-navigation',
                        'title' => 'Mobile Navigation',
                        'url' => null,
                        'content' => 'Menu navigasi otomatis menyesuaikan ke tampilan mobile dengan tombol hamburger. Fitur buka/tutup menu secara responsif.',
                    ],
                    [
                        'id' => 'authentication',
                        'title' => 'Authentication',
                        'url' => null,
                        'content' => 'Menu yang tersedia saat login dan saat belum login.',
                        'items' => [
                            'Saat login: Dashboard, Cart, Checkout, Profile',
                            'Saat belum login: Home, Marketplace, Docs, Login',
                            'Logout tersedia di dropdown profile dan mobile menu',
                        ],
                    ],
                ];
            @endphp

            @foreach ($docs as $doc)
            <div id="{{ $doc['id'] }}" class="mt-8 border rounded-lg shadow-md overflow-hidden">
                <button class="w-full text-left px-4 py-3 bg-gray-100 hover:bg-gray-200 font-semibold flex justify-between items-center transition-colors duration-300" onclick="toggleSection('{{ $doc['id'] }}-content')">
                    <span>{{ $loop->iteration }}. {{ $doc['title'] }}</span>
                    <svg id="{{ $doc['id'] }}-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="{{ $doc['id'] }}-content" class="max-h-0 overflow-hidden transition-all duration-500 ease-in-out">
                    <div class="p-4 space-y-2">
                        @if ($doc['url'])
                        <p><strong>URL:</strong> {{ $doc['url'] }}</p>
                        @endif
                        <p>{{ $doc['content'] }}</p>
                        @if (isset($doc['items']))
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($doc['items'] as $item)
                            <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach

            <div class="mt-8 p-4 bg-yellow-100 rounded-lg">
                <p class="font-semibold">🔒 Note:</p>
                <p>Beberapa fitur hanya dapat diakses setelah login. Pastikan Anda sudah terautentikasi sebelum mengakses halaman Dashboard, Cart, Checkout, dan Profile.</p>
            </div>
        </div>
    </div>

    <script>
        function toggleSection(id) {
            const content = document.getElementById(id);
            const icon = document.getElementById(id.replace('-content', '-icon'));
            if (content.style.maxHeight) {
                content.style.maxHeight = null;
                icon.classList.remove('rotate-180');
            } else {
                content.style.maxHeight = content.scrollHeight + 'px';
                icon.classList.add('rotate-180');
            }
        }
    </script>
    @endsection
</x-layout>
