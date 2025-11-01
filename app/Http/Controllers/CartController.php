<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        $cartItems = [];
        $total = 0;
        
        foreach ($cart as $key => $item) {
            if (strpos($key, 'product_') === 0) {
                $productId = str_replace('product_', '', $key);
                $product = Product::find($productId);
                
                if ($product) {
                    $product->quantity = $item['quantity'];
                    $product->cartKey = $key;
                    $cartItems[] = $product;
                    $total += $product->retail_price * $item['quantity'];
                }
            } elseif (strpos($key, 'variation_') === 0) {
                $variationId = str_replace('variation_', '', $key);
                $variation = ProductVariation::with('product')->find($variationId);
                
                if ($variation) {
                    $variation->quantity = $item['quantity'];
                    $variation->cartKey = $key;
                    $cartItems[] = $variation;
                    $total += $variation->retail_price * $item['quantity'];
                }
            }
        }
        
        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variation_id' => 'nullable|exists:product_variations,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Session::get('cart', []);
        $product = Product::findOrFail($request->product_id);
        
        // Check if product has variations
        if ($request->variation_id) {
            $variation = ProductVariation::findOrFail($request->variation_id);
            $cartKey = 'variation_' . $request->variation_id;
            
            if (isset($cart[$cartKey])) {
                $cart[$cartKey]['quantity'] += $request->quantity;
            } else {
                $cart[$cartKey] = [
                    'product_id' => $request->product_id,
                    'variation_id' => $request->variation_id,
                    'quantity' => $request->quantity,
                ];
            }
        } else {
            $cartKey = 'product_' . $request->product_id;
            
            if (isset($cart[$cartKey])) {
                $cart[$cartKey]['quantity'] += $request->quantity;
            } else {
                $cart[$cartKey] = [
                    'product_id' => $request->product_id,
                    'variation_id' => null,
                    'quantity' => $request->quantity,
                ];
            }
        }

        Session::put('cart', $cart);
        
        return redirect()->route('cart.index')->with('success', 'Product added to cart');
    }

    public function update(Request $request, $cartKey)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Session::get('cart', []);
        
        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] = $request->quantity;
            Session::put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Cart updated');
    }

    public function remove($cartKey)
    {
        $cart = Session::get('cart', []);
        
        if (isset($cart[$cartKey])) {
            unset($cart[$cartKey]);
            Session::put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Product removed from cart');
    }
}
