<x-layout>
    <x-slot name="title">Marketplace - E-Commerce</x-slot>
    @section('content')
    <div class="container mx-auto pt-20 px-4" data-aos="fade-up">
    <h1 class="text-3xl font-semibold text-gray-900">Welcome to the Marketplace</h1>
    <p class="mt-4 text-gray-600">Explore Preview Product in Ecommerce<span class="text-amber-500">Zyy</span>.</p>

    <!-- Grid bagian atas: 6 produk + poster -->
    <div class="grid grid-cols-4 gap-6 mt-8">
        <!-- Produk 1 -->
        <div class="bg-white shadow-md rounded-lg p-4">
            <img src="{{ asset('img/kaos.jpg') }}" alt="Product 1" class="w-full h-auto object-cover rounded-md">
            <h3 class="text-xl font-semibold mt-4">Kaos Polos</h3>
            <p class="text-gray-600 mt-2">Rp. 50.000</p>
            <a href="#" class="mt-4 inline-block bg-amber-500 text-white px-4 py-2 rounded-md">Buy Now</a>
        </div>

        <!-- Produk 2 -->
        <div class="bg-white shadow-md rounded-lg p-4">
            <img src="{{ asset('img/nb.png') }}" alt="Product 2" class="w-full h-auto object-cover rounded-md">
            <h3 class="text-xl font-semibold mt-4">New Balance Shoes</h3>
            <p class="text-gray-600 mt-2">Rp. 670.000</p>
            <a href="#" class="mt-4 inline-block bg-amber-500 text-white px-4 py-2 rounded-md">Buy Now</a>
        </div>

        <!-- Poster -->
        <div class="row-span-3 bg-white shadow-md rounded-lg p-4 col-span-1">
            <img src="{{ asset('img/poster1.jpg') }}" alt="Poster" class="w-full h-full object-cover rounded-md">
        </div>

        <!-- Produk 3 -->
        <div class="bg-white shadow-md rounded-lg p-4">
            <img src="{{ asset('img/tws.png') }}" alt="Product 3" class="w-full h-auto object-cover rounded-md">
            <h3 class="text-xl font-semibold mt-4">Tws Gaming</h3>
            <p class="text-gray-600 mt-2">Rp. 400.000</p>
            <a href="#" class="mt-4 inline-block bg-amber-500 text-white px-4 py-2 rounded-md">Buy Now</a>
        </div>

        <!-- Produk 4 -->
        <div class="bg-white shadow-md rounded-lg p-4">
            <img src="{{ asset('img/coffe.jpg') }}" alt="Product 4" class="w-full h-auto object-cover rounded-md">
            <h3 class="text-xl font-semibold mt-4">Coffe Fire Ships</h3>
            <p class="text-gray-600 mt-2">Rp. 58.000</p>
            <a href="#" class="mt-4 inline-block bg-amber-500 text-white px-4 py-2 rounded-md">Buy Now</a>
        </div>

        <!-- Produk 5 -->
        <div class="bg-white shadow-md rounded-lg p-4">
            <img src="{{ asset('img/parfum.png') }}" alt="Product 5" class="w-full h-auto object-cover rounded-md">
            <h3 class="text-xl font-semibold mt-4">Product 5</h3>
            <p class="text-gray-600 mt-2">$30.00</p>
            <a href="#" class="mt-4 inline-block bg-amber-500 text-white px-4 py-2 rounded-md">Buy Now</a>
        </div>

        <!-- Produk 6 -->
        <div class="bg-white shadow-md rounded-lg p-4">
            <img src="{{ asset('img/rog.jpg') }}" alt="Product 6" class="w-full h-auto object-cover rounded-md">
            <h3 class="text-xl font-semibold mt-4">Product 6</h3>
            <p class="text-gray-600 mt-2">$32.00</p>
            <a href="#" class="mt-4 inline-block bg-amber-500 text-white px-4 py-2 rounded-md">Buy Now</a>
        </div>
    </div>

    <!-- Grid produk berikutnya: per 3 kolom -->
    <div class="grid grid-cols-3 gap-6 mt-8">
        <!-- Produk 7 -->
        <div class="bg-white shadow-md rounded-lg p-4">
            <img src="{{ asset('img/jam.JPG') }}" alt="Product 7" class="w-full h-60 object-cover rounded-md">
            <h3 class="text-xl font-semibold mt-4">Rolex | Jam Tangan</h3>
            <p class="text-gray-600 mt-2">Rp. 28.000.000</p>
            <a href="#" class="mt-4 inline-block bg-amber-500 text-white px-4 py-2 rounded-md">Buy Now</a>
        </div>

        <!-- Produk 8 -->
        <div class="bg-white shadow-md rounded-lg p-4">
            <img src="{{ asset('img/tas.jpg') }}" alt="Product 8" class="w-full h-60 object-cover rounded-md">
            <h3 class="text-xl font-semibold mt-4">Tas Gucci</h3>
            <p class="text-gray-600 mt-2">Rp. 26.000.000</p>
            <a href="#" class="mt-4 inline-block bg-amber-500 text-white px-4 py-2 rounded-md">Buy Now</a>
        </div>


    </div>
</div>

    @endsection
</x-layout>
