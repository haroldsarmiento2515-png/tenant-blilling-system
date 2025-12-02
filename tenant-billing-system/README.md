# Tenant Billing System

A comprehensive Laravel-based billing system for managing tenants, bills, and payments with separate user and admin authentication.

## Features

### User Authentication
- Separate login and registration pages for users and admins
- Email verification with OTP
- Google reCAPTCHA v2 integration
- Middleware for access control

### Admin Panel
- Dashboard with real-time charts
- Statistics overview for billing and collections
- User and tenant management
- Bill and payment tracking

### Tenant Management
- Tenant registration and profile management
- Association with multiple users
- Billing history tracking

### Billing System
- Bill creation and management
- Payment recording and tracking
- Status tracking (pending, paid, overdue)
- Collection rate monitoring

### Technical Features
- MVC architecture
- Blade template inheritance
- Database relationships (one-to-many, many-to-many with pivot tables)
- Form validation with custom error messages
- RESTful controllers

## Database Structure

The system includes the following main entities:

1. **Users** - Registered users of the system
2. **Admins** - Administrative users with special privileges
3. **Tenants** - Entities being billed
4. **Bills** - Billing records for tenants
5. **Payments** - Payment records for bills

## Installation

1. Clone the repository
2. Run `composer install`
3. Copy `.env.example` to `.env` and configure database settings
4. Run `php artisan key:generate`
5. Run `php artisan migrate`
6. Configure Google reCAPTCHA keys in `.env`:
   ```
   RECAPTCHA_SITE_KEY=your_site_key
   RECAPTCHA_SECRET_KEY=your_secret_key
   ```

## Routes

### Public Routes
- `/` - Welcome page
- `/login` - User login
- `/register` - User registration
- `/email/verify` - Email verification
- `/admin/login` - Admin login

### User Protected Routes
- `/dashboard` - User dashboard
- `/logout` - Logout (both user and admin)

### Admin Protected Routes
- `/admin/dashboard` - Admin dashboard
- `/admin/dashboard/user-chart-data` - User registration chart data
- `/admin/dashboard/billing-chart-data` - Billing statistics chart data

## Models and Relationships

- **User** ↔ **Tenant** (Many-to-Many via `tenant_user` pivot table)
- **Tenant** → **Bill** (One-to-Many)
- **Bill** → **Payment** (One-to-Many)

## Controllers

- `AuthController` - Handles authentication for users and admins
- `TenantController` - Manages tenant CRUD operations
- `BillController` - Manages bill CRUD operations
- `PaymentController` - Manages payment CRUD operations
- `Admin\DashboardController` - Handles admin dashboard functionality

## Middleware

- `AdminMiddleware` - Restricts access to admin routes
- `UserMiddleware` - Restricts access to user routes

## Views

All views use Blade template inheritance with a master layout at `resources/views/layouts/app.blade.php`.

## Requirements

- PHP 8.0 or higher
- MySQL 5.7 or higher
- Composer
- Google reCAPTCHA v2 keys

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).