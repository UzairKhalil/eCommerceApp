@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="mb-4">
        <a href="{{ route('home') }}" class="text-blue-600 hover:underline">Home</a>
        <span class="mx-2">/</span>
        <a href="{{ route('products.index') }}" class="text-blue-600 hover:underline">Products</a>
        <span class="mx-2">/</span>
        <span class="text-gray-600">{{ $product->name }}</span>
    </nav>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Product Image -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="h-96 bg-gray-200 rounded-lg flex items-center justify-center">
                <span class="text-gray-500 text-xl">No Image</span>
            </div>
        </div>

        <!-- Product Details -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="mb-4">
                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded text-sm">{{ $product->category->name }}</span>
            </div>
            <h1 class="text-4xl font-bold mb-4">{{ $product->name }}</h1>
            <div class="flex items-center mb-4">
                <span class="text-3xl font-bold text-blue-600 mr-4">${{ number_format($product->retail_price, 2) }}</span>
                <span class="text-xl text-gray-500 line-through">${{ number_format($product->wholesale_price, 2) }}</span>
            </div>
            <p class="text-gray-700 mb-6">{{ $product->description }}</p>

            <!-- Variations -->
            @if($product->has_variations && $product->variations->count() > 0)
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Select Variation:</label>
                <select id="variation-select" class="block w-full border border-gray-300 rounded-md px-3 py-2">
                    <option value="">Choose a variation</option>
                    @foreach($product->variations as $variation)
                    <option value="{{ $variation->id }}" data-price="{{ $variation->retail_price }}">
                        {{ $variation->name }} - ${{ number_format($variation->retail_price, 2) }}
                    </option>
                    @endforeach
                </select>
            </div>
            @endif

            <!-- Stock Status -->
            @if($product->stock_quantity > 0)
            <div class="mb-6">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                    In Stock ({{ $product->stock_quantity }} available)
                </span>
            </div>
            @else
            <div class="mb-6">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                    Out of Stock
                </span>
            </div>
            @endif

            <!-- Add to Cart Form -->
            @if($product->stock_quantity > 0)
            <form action="{{ route('cart.add') }}" method="POST" class="flex gap-4">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="variation_id" id="selected-variation" value="">
                
                <div class="flex items-center gap-4">
                    <label for="quantity" class="text-sm font-medium text-gray-700">Quantity:</label>
                    <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock_quantity }}" 
                           class="border border-gray-300 rounded-md px-3 py-2 w-20">
                </div>
                
                <button type="submit" 
                        class="flex-1 bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                    Add to Cart
                </button>
            </form>
            @else
            <button disabled class="w-full bg-gray-400 text-white px-8 py-3 rounded-lg font-semibold cursor-not-allowed">
                Out of Stock
            </button>
            @endif
        </div>
    </div>

    <!-- Additional Information -->
    @if($product->description)
    <div class="mt-8 bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold mb-4">Description</h2>
        <p class="text-gray-700">{{ $product->description }}</p>
    </div>
    @endif
</div>

<script>
// Update variation when selected
document.getElementById('variation-select')?.addEventListener('change', function() {
    document.getElementById('selected-variation').value = this.value;
});
</script>
@endsection

