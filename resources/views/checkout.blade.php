@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold mb-8">Checkout</h1>

    <form method="POST" action="{{ route('orders.store') }}">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Checkout Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-2xl font-bold mb-6">Order Type</h2>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="radio" name="order_type" value="retail" checked 
                                   class="text-blue-600 focus:ring-blue-500">
                            <span class="ml-2">Retail Order</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="order_type" value="wholesale" 
                                   class="text-blue-600 focus:ring-blue-500">
                            <span class="ml-2">Wholesale Order</span>
                        </label>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-2xl font-bold mb-6">Shipping Information</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="shipping_name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                            <input type="text" name="shipping_name" id="shipping_name" required 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2">
                        </div>

                        <div>
                            <label for="shipping_email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" name="shipping_email" id="shipping_email" required 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2">
                        </div>

                        <div>
                            <label for="shipping_phone" class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                            <input type="text" name="shipping_phone" id="shipping_phone" required 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2">
                        </div>
                    </div>

                    <div class="mt-4">
                        <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                        <input type="text" name="shipping_address" id="shipping_address" required 
                               class="w-full border border-gray-300 rounded-md px-3 py-2">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                        <div>
                            <label for="shipping_city" class="block text-sm font-medium text-gray-700 mb-2">City</label>
                            <input type="text" name="shipping_city" id="shipping_city" required 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2">
                        </div>

                        <div>
                            <label for="shipping_state" class="block text-sm font-medium text-gray-700 mb-2">State</label>
                            <input type="text" name="shipping_state" id="shipping_state" 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2">
                        </div>

                        <div>
                            <label for="shipping_postal_code" class="block text-sm font-medium text-gray-700 mb-2">Postal Code</label>
                            <input type="text" name="shipping_postal_code" id="shipping_postal_code" required 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2">
                        </div>
                    </div>

                    <div class="mt-4">
                        <label for="shipping_country" class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                        <input type="text" name="shipping_country" id="shipping_country" required 
                               class="w-full border border-gray-300 rounded-md px-3 py-2">
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold mb-6">Payment Information</h2>
                    
                    <div class="mb-4">
                        <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">Payment Method</label>
                        <select name="payment_method" id="payment_method" required 
                                class="w-full border border-gray-300 rounded-md px-3 py-2">
                            <option value="">Select payment method</option>
                            <option value="credit_card">Credit Card</option>
                            <option value="debit_card">Debit Card</option>
                            <option value="paypal">PayPal</option>
                            <option value="bank_transfer">Bank Transfer</option>
                        </select>
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Order Notes (Optional)</label>
                        <textarea name="notes" id="notes" rows="4" 
                                  class="w-full border border-gray-300 rounded-md px-3 py-2"></textarea>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                    <h2 class="text-2xl font-bold mb-4">Order Summary</h2>
                    <div class="space-y-2 mb-4">
                        <div class="flex justify-between">
                            <span>Subtotal:</span>
                            <span>${{ number_format($total ?? 0, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Shipping:</span>
                            <span>$10.00</span>
                        </div>
                        <div class="flex justify-between border-t pt-2">
                            <span class="font-bold">Total:</span>
                            <span class="font-bold text-xl">${{ number_format(($total ?? 0) + 10, 2) }}</span>
                        </div>
                    </div>
                    <button type="submit" 
                            class="block w-full bg-blue-600 text-white text-center px-6 py-3 rounded-lg font-semibold hover:bg-blue-700">
                        Place Order
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

