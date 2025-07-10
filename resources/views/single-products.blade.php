<x-layout>
    @section('content')
        <style>
            .product-image {
                transition: transform 0.3s ease;
            }
            .product-image:hover {
                transform: scale(1.03);
            }
            .rating-star {
                font-size: 1.2rem;
            }
            .price-tag {
                position: relative;
                display: inline-block;
                padding: 0.5rem 1rem;
                background: linear-gradient(135deg, #3b82f6, #1d4ed8);
                color: white;
                border-radius: 0.5rem;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            }
          .price-tag::after {
                content: "";
                position: absolute;
                left: 50%;
                bottom: -10px;
                transform: translateX(-50%) rotate(45deg);
                width: 20px;
                height: 20px;
                background: linear-gradient(135deg, #3b82f6, #1d4ed8);
                z-index: -1;
            }
            @keyframes fade-in {
                from {
                    opacity: 0;
                    transform: scale(0.95);
                }
                to {
                    opacity: 1;
                    transform: scale(1);
                }
            }
            .animate-fade-in {
                animation: fade-in 0.3s ease-out;
            }
        </style>
        <div class="min-h-screen bg-gray-50">
            <div class="py-8 pt-16 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8" data-aos="fade-up">
                @if (session('success'))
                    <div x-data="{ show: true }" x-show="show" x-transition:leave="transition ease-in duration-300"
                        class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm relative"
                        role="alert">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="font-medium">Berhasil!</p>
                                <p class="text-sm">{{ session('success') }}</p>
                            </div>
                            <button @click="show = false"
                                class="ml-auto bg-green-100 text-green-500 rounded-lg p-1.5 hover:bg-green-200">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                @endif
                <a href="/dashboard"
                    class="inline-flex items-center text-blue-600 hover:text-blue-800 mb-8 transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    <span>Back to Shopping</span>
                </a>
                {{-- Product Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 mb-12">
                    {{-- Image --}}
                    <div>
                        <div class="overflow-hidden rounded-2xl bg-gray-100 shadow-lg product-image">
                            @if ($product->image)
                                <img id="mainProductImage" src="{{ asset('storage/' . $product->image) }}"
                                    alt="{{ $product->product_name }}"
                                    class="object-contain w-full h-[400px] bg-white p-4 md:p-8 rounded-2xl transition duration-300">
                            @else
                                <div
                                    class="w-full h-[400px] flex items-center justify-center bg-gradient-to-br from-gray-200 to-gray-300 text-gray-500">
                                    <i class="fas fa-image text-4xl opacity-50"></i>
                                </div>
                            @endif
                        </div>
                        {{-- Gallery Thumbnails --}}
                        @if ($product->images->count())
                            <div class="mt-4 flex space-x-3 overflow-x-auto">
                                @foreach ($product->images as $gallery)
                                    <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="Gallery Image"
                                        onclick="changeMainImage('{{ asset('storage/' . $gallery->image_path) }}')"
                                        class="w-24 h-24 object-cover rounded-lg border cursor-pointer transition duration-300 hover:scale-105">
                                @endforeach
                            </div>
                        @endif
                    </div>
                    {{-- Details --}}
                    <div class="space-y-6">
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 leading-tight">{{ $product->product_name }}
                        </h1>
                        @php $averageRating = $product->reviews->avg('rating') ?? 0; @endphp
                        <div class="flex items-center">
                            <div class="flex">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= round($averageRating))
                                        <i class="fas fa-star text-yellow-400 rating-star"></i>
                                    @else
                                        <i class="fas fa-star text-gray-300 rating-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="ml-2 text-gray-600">{{ number_format($averageRating, 1) }}
                                ({{ $product->reviews->count() }} reviews)</span>
                        </div>
                        <div class="flex items-center">
                            <span
                                class="price-tag text-xl font-bold">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                            <span class="ml-3 text-sm text-gray-500">+ Free Shipping</span>
                        </div>
                        <div class="prose max-w-none text-gray-700">
                            <p class="text-lg leading-relaxed">{{ $product->description ?? 'Tidak ada deskripsi produk.' }}
                            </p>
                        </div>
                        <div class="flex flex-wrap items-center gap-14 pt-2">
                            <form action="{{ route('add.to.cart', $product->id) }}" method="POST">
                                @csrf
                                @if ($product->colors->count())
                                    <div class="mb-4">
                                        <label for="color" class="block text-sm font-medium text-gray-700">Pilih
                                            Warna</label>
                                        <select name="color" id="color"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2  mt-1 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                            required>
                                            <option value="">-- Pilih Warna --</option>
                                            @foreach ($product->colors as $color)
                                                <option value="{{ $color->color }}">{{ $color->color }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden gap-2">
                                    <button type="button" onclick="decrementQuantity()"
                                        class="px-3 py-1 bg-gray-200 hover:bg-gray-300">-</button>
                                    <input type="number" name="quantity" id="quantity" value="1" min="1"
                                        class="w-16 text-center border-0 focus:ring-0" required>
                                    <button type="button" onclick="incrementQuantity()"
                                        class="px-3 py-1 bg-gray-200 hover:bg-gray-300">+</button>
                                </div>

                                <button type="submit"
                                    class="flex items-center justify-center px-6 py-3 mt-4 bg-gradient-to-r from-green-500 to-green-600 text-white font-medium rounded-lg shadow-md hover:from-green-600 hover:to-green-700 transition duration-300 transform hover:-translate-y-1">
                                    <i class="fas fa-shopping-cart mr-2"></i> Add to Cart
                                </button>
                            </form>
                        </div>

                        <div class="mt-8 border-t border-gray-200 pt-6 grid grid-cols-2 gap-4">
                            <div class="flex items-center"><i class="fas fa-shield-alt text-gray-500 mr-3"></i><span
                                    class="text-gray-600">1 Year Warranty</span></div>
                            <div class="flex items-center"><i class="fas fa-undo-alt text-gray-500 mr-3"></i><span
                                    class="text-gray-600">7-Day Returns</span></div>
                            <div class="flex items-center"><i class="fas fa-headset text-gray-500 mr-3"></i><span
                                    class="text-gray-600">24/7 Support</span></div>
                        </div>
                    </div>
                </div>

                {{-- Reviews Section --}}
                <div class="max-w-4xl mx-auto mt-16 bg-white p-6 rounded-xl shadow">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Customer Reviews</h2>

                    @if ($product->reviews->count())
                        <div class="space-y-6">
                            @foreach ($product->reviews as $review)
                                <div class="p-4 border border-gray-200 rounded-lg shadow-sm">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <i class="fas fa-user-circle text-gray-400 text-2xl"></i>
                                            <div>
                                                <p class="font-semibold text-gray-800">
                                                    {{ $review->user->name ?? 'Anonim' }}</p>
                                                <div class="flex space-x-1">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $review->rating)
                                                            <i class="fas fa-star text-yellow-400 text-sm"></i>
                                                        @else
                                                            <i class="fas fa-star text-gray-300 text-sm"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                        <span
                                            class="text-gray-500 text-sm">{{ $review->created_at->format('d M Y') }}</span>
                                    </div>
                                    <p class="mt-3 text-gray-700">{{ $review->review }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-600">Nothing Reviews For This Product.</p>
                    @endif
                </div>

            </div>
        </div>

        <script>
            function incrementQuantity() {
                let qtyInput = document.getElementById('quantity');
                qtyInput.value = parseInt(qtyInput.value) + 1;
            }

            function decrementQuantity() {
                let qtyInput = document.getElementById('quantity');
                if (qtyInput.value > 1) {
                    qtyInput.value = parseInt(qtyInput.value) - 1;
                }
            }

            function changeMainImage(imageSrc) {
                const mainImage = document.getElementById('mainProductImage');
                mainImage.src = imageSrc;
                mainImage.classList.add('animate-fade-in');
                setTimeout(() => mainImage.classList.remove('animate-fade-in'), 300);
            }
        </script>
    @endsection
</x-layout>
