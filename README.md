# Laravel E-commerce Project

Hey there! 👋 Welcome to my Laravel e-commerce project. This is a simple but powerful e-commerce application built with Laravel and Vue.js. Let me show you how to get it up and running!

## Quick Start

Before we dive in, make sure you have:
- PHP 7.0 or higher
- Node.js 14+
- Composer
- MySQL or PostgreSQL

## Installation Steps

1. First, grab the code

2. Get all the dependencies installed:
composer install
npm install

3. Set up your environment:
cp .env.example .env
php artisan key:generate
php artisan storage:link   

4. Open up `.env` and set your database info:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password

5. Set up the database and add some demo data:
php artisan migrate
php artisan db:seed    # This will add some sample products and categories

## Building & Running

1. Build the frontend stuff:
npm run prod  # or npm run build

2. Fire up the server:
php artisan serve

3. Head over to http://localhost:8000 in your browser - you should see the app running!

## What's Where?

Here's how everything is organized:
├── app/                  
│   ├── Http/            # Controllers and Middleware
│   ├── Models/          # Eloquent Models
│   └── Repositories/    # Repository Pattern Implementation
│       ├── CategoryRepository.php  # Handles category data operations
│       └── ProductRepository.php   # Handles product data operations
├── database/            
│   └── seeders/         # Demo data creators
├── resources/           
│   ├── js/              # Vue components & frontend code
│   └── sass/            # Making things pretty with SCSS
├── routes/              # Where to find what
└── package.json         # Frontend dependencies

## Repository Pattern

The project uses the Repository Pattern to separate data access logic:

- CategoryRepository: Handles all category-related database operations
  - Create/Read/Update/Delete categories
  - Fetch categories with parent relationships

- ProductRepository: Manages product-related operations
  - CRUD operations for products
  - Handle product-category relationships
  - Query builder for advanced product searches

## Artisan Commands

We've got some handy command-line tools to help you manage the store:

1. List all categories:
php artisan category:list

This shows you a nice table with:
- Category ID
- Name
- Parent Category Name
- Parent Category ID
- Created/Updated dates

2. Create a new product:
php artisan product:create

Just follow the prompts to enter:
- Product name
- Description
- Price
- Categories (just separate multiple categories with commas)

Example:
$ php artisan product:create
Enter the product name: Gaming Laptop
Enter the product description: High-performance gaming laptop
Enter the product price: 1299.99
Enter the product categories: 1,4,7
Product created successfully!

## Cool Features

- Category Management: Nice and organized with main categories and subcategories
- Product Catalog: Easy to browse and search
- Admin Dashboard: Manage everything in one place

## Built With

- Laravel 8+ (The PHP framework for web artisans)
- Vue.js 3 (For that smooth user experience)
- PrimeVue (Pretty UI components)
- TailwindCSS (Making everything look nice)


Happy coding!
