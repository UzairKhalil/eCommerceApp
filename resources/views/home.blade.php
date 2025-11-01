@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg shadow-xl p-12 mb-12 text-white">
        <h1 class="text-4xl font-bold mb-4">Welcome to Our Store</h1>
        <p class="text-xl mb-8">Discover amazing products at great prices</p>
        <a href="{{ route('products.index') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
            Shop Now
        </a>
    </div>

    <!-- Categories -->
    @if($categories->count() > 0)
    <div class="mb-12">
        <h2 class="text-3xl font-bold mb-6">Shop by Category</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($categories as $category)
            <a href="{{ route('products.index', ['category' => $category->id]) }}" 
               class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition block">
                <h3 class="text-xl font-semibold mb-2">{{ $category->name }}</h3>
                <p class="text-gray-600">{{ $category->description }}</p>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Featured Products -->
    @if($featuredProducts->count() > 0)
    <div>
        <h2 class="text-3xl font-bold mb-6">Featured Products</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($featuredProducts as $product)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                <div class="h-48 bg-gray-200 flex items-center justify-center">
                    <span class="text-gray-500">No Image</span>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-lg mb-2">{{ $product->name }}</h3>
                    <p class="text-gray-600 text-sm mb-3">{{ $product->short_description }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-2xl font-bold text-blue-600">${{ number_format($product->retail_price, 2) }}</span>
                        <a href="{{ route('products.show', $product->slug) }}" 
                           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            View
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- No Products Message -->
    @if($featuredProducts->count() == 0)
    <div class="text-center py-12">
        <p class="text-gray-500 text-lg">No products available yet.</p>
    </div>
    @endif
</div>
@endsection

