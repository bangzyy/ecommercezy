@extends('admin.layouts.app')
@section('title', 'Edit Category')
@section('content')
<h1 class="text-2xl font-semibold mb-4">Edit Category</h1>
<form action="{{ route('categories.update', $category) }}" method="POST"
    class="max-w-md bg-white p-6 rounded shadow" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    {{-- Category Name --}}
    <label for="category_name" class="block mb-1 font-medium">Category Name</label>
    <input type="text" name="category_name" id="category_name"
        value="{{ old('category_name', $category->category_name) }}"
        class="w-full border border-gray-300 p-2 rounded mb-4 @error('category_name') border-red-500 @enderror" />
    @error('category_name')
        <p class="text-red-500 text-sm mb-4">{{ $message }}</p>
    @enderror
    {{-- Description --}}
    <label for="description" class="block mb-1 font-medium">Description</label>
    <textarea name="description" id="description" rows="4"
        class="w-full border border-gray-300 p-2 rounded mb-4 @error('description') border-red-500 @enderror">{{ old('description', $category->description) }}</textarea>
    @error('description')
        <p class="text-red-500 text-sm mb-4">{{ $message }}</p>
    @enderror
    {{-- Image Upload --}}
    <label for="image" class="block mb-1 font-medium">Image</label>
    <input type="file" name="image" id="image" accept="image/*" class="mb-4" />
    @error('image')
        <p class="text-red-500 text-sm mb-4">{{ $message }}</p>
    @enderror
    {{-- Preview Existing Image --}}
    @if ($category->image)
        <div class="mb-4">
            <p class="text-sm text-gray-600 mb-1">Gambar Saat Ini:</p>
            <img src="{{ asset('storage/' . $category->image) }}" alt="Category Image"
                class="w-32 h-32 object-cover rounded border">
        </div>
    @endif
    {{-- Buttons --}}
    <button type="submit"
        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Update</button>
    <a href="{{ route('categories.index') }}" class="ml-4 text-gray-600 hover:underline">Cancel</a>
</form>
@endsection
