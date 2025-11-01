<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        // Create Regular User
        User::create([
            'name' => 'Test User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        // Create Categories
        $category1 = Category::create([
            'name' => 'Electronics',
            'slug' => 'electronics',
            'description' => 'Electronic products and gadgets',
            'is_active' => true,
        ]);

        $category2 = Category::create([
            'name' => 'Clothing',
            'slug' => 'clothing',
            'description' => 'Fashion and clothing items',
            'is_active' => true,
        ]);

        $category3 = Category::create([
            'name' => 'Home & Garden',
            'slug' => 'home-garden',
            'description' => 'Home improvement and garden supplies',
            'is_active' => true,
        ]);

        // Create Products
        $product1 = Product::create([
            'category_id' => $category1->id,
            'name' => 'Smartphone X',
            'slug' => 'smartphone-x',
            'description' => 'Latest smartphone with advanced features',
            'short_description' => 'High-end smartphone',
            'sku' => 'ELEC-001',
            'retail_price' => 999.99,
            'wholesale_price' => 899.99,
            'stock_quantity' => 50,
            'has_variations' => true,
            'is_active' => true,
        ]);

        $product2 = Product::create([
            'category_id' => $category2->id,
            'name' => 'Cotton T-Shirt',
            'slug' => 'cotton-t-shirt',
            'description' => 'Comfortable cotton t-shirt',
            'short_description' => '100% cotton t-shirt',
            'sku' => 'CLTH-001',
            'retail_price' => 29.99,
            'wholesale_price' => 24.99,
            'stock_quantity' => 100,
            'has_variations' => true,
            'is_active' => true,
        ]);

        $product3 = Product::create([
            'category_id' => $category3->id,
            'name' => 'Garden Tools Set',
            'slug' => 'garden-tools-set',
            'description' => 'Complete set of garden tools',
            'short_description' => 'Professional garden tools',
            'sku' => 'HOME-001',
            'retail_price' => 149.99,
            'wholesale_price' => 129.99,
            'stock_quantity' => 30,
            'has_variations' => false,
            'is_active' => true,
        ]);

        // Create Product Variations
        ProductVariation::create([
            'product_id' => $product1->id,
            'name' => 'Size: 256GB, Color: Black',
            'sku' => 'ELEC-001-V1',
            'retail_price' => 999.99,
            'wholesale_price' => 899.99,
            'stock_quantity' => 25,
            'attributes' => ['storage' => '256GB', 'color' => 'Black'],
            'is_active' => true,
        ]);

        ProductVariation::create([
            'product_id' => $product1->id,
            'name' => 'Size: 256GB, Color: White',
            'sku' => 'ELEC-001-V2',
            'retail_price' => 999.99,
            'wholesale_price' => 899.99,
            'stock_quantity' => 25,
            'attributes' => ['storage' => '256GB', 'color' => 'White'],
            'is_active' => true,
        ]);

        ProductVariation::create([
            'product_id' => $product2->id,
            'name' => 'Size: Small',
            'sku' => 'CLTH-001-S',
            'retail_price' => 29.99,
            'wholesale_price' => 24.99,
            'stock_quantity' => 25,
            'attributes' => ['size' => 'Small'],
            'is_active' => true,
        ]);

        ProductVariation::create([
            'product_id' => $product2->id,
            'name' => 'Size: Medium',
            'sku' => 'CLTH-001-M',
            'retail_price' => 29.99,
            'wholesale_price' => 24.99,
            'stock_quantity' => 25,
            'attributes' => ['size' => 'Medium'],
            'is_active' => true,
        ]);

        ProductVariation::create([
            'product_id' => $product2->id,
            'name' => 'Size: Large',
            'sku' => 'CLTH-001-L',
            'retail_price' => 29.99,
            'wholesale_price' => 24.99,
            'stock_quantity' => 25,
            'attributes' => ['size' => 'Large'],
            'is_active' => true,
        ]);
    }
}
