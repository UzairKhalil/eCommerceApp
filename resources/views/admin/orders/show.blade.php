@extends('layouts.admin')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.orders.index') }}" class="text-blue-600 hover:underline">← Back to Orders</a>
</div>

<h1 class="text-3xl font-bold mb-8">Order Details - {{ $order->order_number }}</h1>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Order Information -->
    <div class="lg:col-span-2">
        <!-- Order Items -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-bold mb-4">Order Items</h2>
            <div class="space-y-4">
                @foreach($order->orderItems as $item)
                <div class="flex justify-between border-b pb-4">
                    <div>
                        <h3 class="font-semibold">{{ $item->product_name }}</h3>
                        @if($item->variation_name)
                        <p class="text-sm text-gray-600">{{ $item->variation_name }}</p>
                        @endif
                        <p class="text-sm text-gray-500">SKU: {{ $item->product_sku }}</p>
                        <p class="text-sm text-gray-500">Qty: {{ $item->quantity }} × ${{ number_format($item->unit_price, 2) }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold">${{ number_format($item->total_price, 2) }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Shipping Information -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold mb-4">Shipping Information</h2>
            <div class="space-y-2">
                <p><strong>Name:</strong> {{ $order->shipping_name }}</p>
                <p><strong>Email:</strong> {{ $order->shipping_email }}</p>
                <p><strong>Phone:</strong> {{ $order->shipping_phone }}</p>
                <p><strong>Address:</strong> {{ $order->shipping_address }}</p>
                <p><strong>City:</strong> {{ $order->shipping_city }}</p>
                @if($order->shipping_state)
                <p><strong>State:</strong> {{ $order->shipping_state }}</p>
                @endif
                <p><strong>Postal Code:</strong> {{ $order->shipping_postal_code }}</p>
                <p><strong>Country:</strong> {{ $order->shipping_country }}</p>
            </div>
        </div>
    </div>

    <!-- Order Summary -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
            <h2 class="text-xl font-bold mb-4">Order Summary</h2>
            <div class="space-y-2 mb-6">
                <div class="flex justify-between">
                    <span>Subtotal:</span>
                    <span>${{ number_format($order->subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Shipping:</span>
                    <span>${{ number_format($order->shipping_cost, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Tax:</span>
                    <span>${{ number_format($order->tax, 2) }}</span>
                </div>
                <div class="flex justify-between border-t pt-2 font-bold text-lg">
                    <span>Total:</span>
                    <span>${{ number_format($order->total, 2) }}</span>
                </div>
            </div>

            <!-- Update Status -->
            <div>
                <h3 class="font-bold mb-2">Order Status</h3>
                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <select name="status" class="w-full border border-gray-300 rounded-md px-3 py-2 mb-2">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        Update Status
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

