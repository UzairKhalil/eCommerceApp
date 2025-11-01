@extends('layouts.admin')

@section('content')
<div class="max-w-3xl">
    <h1 class="text-3xl font-bold mb-6">Create Product</h1>
    
    <form action="{{ route('admin.products.store') }}" method="POST" class="bg-white rounded-lg shadow-md p-6">
        @csrf
        
        <div class="mb-4">
            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
            <select name="category_id" id="category_id" required 
                    class="w-full border border-gray-300 rounded-md px-3 py-2">
                @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Product Name</label>
            <input type="text" name="name" id="name" required 
                   class="w-full border border-gray-300 rounded-md px-3 py-2"
                   value="{{ old('name') }}">
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
            <textarea name="description" id="description" rows="4" 
                      class="w-full border border-gray-300 rounded-md px-3 py-2">{{ old('description') }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label for="sku" class="block text-sm font-medium text-gray-700 mb-2">SKU</label>
                <input type="text" name="sku" id="sku" required 
                       class="w-full border border-gray-300 rounded-md px-3 py-2"
                       value="{{ old('sku') }}">
            </div>
            <div>
                <label for="stock_quantity" class="block text-sm font-medium text-gray-700 mb-2">Stock Quantity</label>
                <input type="number" name="stock_quantity" id="stock_quantity" required min="0"
                       class="w-full border border-gray-300 rounded-md px-3 py-2"
                       value="{{ old('stock_quantity', 0) }}">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label for="retail_price" class="block text-sm font-medium text-gray-700 mb-2">Retail Price</label>
                <input type="number" name="retail_price" id="retail_price" required step="0.01" min="0"
                       class="w-full border border-gray-300 rounded-md px-3 py-2"
                       value="{{ old('retail_price') }}">
            </div>
            <div>
                <label for="wholesale_price" class="block text-sm font-medium text-gray-700 mb-2">Wholesale Price</label>
                <input type="number" name="wholesale_price" id="wholesale_price" required step="0.01" min="0"
                       class="w-full border border-gray-300 rounded-md px-3 py-2"
                       value="{{ old('wholesale_price') }}">
            </div>
        </div>

        <div class="mb-6">
            <label class="flex items-center">
                <input type="checkbox" name="has_variations" value="1" 
                       class="rounded border-gray-300 text-blue-600">
                <span class="ml-2 text-sm text-gray-600">Has Variations</span>
            </label>
            <label class="flex items-center mt-2">
                <input type="checkbox" name="is_active" value="1" checked 
                       class="rounded border-gray-300 text-blue-600">
                <span class="ml-2 text-sm text-gray-600">Active</span>
            </label>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                Create Product
            </button>
            <a href="{{ route('admin.products.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection

