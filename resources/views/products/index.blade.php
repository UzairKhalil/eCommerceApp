@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">All Products</h1>
        
        <!-- Search Form -->
        <form method="GET" action="{{ route('products.index') }}" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Search products..." 
                   class="border border-gray-300 rounded-md px-4 py-2">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                Search
            </button>
        </form>
    </div>

    <!-- Products Grid -->
    @if($products->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($products as $product)
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
            <div class="h-48 bg-gray-200 flex items-center justify-center">
                <span class="text-gray-500">No Image</span>
            </div>
            <div class="p-4">
                <div class="mb-2">
                    <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">{{ $product->category->name }}</span>
                </div>
                <h3 class="font-semibold text-lg mb-2">{{ $product->name }}</h3>
                <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $product->short_description }}</p>
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

    <!-- Pagination -->
    <div class="mt-8">
        {{ $products->links() }}
    </div>
    @else
    <div class="text-center py-12">
        <p class="text-gray-500 text-lg">No products found.</p>
        <a href="{{ route('products.index') }}" class="mt-4 inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
            View All Products
        </a>
    </div>
    @endif
</div>
@endsection

