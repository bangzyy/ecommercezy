@extends('admin.layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-6 text-blue-700">Edit Product</h1>

    <form id="editProductForm" action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Product Name --}}
        <div class="mb-4">
            <label for="product_name" class="block font-medium mb-1">Product Name</label>
            <input type="text" name="product_name" id="product_name" value="{{ old('product_name', $product->product_name) }}"
                class="w-full border border-gray-300 p-2 rounded @error('product_name') border-red-500 @enderror" />
            @error('product_name')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        {{-- Category --}}
        <div class="mb-4">
            <label for="category_id" class="block font-medium mb-1">Category</label>
            <select name="category_id" id="category_id"
                class="w-full border border-gray-300 p-2 rounded @error('category_id') border-red-500 @enderror">
                <option value="">-- Select Category --</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                    {{ $category->category_name }}
                </option>
                @endforeach
            </select>
            @error('category_id')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        {{-- Price --}}
        <div class="mb-4">
            <label for="price" class="block font-medium mb-1">Price</label>
            <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}"
                class="w-full border border-gray-300 p-2 rounded @error('price') border-red-500 @enderror" step="0.01" min="0" />
            @error('price')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        {{-- Description --}}
        <div class="mb-4">
            <label for="description" class="block font-medium mb-1">Description</label>
            <textarea name="description" id="description" rows="4"
                class="w-full border border-gray-300 p-2 rounded @error('description') border-red-500 @enderror">{{ old('description', $product->description) }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        {{-- Image --}}
        <div class="mb-4">
            <label for="image" class="block font-medium mb-1">Image</label>
            @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}" class="w-24 h-24 object-cover rounded mb-2" />
            @endif
            <input type="file" name="image" id="image" accept="image/*" class="w-full border p-2 rounded @error('image') border-red-500 @enderror" />
            @error('image')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        {{-- Product Colors --}}
        <div class="mb-4">
            <label class="block font-medium mb-2">Product Colors</label>
            <div id="colorInputs" class="space-y-2">
                @foreach($product->colors as $color)
                <div class="flex items-center gap-2 color-row" data-color-id="{{ $color->id }}">
                    <input type="text" name="existing_colors[{{ $color->id }}]" value="{{ $color->color }}"
                        class="flex-1 border border-gray-300 p-2 rounded">
                    <button type="button" onclick="removeExistingColor({{ $color->id }})"
                        class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm">x</button>
                </div>
                @endforeach
            </div>
            <button type="button" onclick="addColorInput()"
                class="mt-2 px-3 py-1 bg-indigo-600 text-white text-sm rounded hover:bg-indigo-700">+ Add Color</button>
        </div>

        {{-- Buttons --}}
        <div class="pt-4 flex items-center">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Update</button>
            <a href="{{ route('products.index') }}" class="ml-4 text-gray-600 hover:underline">Cancel</a>
        </div>
    </form>
</div>

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function addColorInput() {
        const container = document.getElementById('colorInputs');
        const div = document.createElement('div');
        div.className = 'flex items-center gap-2';
        div.innerHTML = `
            <input type="text" name="colors[]" placeholder="New Color" class="flex-1 border border-gray-300 p-2 rounded" />
            <button type="button" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm" onclick="this.parentElement.remove()">x</button>
        `;
        container.appendChild(div);
    }

    function removeExistingColor(id) {
        Swal.fire({
            title: 'Delete this color?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#ccc',
            confirmButtonText: 'Yes, delete'
        }).then((result) => {
            if (result.isConfirmed) {
                const row = document.querySelector(`.color-row[data-color-id="${id}"]`);
                if (row) {
                    row.remove();

                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'deleted_colors[]';
                    input.value = id;
                    document.getElementById('editProductForm').appendChild(input);
                }
            }
        });
    }
</script>
@endsection
