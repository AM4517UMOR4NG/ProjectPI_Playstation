<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

# Playstation Rental Management System

## Overview
**Playstation Rental Management System** is a comprehensive web application designed to streamline the operations of a Playstation rental business. It features a robust Point of Sale (POS) system, real-time inventory tracking, and secure role-based access control for Admins, Cashiers, and Customers.

## Key Features

### 🎭 Role-Based Access Control
- **Admin**: Full control over the system, including user management, inventory, and financial reporting.
- **Kasir (Cashier)**: Dedicated interface for processing rentals, managing transactions, and viewing daily shifts.
- **Pelanggan (Customer)**: User-friendly portal to browse available units, view rental history, and make bookings.

### 📊 Dashboard & Analytics
- Real-time overview of **Revenue**, **Active Rentals**, and **Total Transactions**.
- Visual charts and graphs for monthly performance tracking.
- Recent activity logs to monitor system usage.

### 🎮 Rental Management
- **Unit Management**: Track availability and status of Playstation units.
- **Booking System**: Easy-to-use interface for creating and managing rental bookings.
- **Timer Integration**: Automated tracking of rental duration.

### 💳 Payment Integration
- **Midtrans Support**: Seamless online payment processing for customers.
- **Transaction History**: Detailed logs of all payments and transaction statuses.

## Installation Guide

Follow these steps to set up the project locally:

1.  **Clone the Repository**
    ```bash
    git clone https://github.com/AM4517UMOR4NG/ProjectPI_Playstation.git
    cd your-repo-name
    ```

2.  **Install Dependencies**
    ```bash
    composer install
    npm install
    ```

3.  **Environment Setup**
    Copy the example environment file and configure your database and Midtrans credentials:
    ```bash
    cp .env.example .env
    ```
    Update `.env` with your DB credentials and Midtrans keys:
    ```ini
    DB_DATABASE=your_database_name
    MIDTRANS_SERVER_KEY=your_server_key
    MIDTRANS_CLIENT_KEY=your_client_key
    ```

4.  **Generate Application Key**
    ```bash
    php artisan key:generate
    ```

5.  **Run Migrations & Seeders**
    ```bash
    php artisan migrate --seed
    ```

6.  **Build Assets & Run Server**
    ```bash
    npm run build
    php artisan serve
    ```

## Technology Stack
-   **Framework**: Laravel 11
-   **Frontend**: Blade Templates, Bootstrap / Tailwind CSS
-   **Database**: MySQL
-   **Payment Gateway**: Midtrans

