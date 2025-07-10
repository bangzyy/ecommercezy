<x-layout>
@section('content')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .category-scroll::-webkit-scrollbar {
            height: 6px;
        }
        .category-scroll::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        .category-scroll::-webkit-scrollbar-thumb {
            background: #219ebc;
            border-radius: 10px;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        .promo-slide {
            background: linear-gradient(135deg, #219ebc 0%, #023047 100%);
        }
        .rating-stars {
            display: inline-flex;
            position: relative;
        }
        .rating-stars .stars-empty {
            display: flex;
        }
        .rating-stars .stars-filled {
            display: flex;
            position: absolute;
            top: 0;
            left: 0;
            white-space: nowrap;
            overflow: hidden;
        }
    </style>
    <div class="pt-16 space-y-8 px-4 md:px-6 lg:px-8 w-fullmx-auto">
        <!-- Notifikasi Flash Message -->
        <div id="notif" class="fixed top-20 right-5 bg-green-500 text-white px-6 py-3 rounded-lg shadow-xl z-50 flex items-center space-x-2 transition-all duration-300 transform translate-x-0"
             style="display: none;">
            <i class="fas fa-check-circle"></i>
            <span id="notif-message"></span>
        </div>
        <!-- 1. Banner Promo Carousel -->
        <div x-data="{
            currentIndex: 0,
            promos: [
                { text: 'Mau transaksi lebih hemat? Cek promo asyik!', image: '/img/uniqlo.png' },
                { text: 'Diskon besar-besaran hanya hari ini!', image: '/img/gucci.png' },
                { text: 'Gratis Ongkir ke seluruh Indonesia!', image: '/img/rolex.png' },
                { text: 'Belanja makin seru dengan promo spesial!', image: '/img/h&m.png' }
            ],
            slideInterval: null,
            startAutoSlide() {
                this.slideInterval = setInterval(() => {
                    this.currentIndex = (this.currentIndex + 1) % this.promos.length;
                }, 5000);
            },
            stopAutoSlide() {
                clearInterval(this.slideInterval);
                this.slideInterval = null;
            }
        }" x-init="startAutoSlide()" class="relative w-full overflow-hidden rounded-2xl h-80 md:h-96 shadow-xl">
            <!-- Carousel Slide -->
            <div class="flex h-full transition-transform duration-700 ease-in-out"
                 :style="'transform: translateX(-' + (currentIndex * 100) + '%)'">
                <template x-for="(promo, index) in promos" :key="index">
                    <div class="w-full flex-shrink-0 flex items-center justify-center px-4 h-full promo-slide">
                        <div class="flex flex-col md:flex-row items-center justify-between max-w-6xl mx-auto px-6 w-full">
                            <div class="text-white md:w-1/2 mb-8 md:mb-0">
                                <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold mb-4" x-text="promo.text"></h2>
                                <p class="text-sm md:text-base mb-6">Temukan penawaran terbaik untuk kebutuhan belanja Anda</p>
                                <button class="bg-[#fb8500] hover:bg-[#e07600] text-white font-medium py-2 px-6 rounded-full transition-all transform hover:scale-105">
                                    Lihat Promo
                                </button>
                            </div>
                            <div class="md:w-1/2 flex justify-center">
                                <div class="w-48 h-48 md:w-64 md:h-64 bg-white bg-opacity-20 rounded-full flex items-center justify-center p-2">
                                    <img :src="promo.image" alt="Promo Image" class="w-70 h-full object-contain rounded-lg">
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
            <!-- Tombol Navigasi -->
            <button @click="currentIndex = (currentIndex - 1 + promos.length) % promos.length"
                    @mouseenter="stopAutoSlide()" @mouseleave="startAutoSlide()"
                    class="absolute left-4 top-1/2 -translate-y-1/2 bg-white bg-opacity-80 rounded-full p-3 shadow-lg hover:bg-opacity-100 z-20 transition-all hover:scale-110">
                <i class="fas fa-chevron-left text-gray-800"></i>
            </button>
            <button @click="currentIndex = (currentIndex + 1) % promos.length"
                    @mouseenter="stopAutoSlide()" @mouseleave="startAutoSlide()"
                    class="absolute right-4 top-1/2 -translate-y-1/2 bg-white bg-opacity-80 rounded-full p-3 shadow-lg hover:bg-opacity-100 z-20 transition-all hover:scale-110">
                <i class="fas fa-chevron-right text-gray-800"></i>
            </button>
            <!-- Indicator -->
            <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex space-x-2 z-20">
                <template x-for="(promo, index) in promos" :key="index">
                    <button @click="currentIndex = index"
                            :class="{
                                'w-3 h-3 rounded-full transition-all': true,
                                'bg-white bg-opacity-50': currentIndex !== index,
                                'bg-[#fb8500] w-6': currentIndex === index
                            }"
                            class="cursor-pointer"></button>
                </template>
            </div>
        </div>
        <!-- 2. Kategori Pilihan -->
        <div class="bg-white rounded-2xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-800">Kategori Pilihan</h2>
                <a href="{{ route('categories.main') }}" class="text-sm font-medium text-[#219ebc] hover:text-[#023047] flex items-center">
                    Lihat Semua<i class="fas fa-chevron-right ml-1 text-xs"></i>
                </a>
            </div>
            <div class="flex overflow-x-auto space-x-6 pb-4 category-scroll">
                @foreach ($categories as $category)
                    <div class="flex-shrink-0 w-24 text-center group">
                        <a href="{{ route('products.by.category', $category->id) }}" class="block">
                            <div class="w-20 h-20 rounded-full overflow-hidden bg-gray-100 mx-auto mb-3 flex items-center justify-center transition-all transform group-hover:scale-110">
                                @if ($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}"
                                         alt="{{ $category->category_name }}"
                                         class="w-full h-full object-cover group-hover:opacity-90">
                                @else
                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-500">
                                        <i class="fas fa-box-open text-2xl"></i>
                                    </div>
                                @endif
                            </div>
                            <p class="text-sm font-medium text-gray-700 group-hover:text-[#219ebc] transition-colors">
                                {{ $category->category_name }}
                            </p>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- 3. Produk Unggulan -->
        <div class="bg-white rounded-2xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-800">Produk Unggulan</h2>
                <a href="#" class="text-sm font-medium text-[#219ebc] hover:text-[#023047] flex items-center">
                    Lihat Semua <i class="fas fa-chevron-right ml-1 text-xs"></i>
                </a>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-10">
                @foreach ($products as $product)
                    <div class="bg-white rounded-xl overflow-hidden shadow-md product-card transition-all duration-300 flex flex-col h-full">


                        <!-- Gambar Produk -->
                        <a href="{{ route('single.products', $product->id) }}" class="w-full h-48 bg-gray-100 overflow-hidden block relative">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}"
                                     class="object-cover w-full h-full hover:opacity-90 transition-opacity">
                            @else
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-500">
                                    <i class="fas fa-image text-3xl"></i>
                                </div>
                            @endif
                            <!-- Quick View Button -->
                            <div class="absolute inset-0 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity bg-transparent bg-opacity-90">
                                <button class="bg-white text-[#219ebc] font-medium py-2 px-4 rounded-full text-sm">
                                    Quick View
                                </button>
                            </div>
                        </a>

                        <!-- Info Produk -->
                        <div class="p-4 flex flex-col justify-between flex-1">
                            <div>
                                <h4 class="font-semibold text-gray-800 mb-1 line-clamp-2 text-sm">
                                    <a href="{{ route('single.products', $product->id) }}" class="hover:text-[#219ebc] transition-colors">
                                        {{ $product->product_name }}
                                    </a>
                                </h4>

                                @php
                                    $averageRating = $product->reviews->avg('rating') ?? 0;
                                    $filledStars = round($averageRating);
                                @endphp

                                <div class="flex items-center mt-2 mb-3">
                                    <div class="rating-stars">
                                        <div class="stars-empty">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star text-gray-300 text-xs"></i>
                                            @endfor
                                        </div>
                                        <div class="stars-filled" style="width: {{ ($filledStars / 5) * 100 }}%">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star text-yellow-400 text-xs"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <span class="text-xs text-gray-500 ml-1">({{ number_format($averageRating, 1) }})</span>
                                </div>

                                <div class="flex items-center">
                                    <p class="text-lg font-bold text-[#219ebc]">
                                        Rp{{ number_format($product->price, 0, ',', '.') }}
                                    </p>
                                    <p class="text-xs text-gray-500 line-through ml-2">
                                        Rp{{ number_format($product->price * 1.15, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>

                            <!-- Tombol -->
                            <div class="mt-4">
                                <form action="{{ route('add.to.cart', $product->id) }}" method="POST">
    @csrf
    <input type="hidden" name="quantity" value="1">
    <button type="submit"
        class="w-full bg-[#219ebc] hover:bg-[#023047] text-white font-medium py-2 px-4 rounded-lg transition-all flex items-center justify-center space-x-2">
        <i class="fas fa-shopping-cart text-sm"></i>
        <span>Add to Cart</span>
    </button>
</form>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        // Flash message handling
        document.addEventListener('DOMContentLoaded', function() {
            const flashMessage = "{{ session('success') }}";
            if (flashMessage) {
                const notif = document.getElementById('notif');
                const notifMessage = document.getElementById('notif-message');

                notifMessage.textContent = flashMessage;
                notif.style.display = 'flex';

                setTimeout(() => {
                    notif.style.transform = 'translateX(150%)';
                    setTimeout(() => {
                        notif.style.display = 'none';
                    }, 300);
                }, 3000);
            }
        });
    </script>
    @endsection
</x-layout>
