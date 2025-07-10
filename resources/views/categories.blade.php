<x-layout>
@section('content')
<title>Semua Kategori</title>
<div class="pt-16 px-4 md:px-6 lg:px-8 w-full space-y-8">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800">Semua Kategori</h1>
        <a href="{{ route('dashboard') }}" class="text-sm text-[#219ebc] hover:text-[#023047] flex items-center">
            <i class="fas fa-chevron-left mr-1 text-xs"></i> Kembali ke Dashboard
        </a>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
        @forelse ($categories as $category)
            <a href="{{ route('products.by.category', $category->id) }}"
               class="group border rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all flex flex-col items-center p-4 bg-white">
                <div class="w-24 h-24 rounded-full overflow-hidden bg-gray-100 mb-3 flex items-center justify-center transition-all group-hover:scale-110">
                    @if ($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->category_name }}"
                             class="w-full h-full object-cover group-hover:opacity-90">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-500">
                            <i class="fas fa-box-open text-3xl"></i>
                        </div>
                    @endif
                </div>
                <p class="text-center text-sm font-medium text-gray-700 group-hover:text-[#219ebc]">
                    {{ $category->category_name }}
                </p>
            </a>
        @empty
            <p class="text-gray-500 col-span-full text-center">Belum ada kategori tersedia.</p>
        @endforelse
    </div>
</div>
@endsection
</x-layout>
