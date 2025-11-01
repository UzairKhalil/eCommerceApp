# eCommerce Laravel Application

A complete e-commerce web application built with Laravel 12 and Tailwind CSS v4. This application provides a full sales and purchase system for multiple products with variations, supporting both retail and wholesale pricing, with a comprehensive admin panel.

## Features

### Public Features
- ✅ **Product Catalog**: Browse products by category with search functionality
- ✅ **Product Details**: View detailed product information with variations
- ✅ **Shopping Cart**: Add, update, and remove items from cart
- ✅ **Checkout**: Complete order placement with shipping information
- ✅ **Order Management**: View order history and track order status
- ✅ **User Authentication**: Registration and login system
- ✅ **Responsive Design**: Mobile-friendly interface with Tailwind CSS

### Admin Features
- ✅ **Dashboard**: Statistics and recent orders overview
- ✅ **Product Management**: Full CRUD for products and variations
- ✅ **Category Management**: Create and manage product categories
- ✅ **Order Management**: View and update order status
- ✅ **Price Management**: Separate retail and wholesale pricing
- ✅ **Stock Management**: Track inventory levels
- ✅ **User Management**: Admin and regular user roles

### Key Technical Features
- ✅ **Product Variations**: Size, color, and custom attributes
- ✅ **Dual Pricing**: Retail and wholesale support
- ✅ **Session-based Cart**: No login required for browsing
- ✅ **Order Processing**: Complete order workflow
- ✅ **Authorization**: Admin-only access to management panel
- ✅ **Database Seeding**: Sample data included

## Technology Stack

- **Backend**: Laravel 12
- **Frontend**: Tailwind CSS v4, Blade Templates
- **Database**: MySQL/SQLite (configurable)
- **Authentication**: Laravel Breeze (built-in)
- **Build Tool**: Vite

## Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js and NPM
- MySQL or SQLite

### Setup Instructions

1. **Clone the repository**
   ```bash
   cd eCommerceApp
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node dependencies**
   ```bash
   npm install
   ```

4. **Configure environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure database** (Edit `.env` file)
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Run migrations and seed database**
   ```bash
   php artisan migrate --seed
   ```

7. **Build frontend assets**
   ```bash
   npm run dev
   # Or for production: npm run build
   ```

8. **Start development server**
   ```bash
   php artisan serve
   ```

9. **Access the application**
   - Public site: http://localhost:8000
   - Admin panel: http://localhost:8000/login

## Default Credentials

### Admin Account
- **Email**: admin@example.com
- **Password**: password

### Regular User
- **Email**: user@example.com
- **Password**: password

## Database Structure

### Tables
- `users` - User accounts (admin/customer)
- `categories` - Product categories
- `products` - Product information
- `product_variations` - Product variations (size, color, etc.)
- `orders` - Order details
- `order_items` - Individual order line items

### Relationships
- Categories → Products (1:N)
- Products → Variations (1:N)
- Users → Orders (1:N)
- Orders → Order Items (1:N)
- Products → Order Items (1:N)

## Usage Guide

### For Customers

1. **Browse Products**: Visit the homepage and browse featured products
2. **Search**: Use the search bar to find specific products
3. **View Details**: Click on any product to see details and variations
4. **Add to Cart**: Select variations and quantity, then add to cart
5. **Checkout**: Review cart and proceed to checkout
6. **Place Order**: Fill shipping information and place order
7. **Track Orders**: View order history and status

### For Administrators

1. **Login**: Use admin credentials to access admin panel
2. **Dashboard**: View sales statistics and recent orders
3. **Manage Products**: Create, edit, and delete products
4. **Manage Categories**: Organize products into categories
5. **Manage Orders**: Update order status and track shipments
6. **Set Prices**: Configure retail and wholesale pricing

## Project Structure

```
app/
├── Http/Controllers/
│   ├── HomeController.php
│   ├── ProductController.php
│   ├── CartController.php
│   ├── OrderController.php
│   ├── Auth/
│   │   ├── LoginController.php
│   │   └── RegisterController.php
│   └── Admin/
│       ├── AdminController.php
│       ├── CategoryController.php
│       ├── AdminProductController.php
│       └── AdminOrderController.php
├── Models/
│   ├── User.php
│   ├── Category.php
│   ├── Product.php
│   ├── ProductVariation.php
│   ├── Order.php
│   └── OrderItem.php

resources/
├── views/
│   ├── layouts/
│   │   ├── app.blade.php
│   │   └── admin.blade.php
│   ├── home.blade.php
│   ├── products/
│   │   ├── index.blade.php
│   │   └── show.blade.php
│   ├── cart/index.blade.php
│   ├── checkout.blade.php
│   ├── orders/
│   │   ├── index.blade.php
│   │   └── show.blade.php
│   ├── auth/
│   │   ├── login.blade.php
│   │   └── register.blade.php
│   └── admin/
│       ├── dashboard.blade.php
│       ├── categories/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   └── edit.blade.php
│       ├── products/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   └── edit.blade.php
│       └── orders/
│           ├── index.blade.php
│           └── show.blade.php

routes/
└── web.php
```

## Key Features Explained

### Product Variations
Products can have multiple variations (e.g., Size: Small/Medium/Large, Color: Red/Blue/Green). Each variation has its own SKU, pricing, and stock level.

### Dual Pricing
- **Retail Price**: Standard customer price
- **Wholesale Price**: Discounted price for bulk purchases
- Orders can be placed in either retail or wholesale mode

### Shopping Cart
- Session-based cart (works without login)
- Items persist across page visits
- Quantity updates and removals
- Automatic price calculations

### Order Management
- Order number generation
- Status tracking (Pending → Processing → Shipped → Delivered)
- Shipping information capture
- Payment method selection
- Order summary and history

### Admin Panel
- Protected routes with middleware
- Dashboard with statistics
- Full CRUD for products and categories
- Order status management
- Clean, professional interface

## Development

### Running Tests
```bash
php artisan test
```

### Code Style
```bash
php artisan pint
```

### Database Commands
```bash
# Reset database
php artisan migrate:fresh --seed

# Rollback migrations
php artisan migrate:rollback

# View routes
php artisan route:list
```

## Customization

### Adding New Product Attributes
Edit the `products` migration to add new columns, then update the Product model's `$fillable` array.

### Modifying Cart Behavior
The cart is managed in `CartController.php` using Laravel sessions. Modify the session keys or structure as needed.

### Changing Order Workflow
Order processing logic is in `OrderController.php`. Update the `store()` method to modify order creation logic.

### Admin Authorization
Admin check is done via the `is_admin` field on users. Middleware can be added for additional security.

## Contributing

Feel free to submit issues and enhancement requests!

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Support

For issues or questions, please check:
- `QUICKSTART.md` - Quick start guide
- `VIEWS_GUIDE.md` - Views documentation

## Credits

Built with [Laravel](https://laravel.com) and [Tailwind CSS](https://tailwindcss.com).
