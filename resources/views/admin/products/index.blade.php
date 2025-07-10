@extends('admin.layouts.app')
@section('title', 'Products')
@section('content')
<div class="flex flex-col sm:flex-row justify-between items-center mb-6">
    <h1 class="text-3xl font-bold mb-4 sm:mb-0">Products</h1>
    <a href="{{ route('products.create') }}" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Add Product
    </a>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse ($products as $product)
        <div class="bg-white rounded-xl shadow p-4 flex flex-col">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}" class="w-full h-48 object-cover rounded-lg mb-3" />
            @else
                <div class="w-full h-48 bg-gray-200 rounded-lg flex items-center justify-center text-gray-500">No Image</div>
            @endif
            <h2 class="font-bold text-lg mb-1">{{ $product->product_name }}</h2>
            <p class="text-sm text-gray-500 mb-1">Kategori: {{ $product->category->category_name ?? 'N/A' }}</p>
            <p class="text-blue-600 font-semibold mb-2">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            <p class="text-gray-600 text-sm mb-3">{{ Str::limit($product->description, 50) }}</p>
            {{-- Warna --}}
            @if($product->colors->count())
                <p class="text-sm font-medium mb-1">Warna Tersedia:</p>
                <div class="flex flex-wrap gap-1 mb-3">
                    @foreach ($product->colors as $color)
                        <span class="px-2 py-1 text-xs bg-gray-200 rounded">{{ $color->color }}</span>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-400 mb-3">Tidak ada warna.</p>
            @endif
            <div class="flex gap-2 mt-auto">
                <a href="{{ route('products.edit', $product) }}" class="flex-1 text-white bg-yellow-500 hover:bg-yellow-600 px-3 py-1 rounded-lg text-center text-sm transition">Edit</a>
                <form action="{{ route('products.destroy', $product) }}" method="POST" class="flex-1" onsubmit="return false;">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="w-full text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded-lg text-sm transition btn-delete">Delete</button>
                </form>
            </div>
        </div>
    @empty
        <div class="col-span-3 text-center text-gray-500">Tidak ada produk ditemukan.</div>
    @endforelse
</div>
<div class="mt-6">
    {{ $products->links() }}
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('form');
            Swal.fire({
                title: 'Yakin hapus produk ini?',
                text: "Produk akan dihapus permanen.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3342f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    @if (session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        timer: 2000,
        showConfirmButton: false
    });
    @endif
</script>
@endsection
