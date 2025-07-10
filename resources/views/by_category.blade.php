<x-layout>
    <x-slot name="title">{{ $category->category_name }} - Products</x-slot>

    @section('content')
        <div class="pt-20 p-10" data-aos="fade-up">
            <div class="flex p-8 flex-col">
                <h1 class="text-2xl font-bold mb-6">Product By Category: {{ $category->category_name }}</h1>
                <div class="mt-6">
                    <a href="/dashboard" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">←
                        Kembali</a>
                </div>
            </div>
            @if ($products->count())
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach ($products as $product)
                        <div
                            class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition duration-300 flex flex-col">
                            <a href="{{ route('single.products', $product->id) }}"
                                class="w-full h-56 bg-gray-100 overflow-hidden block">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}"
                                        class="object-cover w-full h-full">
                                @else
                                    <div
                                        class="w-full h-full bg-gray-300 flex items-center justify-center text-gray-500 text-sm">
                                        No Image
                                    </div>
                                @endif
                            </a>

                            <div class="p-4 flex flex-col justify-between flex-1">
                                <div>
                                    <h4 class="font-semibold text-base text-gray-800 mb-1 line-clamp-2">
                                        {{ $product->product_name }}
                                    </h4>
                                    @php
                                        $averageRating = $product->reviews->avg('rating') ?? 0;
                                    @endphp

                                    <div class="flex items-center mt-2">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= round($averageRating))
                                                <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                    <path
                                                        d="M10 15l-5.878 3.09 1.122-6.545L.489 6.91l6.564-.955L10 0l2.947 5.955 6.564.955-4.755 4.635 1.122 6.545z" />
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4 text-gray-300 fill-current" viewBox="0 0 20 20">
                                                    <path
                                                        d="M10 15l-5.878 3.09 1.122-6.545L.489 6.91l6.564-.955L10 0l2.947 5.955 6.564.955-4.755 4.635 1.122 6.545z" />
                                                </svg>
                                            @endif
                                        @endfor
                                        <span
                                            class="text-sm text-gray-500 ml-2">({{ number_format($averageRating, 1) }})</span>
                                    </div>
                                    <p class="text-sm text-gray-600">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                                </div>

                                <div class="mt-4 flex space-x-2 justify-center">
                                    <form action="{{ route('add.to.cart', $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="w-full bg-green-600 hover:bg-green-800 text-white text-sm font-medium p-4 rounded-lg transition">
                                            Add to Cart
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-600">Belum ada produk di kategori ini.</p>
            @endif

        </div>
    @endsection
</x-layout>
