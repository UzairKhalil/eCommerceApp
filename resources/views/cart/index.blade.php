@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold mb-8">Shopping Cart</h1>

    @if(count($cartItems) > 0)
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Cart Items -->
        <div class="lg:col-span-2">
            @foreach($cartItems as $item)
            <div class="bg-white rounded-lg shadow-md p-6 mb-4">
                <div class="flex gap-4">
                    <div class="w-24 h-24 bg-gray-200 rounded flex items-center justify-center">
                        <span class="text-gray-500 text-xs">Image</span>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold">
                            {{ isset($item->product) ? $item->product->name : $item->name }}
                        </h3>
                        @if(isset($item->name) && !isset($item->product))
                        <p class="text-sm text-gray-600">{{ $item->name }}</p>
                        @endif
                        <p class="text-blue-600 font-bold text-xl mt-2">
                            ${{ number_format(isset($item->retail_price) ? $item->retail_price : 0, 2) }}
                        </p>
                        
                        <div class="flex items-center gap-4 mt-4">
                            <form action="{{ route('cart.update', $item->cartKey) }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" 
                                       class="border border-gray-300 rounded px-2 py-1 w-20">
                                <button type="submit" class="text-blue-600 hover:text-blue-800">Update</button>
                            </form>
                            
                            <form action="{{ route('cart.remove', $item->cartKey) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">Remove</button>
                            </form>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-xl font-bold">
                            ${{ number_format((isset($item->retail_price) ? $item->retail_price : 0) * $item->quantity, 2) }}
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Order Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                <h2 class="text-2xl font-bold mb-4">Order Summary</h2>
                <div class="space-y-2 mb-4">
                    <div class="flex justify-between">
                        <span>Subtotal:</span>
                        <span>${{ number_format($total, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Shipping:</span>
                        <span>$10.00</span>
                    </div>
                    <div class="flex justify-between border-t pt-2">
                        <span class="font-bold">Total:</span>
                        <span class="font-bold text-xl">${{ number_format($total + 10, 2) }}</span>
                    </div>
                </div>
                <a href="{{ route('checkout') }}" 
                   class="block w-full bg-blue-600 text-white text-center px-6 py-3 rounded-lg font-semibold hover:bg-blue-700">
                    Proceed to Checkout
                </a>
                <a href="{{ route('products.index') }}" 
                   class="block w-full text-center mt-2 text-blue-600 hover:underline">
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
    @else
    <div class="text-center py-12">
        <p class="text-gray-500 text-xl mb-4">Your cart is empty</p>
        <a href="{{ route('products.index') }}" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
            Continue Shopping
        </a>
    </div>
    @endif
</div>
@endsection

