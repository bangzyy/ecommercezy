<x-layout>
    @section('content')
    <div class="max-w-4xl mx-auto px-4 p-16">
        <h1 class="text-3xl font-semibold mb-6">Hasil Pencarian: <span class="text-indigo-600">"{{ $query }}"</span></h1>
        @if ($products->isEmpty())
            <p class="text-gray-600 text-lg">Produk tidak ditemukan.</p>
        @else
            <ul class="space-y-4">
                @foreach ($products as $product)
                    <li class="border rounded-lg p-4 hover:shadow-lg transition-shadow bg-white">
                        <div class="flex items-center space-x-4">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}" class="w-20 h-20 object-cover rounded-md">
                            @else
                                <div class="w-20 h-20 bg-gray-200 rounded-md flex items-center justify-center text-gray-400">
                                    No Image
                                </div>
                            @endif
                            <a href="{{ route('single.products', $product->id) }}">
                            <div>
                                <h2 class="text-xl font-bold text-gray-800">{{ $product->product_name }}</h2>
                                <p class="text-indigo-600 font-semibold mt-1">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                <p class="text-sm text-gray-500 mt-1">Kategori: {{ $product->category->category_name ?? 'Tidak ada kategori' }}</p>
                                <p class="text-gray-700 mt-2 line-clamp-2">{{ $product->description }}</p>
                            </div>
                            </a>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif

        <div class="mt-8">
            <a href="{{ route('dashboard') }}" class="inline-block bg-indigo-600 text-white px-5 py-2 rounded-md hover:bg-indigo-700 transition">&laquo; Kembali</a>
        </div>
    </div>
    @endsection
</x-layout>
