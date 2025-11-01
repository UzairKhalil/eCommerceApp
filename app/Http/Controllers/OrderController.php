<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Auth::user()->orders()->latest()->get();
        return view('orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);
        return view('orders.show', compact('order'));
    }

    public function checkout()
    {
        $cart = Session::get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        // Calculate total
        $total = 0;
        foreach ($cart as $key => $item) {
            if (strpos($key, 'product_') === 0) {
                $productId = str_replace('product_', '', $key);
                $product = \App\Models\Product::find($productId);
                if ($product) {
                    $total += $product->retail_price * $item['quantity'];
                }
            } elseif (strpos($key, 'variation_') === 0) {
                $variationId = str_replace('variation_', '', $key);
                $variation = \App\Models\ProductVariation::find($variationId);
                if ($variation) {
                    $total += $variation->retail_price * $item['quantity'];
                }
            }
        }

        return view('checkout', compact('total'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_type' => 'required|in:retail,wholesale',
            'shipping_name' => 'required|string|max:255',
            'shipping_email' => 'required|email',
            'shipping_phone' => 'required|string',
            'shipping_address' => 'required|string',
            'shipping_city' => 'required|string',
            'shipping_state' => 'nullable|string',
            'shipping_postal_code' => 'required|string',
            'shipping_country' => 'required|string',
            'payment_method' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $cart = Session::get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        DB::beginTransaction();
        try {
            // Calculate totals
            $subtotal = 0;
            foreach ($cart as $item) {
                if (isset($item['variation_id'])) {
                    $variation = \App\Models\ProductVariation::find($item['variation_id']);
                    if ($variation) {
                        $price = $validated['order_type'] === 'wholesale' ? $variation->wholesale_price : $variation->retail_price;
                        $subtotal += $price * $item['quantity'];
                    }
                } else {
                    $product = \App\Models\Product::find($item['product_id']);
                    if ($product) {
                        $price = $validated['order_type'] === 'wholesale' ? $product->wholesale_price : $product->retail_price;
                        $subtotal += $price * $item['quantity'];
                    }
                }
            }

            $shippingCost = 10.00; // Fixed shipping for demo
            $tax = $subtotal * 0.10; // 10% tax
            $total = $subtotal + $shippingCost + $tax;

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'order_type' => $validated['order_type'],
                'status' => 'pending',
                'shipping_name' => $validated['shipping_name'],
                'shipping_email' => $validated['shipping_email'],
                'shipping_phone' => $validated['shipping_phone'],
                'shipping_address' => $validated['shipping_address'],
                'shipping_city' => $validated['shipping_city'],
                'shipping_state' => $validated['shipping_state'],
                'shipping_postal_code' => $validated['shipping_postal_code'],
                'shipping_country' => $validated['shipping_country'],
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'tax' => $tax,
                'total' => $total,
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'pending',
                'notes' => $validated['notes'] ?? null,
            ]);

            // Create order items
            foreach ($cart as $key => $item) {
                if (strpos($key, 'variation_') === 0) {
                    $variation = \App\Models\ProductVariation::with('product')->find($item['variation_id']);
                    if ($variation) {
                        $price = $validated['order_type'] === 'wholesale' ? $variation->wholesale_price : $variation->retail_price;
                        OrderItem::create([
                            'order_id' => $order->id,
                            'product_id' => $variation->product_id,
                            'product_variation_id' => $variation->id,
                            'product_name' => $variation->product->name,
                            'product_sku' => $variation->sku,
                            'variation_name' => $variation->name,
                            'quantity' => $item['quantity'],
                            'unit_price' => $price,
                            'total_price' => $price * $item['quantity'],
                        ]);
                    }
                } else {
                    $product = \App\Models\Product::find($item['product_id']);
                    if ($product) {
                        $price = $validated['order_type'] === 'wholesale' ? $product->wholesale_price : $product->retail_price;
                        OrderItem::create([
                            'order_id' => $order->id,
                            'product_id' => $product->id,
                            'product_variation_id' => null,
                            'product_name' => $product->name,
                            'product_sku' => $product->sku,
                            'variation_name' => null,
                            'quantity' => $item['quantity'],
                            'unit_price' => $price,
                            'total_price' => $price * $item['quantity'],
                        ]);
                    }
                }
            }

            DB::commit();
            Session::forget('cart');

            return redirect()->route('orders.show', $order->id)->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to place order. Please try again.');
        }
    }
}
