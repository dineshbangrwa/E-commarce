# Zopify

A full-featured, production-style e-commerce platform built with Laravel 12, Blade, Alpine.js, Tailwind CSS, and modern PHP practices. This project is not just a basic storefront — it is a complete online shopping system with multilingual storefront pages, dynamic product catalogs, cart and checkout orchestration, order lifecycle management, payment integration, media handling, SEO-friendly content management, and an admin control panel.

This repository reflects a serious full-stack engineering effort and is designed to impress recruiters, hiring managers, and technical reviewers with both business logic depth and clean architecture.

---

## Why this project stands out

Zopify is a feature-rich commerce application that demonstrates:

- End-to-end e-commerce flows from product discovery to order completion
- Real-world backend logic for cart management, stock handling, coupons, and order processing
- Multi-language and dynamic content support for a modern global storefront
- A polished admin panel for product, category, review, currency, and order management
- Modern Laravel architecture with structured controllers, models, migrations, and media handling
- Integration-ready payment workflows for Stripe and PayPal ecosystems

This is the kind of project that shows not only coding ability, but also product thinking, system design, and attention to user experience.

---

## Core product capabilities

### 1. Customer-facing storefront
The public side of the app includes:

- Multi-language homepages and routes
- Category and product listing pages
- Product detail pages with descriptions, pricing, and related products
- Search functionality for products and categories
- Product reviews and customer feedback
- Responsive shop pages styled with Tailwind CSS and Blade templates

### 2. Shopping experience
The platform is built around a realistic shopping journey:

- Add products to cart
- Update quantities dynamically
- Apply coupon discounts
- Manage wishlist items
- Choose product variants and combinations
- Proceed through checkout and order placement

### 3. Secure and flexible checkout flow
The checkout experience supports:

- Guest and authenticated users
- Order creation from cart or direct purchase flow
- Stripe-based payment processing
- PayPal integration support
- Order confirmation and email notification flow
- Address and billing handling

### 4. User account system
Customers can:

- Register and log in
- Update profile details
- Upload profile images
- View their order history
- Access personalized wishlist and account pages
- Sign in using Google OAuth

### 5. Admin management system
The admin side includes modules for:

- Dashboard with order and user insights
- User management
- Product CRUD with media uploads and variant combinations
- Category management
- Coupon management
- Review moderation
- Order and inquiry management
- Page, slider, and block content management
- Currency and exchange rate handling
- Role and permission management

---

## Architecture and engineering depth

This project is structured as a real application, not just a demo.

### Backend architecture
- Laravel 12 as the application framework
- Clean MVC structure with controllers for routing and business flow
- Eloquent models for products, orders, carts, coupons, users, reviews, translations, and content
- Database migrations for a complete commerce schema
- Middleware and route organization for public and admin areas

### Frontend architecture
- Blade templates for server-rendered UI
- Alpine.js for lightweight interactivity
- Tailwind CSS for modern responsive styling
- Vite for frontend asset building

### Data and content features
- Media uploads handled through Spatie Media Library
- Multi-language product, category, slider, and page translations
- Dynamic product attribute combinations and stock-aware cart updates
- SEO-related metadata fields for products and categories

### Business logic features
- Quote/cart lifecycle management
- Coupon validity checks and discount logic
- Stock reduction when variants are ordered
- Dynamic recalculation of totals and cart values
- Order records across multiple related models

---

## Major modules implemented

### Storefront modules
- Home page
- Shop page
- Product detail page
- Category pages
- Search experience
- Contact page
- Cart page
- Checkout page
- Wishlist page
- Order history and order detail pages

### Admin modules
- Dashboard
- Users
- Products
- Categories
- Coupons
- Reviews
- Orders
- Enquiries
- Pages
- Sliders
- Blocks
- Permissions and roles
- Currency and exchange rates

### Integration modules
- Stripe Checkout
- PayPal integration hooks
- Google OAuth login
- Email notifications
- Media storage and uploads

---

## Tech stack

| Layer | Technology |
|---|---|
| Backend | PHP 8.2+, Laravel 12 |
| Frontend | Blade, Alpine.js, Tailwind CSS |
| Build Tool | Vite |
| Database | MySQL / SQLite |
| Auth | Laravel authentication, Google OAuth |
| Payments | Stripe, PayPal-ready integration |
| Media | Spatie Media Library |
| Roles & Permissions | Spatie Permission |
| Billing / Subscription | Laravel Cashier |
| UI / Data Tables | Yajra DataTables |
| Localization | Custom multi-language translation system |

---

## Project structure

```text
app/
  Http/Controllers/       # Public, admin, and payment controllers
  Http/Middleware/        # Locale and admin access middleware
  Models/                 # Product, cart, order, user, review, category, and translation models
  Mail/                   # Email notifications
  Providers/              # Application service providers

resources/
  views/                  # Blade templates for storefront and admin UI
  css/                    # Styling assets
  js/                     # Frontend scripts

routes/
  web.php                 # Main public, admin, auth, and payment routes
  api.php                 # API routes

database/
  migrations/             # Commerce and content schema
  seeders/                # Initial data seeding

public/
  assets/                 # Compiled and static front-end assets
```

---

## Key technical highlights

### 1. Product variant support
Products support attribute-based combinations such as size, color, and other custom options. These variants influence stock and pricing dynamically.

### 2. Cart and quote system
The application maintains cart state for both authenticated and guest users using Laravel models and session-based logic.

### 3. Coupon logic
Coupons are validated by code, validity window, and subtotal thresholds before being applied.

### 4. Order lifecycle
Orders are created from cart or direct purchase flow and include order items, address details, totals, and payment metadata.

### 5. Localization support
The storefront supports language-specific content for pages, products, categories, blocks, and sliders.

### 6. Media management
Products, pages, sliders, blocks, and users all support media uploads and management.

### 7. Admin control with roles
The admin panel is built with role-based modules and permission-aware routes, showing professional backend structure.

---

## Installation

### Prerequisites
- PHP 8.2+
- Composer
- Node.js 18+
- MySQL

### Setup

```bash
git clone https://github.com/your-username/zopify.git
cd zopify
composer install
cp .env.example .env
php artisan key:generate
```

Update your database and mail configuration in the .env file, then run:

```bash
php artisan migrate
php artisan db:seed
npm install
npm run build
```

Start the application:

```bash
php artisan serve
```

For frontend development with Vite:

```bash
npm run dev
```

> Windows PowerShell users should replace cp with copy.

---

## Environment variables

A typical configuration includes:

```env
APP_NAME=Zopify
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
```

---

## Development commands

```bash
php artisan serve
npm run dev
npm run build
php artisan migrate
php artisan test
```

---

## Testing

```bash
php artisan test
```

---

## What recruiters should notice

This repository showcases:

- Strong Laravel backend development skills
- Real-world e-commerce domain understanding
- Clean route and controller organization
- Data modeling and relational database design
- Multi-feature application thinking beyond simple CRUD
- Frontend integration with Blade + Alpine + Tailwind
- Payment and authentication integration experience
- A complete product that feels close to a real business application

---

## License

This project is open-source and available under the MIT License.
