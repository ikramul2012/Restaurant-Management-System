# Restaurant Management System (RMS)

A web-based Restaurant Management System built with Laravel. This application allows users to browse food items, add them to cart, book tables, and place orders. Admins can manage food items, view orders, and handle reservations.

## Features

- User registration and authentication
- Browse and search food menu
- Add food items to cart
- Place and manage orders
- Table booking system
- Admin dashboard for managing food, orders, and reservations
- Stripe payment integration

## Project Structure

- `app/Models/`  
  - [`User`](app/Models/User.php): Handles user authentication and profile.
  - [`Food`](app/Models/Food.php): Represents food items and their relation to orders.
  - [`Order`](app/Models/Order.php): Manages customer orders and their relation to food.
  - [`Cart`](app/Models/Cart.php): Handles shopping cart functionality.
  - [`Book`](app/Models/Book.php): Manages table bookings.
- `routes/web.php`: Main web routes for user and admin actions.
- `public/`: Public assets (CSS, JS, images).
- `resources/`: Blade templates and frontend resources.

## Installation

1. Clone the repository:
    ```sh
    git clone <your-repo-url>
    cd RMS
    ```
2. Install dependencies:
    ```sh
    composer install
    npm install
    ```
3. Copy `.env.example` to `.env` and set your environment variables:
    ```sh
    cp .env.example .env
    ```
4. Generate application key:
    ```sh
    php artisan key:generate
    ```
5. Run migrations:
    ```sh
    php artisan migrate
    ```
6. (Optional) Seed the database:
    ```sh
    php artisan db:seed
    ```
7. Start the development server:
    ```sh
    php artisan serve
    ```

## Usage

- Visit `/` for the home page.
- Register or log in to start ordering food or booking tables.
- Admins can access food management, orders, and reservations via their dashboard.

---

**Note:**  
This project uses Laravel Jetstream, Fortify, and Sanctum for authentication and security.  
Stripe is used for payment processing.
