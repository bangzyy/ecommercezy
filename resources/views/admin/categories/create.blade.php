@extends('admin.layouts.app')
@section('title', 'Add Category')
@section('content')
<div class="max-w-md mx-auto bg-white shadow-md rounded-lg p-8 border border-gray-200">
    <h1 class="text-2xl font-semibold text-gray-800 mb-8">Create Category</h1>
    <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        {{-- Nama Kategori --}}
        <div>
            <label for="category_name" class="block text-sm font-medium text-gray-700 mb-1">Category Name</label>
            <input
                type="text"
                name="category_name"
                id="category_name"
                value="{{ old('category_name') }}"
                placeholder="Category name"
                class="block w-full rounded-md border border-gray-300 px-4 py-2 text-gray-900 placeholder-gray-400
                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                    @error('category_name') border-red-500 @enderror"
                autocomplete="off"
                autofocus
            />
            @error('category_name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        {{-- Deskripsi --}}
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea
                name="description"
                id="description"
                rows="4"
                placeholder="Write a brief description"
                class="block w-full rounded-md border border-gray-300 px-4 py-2 text-gray-900 placeholder-gray-400
                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                    @error('description') border-red-500 @enderror"
            >{{ old('description') }}</textarea>
            @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        {{-- Upload Gambar --}}
        <div>
            <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Image</label>
            <input
                type="file"
                name="image"
                id="image"
                accept="image/*"
                class="block w-full text-gray-700 cursor-pointer rounded-md
                    focus:outline-none focus:ring-2 focus:ring-blue-500"
                onchange="previewImage(event)"
            />
            @error('image')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
            <div class="mt-4">
                <img
                    id="imagePreview"
                    src="#"
                    alt="Image preview"
                    class="hidden rounded-md border border-gray-300 max-h-52 object-contain w-full"
                />
            </div>
        </div>
        {{-- Buttons --}}
        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
            <a href="{{ route('categories.index') }}" class="text-blue-600 font-semibold hover:underline">Cancel</a>
            <button
                type="submit"
                class="inline-flex items-center px-6 py-2 bg-blue-600 text-white font-semibold rounded-md
                    hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
                Save
            </button>
        </div>
    </form>
</div>
<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('imagePreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '#';
            preview.classList.add('hidden');
        }
    }
</script>
@endsection
