@extends('admin.layouts.app')
@section('title', 'Add Product')
@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 rounded-2xl shadow-lg">
    <h1 class="text-3xl font-bold mb-8 text-gray-800 text-center">Add New Product</h1>
    <form id="createProductForm" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <!-- Product Name -->
        <div class="flex flex-col">
            <label for="product_name" class="mb-2 text-sm font-semibold text-gray-700">Product Name</label>
            <input type="text" name="product_name" id="product_name" value="{{ old('product_name') }}"
                class="block w-full rounded-lg border-gray-300 px-4 py-2 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('product_name') border-red-500 @enderror" />
            @error('product_name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <!-- Price -->
        <div class="flex flex-col">
            <label for="price" class="mb-2 text-sm font-semibold text-gray-700">Price</label>
            <input type="number" step="0.01" name="price" id="price" value="{{ old('price') }}"
                class="block w-full rounded-lg border-gray-300 px-4 py-2 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('price') border-red-500 @enderror" />
            @error('price')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <!-- Category -->
        <div class="flex flex-col">
            <label for="category_id" class="mb-2 text-sm font-semibold text-gray-700">Category</label>
            <select name="category_id" id="category_id"
                class="block w-full rounded-lg border-gray-300 px-4 py-2 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('category_id') border-red-500 @enderror">
                <option value="">-- Select Category --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->category_name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <!-- Description -->
        <div class="flex flex-col">
            <label for="description" class="mb-2 text-sm font-semibold text-gray-700">Description</label>
            <textarea name="description" id="description" rows="4"
                class="block w-full rounded-lg border-gray-300 px-4 py-2 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
            @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
<!-- Product Colors -->
<div class="flex flex-col">
    <label for="colors" class="mb-2 text-sm font-semibold text-gray-700">Product Colors</label>

    <div id="colorInputs" class="space-y-2">
        <input type="text" name="colors[]" placeholder="e.g. Merah"
            class="block w-full rounded-lg border-gray-300 px-4 py-2 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
    </div>
    <button type="button" onclick="addColorInput()"
        class="mt-2 inline-flex items-center px-3 py-1.5 bg-indigo-100 text-indigo-700 rounded-lg text-sm hover:bg-indigo-200 transition">
        <i class="fas fa-plus mr-2"></i> Add Color
    </button>
    @error('colors')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
        <!-- Image Upload -->
        <div class="flex flex-col">
            <label for="image" class="mb-2 text-sm font-semibold text-gray-700">Product Image</label>
            <input type="file" name="image" id="image" accept="image/*"
                class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                onchange="previewImage(event)" />
            @error('image')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
            <!-- Image Preview -->
            <div class="mt-4 flex justify-center">
                <img id="imagePreview" src="#" alt="Image Preview" class="hidden max-w-xs h-48 object-cover rounded-lg border border-gray-300" />
            </div>
        </div>
                  <!-- Product Gallery Images -->
<div class="flex flex-col">
    <label for="images" class="mb-2 text-sm font-semibold text-gray-700">Product Gallery Images</label>
    <input type="file" name="images[]" id="images" accept="image/*" multiple
        class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
    @error('images')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
        <!-- Buttons -->
        <div class="flex justify-between items-center pt-6">
            <button type="button" id="saveButton"
                class="inline-flex justify-center items-center rounded-lg bg-indigo-600 px-6 py-2 text-white text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-300">
                Save Product
            </button>
            <a href="{{ route('products.index') }}" class="text-sm text-gray-600 hover:underline transition-all duration-300">Cancel</a>
        </div>
    </form>
</div>
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('imagePreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                preview.classList.add('animate-fade-in');
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '#';
            preview.classList.add('hidden');
        }
    }
    function addColorInput() {
        const colorInputs = document.getElementById('colorInputs');
        const newInput = document.createElement('input');
        newInput.type = 'text';
        newInput.name = 'colors[]';
        newInput.placeholder = 'e.g. Biru';
        newInput.className = 'block w-full rounded-lg border-gray-300 px-4 py-2 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50';
        colorInputs.appendChild(newInput);
    }
    document.getElementById('saveButton').addEventListener('click', function () {
        Swal.fire({
            title: 'Save Product?',
            text: "Make sure all product data is correct.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#4F46E5',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Save!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('createProductForm').submit();
            }
        });
    });
</script>

<style>
    @keyframes fade-in {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }

    .animate-fade-in {
        animation: fade-in 0.3s ease-out;
    }
</style>
@endsection
