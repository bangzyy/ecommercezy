@extends('admin.layouts.app')
@section('title', 'Categories')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-semibold">Categories</h1>
    <div class="flex items-center space-x-4">
        <form method="GET" action="{{ route('categories.index') }}">
            <label for="sort" class="mr-2 font-medium text-gray-700">Sort by:</label>
            <select name="sort" id="sort" onchange="this.form.submit()" class="border border-gray-300 rounded px-2 py-1">
                <option value="new" {{ (request('sort') == 'new' || !request('sort')) ? 'selected' : '' }}>Newest</option>
                <option value="old" {{ request('sort') == 'old' ? 'selected' : '' }}>Oldest</option>
            </select>
        </form>
        <a href="{{ route('categories.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Add Category</a>
    </div>
</div>
@if ($categories->count())
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($categories as $category)
            <div class="bg-white rounded-lg shadow hover:shadow-md transition overflow-hidden">
                {{-- Gambar kategori --}}
                @if ($category->image)
                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->category_name }}"
                        class="w-full h-40 object-cover">
                @else
                    <div class="w-full h-40 flex items-center justify-center bg-gray-200 text-gray-500">
                        <i class="fas fa-image text-3xl"></i>
                    </div>
                @endif
                <div class="p-4">
                    <h2 class="text-lg font-semibold text-gray-800 mb-2">{{ $category->category_name }}</h2>
                    <div class="flex justify-between items-center">
                        <a href="{{ route('categories.edit', $category) }}" class="text-blue-600 hover:underline text-sm">Edit</a>
                        <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Delete this category?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline text-sm">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="bg-yellow-100 text-yellow-800 px-4 py-3 rounded mt-4 text-center">No categories found.</div>
@endif
<div class="mt-6">
    {{ $categories->withQueryString()->links() }}
</div>
@endsection
