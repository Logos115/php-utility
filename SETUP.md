# Local Development Setup Guide

This guide will help you set up and run the Utility Billing System locally.

## Prerequisites

Before you begin, ensure you have the following installed:

- **PHP 8.2 or higher** with extensions:
  - OpenSSL
  - PDO
  - Mbstring
  - Tokenizer
  - XML
  - Ctype
  - JSON
  - BCMath
  - GD (for image processing)
- **Composer** (PHP dependency manager)
- **Node.js** (v18 or higher) and **npm**
- **MySQL/MariaDB** or **SQLite** (for database)
- **Git** (optional, for version control)

## Step-by-Step Setup

### 1. Clone/Navigate to the Project

```bash
cd D:\Work\Web\PHP\Laravel\utility
```

### 2. Install PHP Dependencies

```bash
composer install
```

This will install all Laravel packages and dependencies listed in `composer.json`.

### 3. Install Node.js Dependencies

```bash
npm install
```

This installs frontend dependencies (Vite, Tailwind CSS, Alpine.js, etc.).

### 4. Environment Configuration

Create a `.env` file from the example:

```bash
# On Windows PowerShell
Copy-Item .env.example .env

# On Windows CMD
copy .env.example .env

# On Linux/Mac
cp .env.example .env
```

### 5. Configure Environment Variables

Edit the `.env` file and set the following important variables:

```env
APP_NAME="Utility Billing System"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database Configuration (Choose one)

# Option 1: MySQL/MariaDB (Recommended)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=utility_db
DB_USERNAME=root
DB_PASSWORD=your_password

# Option 2: SQLite (Easier for quick setup)
# DB_CONNECTION=sqlite
# DB_DATABASE=database/database.sqlite

# Mail Configuration (for email verification)
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### 6. Generate Application Key

```bash
php artisan key:generate
```

This generates a unique encryption key for your application.

### 7. Database Setup

#### If using MySQL/MariaDB:

1. Create a database:
```sql
CREATE DATABASE utility_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

2. Run migrations:
```bash
php artisan migrate
```

#### If using SQLite:

1. Create the database file:
```bash
# On Windows PowerShell
New-Item -ItemType File -Path database\database.sqlite

# On Windows CMD
type nul > database\database.sqlite

# On Linux/Mac
touch database/database.sqlite
```

2. Run migrations:
```bash
php artisan migrate
```

#### If you have a database dump (dzm_spectrum.sql):

1. Import the SQL file into your MySQL database:
```bash
mysql -u root -p utility_db < dzm_spectrum.sql
```

2. Then run migrations to ensure schema is up to date:
```bash
php artisan migrate
```

### 8. Create Storage Link

Link the storage directory for file uploads:

```bash
php artisan storage:link
```

### 9. Clear and Cache Configuration

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

### 10. Build Frontend Assets (Development)

For development with hot reloading:

```bash
npm run dev
```

This will start Vite dev server in watch mode. Keep this terminal running.

### 11. Start the Laravel Development Server

Open a **new terminal window** and run:

```bash
php artisan serve
```

The application will be available at: **http://localhost:8000**

### Alternative: Run Everything Together

The project includes a convenient script to run all services at once:

```bash
composer run dev
```

This command runs:
- Laravel server
- Queue worker
- Log viewer (Pail)
- Vite dev server

## Creating Your First Admin User

Since the application uses role-based access, you'll need to create an admin user. You can do this via:

### Option 1: Using Tinker

```bash
php artisan tinker
```

Then run:
```php
$user = \App\Models\User::create([
    'first_name' => 'Admin',
    'last_name' => 'User',
    'username' => 'admin',
    'email' => 'admin@example.com',
    'password' => bcrypt('password'),
    'role' => 'admin',
    'email_verified_at' => now(),
]);
```

### Option 2: Create a Seeder

Create a seeder file and run it:
```bash
php artisan make:seeder AdminUserSeeder
```

Then run:
```bash
php artisan db:seed --class=AdminUserSeeder
```

## Access Points

Once running, you can access:

- **Public Homepage**: http://localhost:8000
- **User Login**: http://localhost:8000/login
- **User Signup**: http://localhost:8000/signup
- **Admin Login**: http://localhost:8000/admin/login
- **User Dashboard** (after login): http://localhost:8000/my-account
- **Admin Dashboard** (after admin login): http://localhost:8000/admin/dashboard

## Troubleshooting

### Issue: "Server refuses the connection" or "Connection refused"

This is the most common issue. Follow these steps:

1. **Check if the server is actually running:**
   ```bash
   # Look for the process
   netstat -ano | findstr :8000
   # Or check in Task Manager for "php" processes
   ```

2. **Verify PHP is working:**
   ```bash
   php -v
   php artisan --version
   ```

3. **Check if port 8000 is already in use:**
   ```bash
   # Windows PowerShell
   Get-NetTCPConnection -LocalPort 8000 -ErrorAction SilentlyContinue
   
   # If port is in use, use a different port:
   php artisan serve --port=8001
   # Then access: http://localhost:8001
   ```

4. **Try starting the server with explicit host and port:**
   ```bash
   php artisan serve --host=127.0.0.1 --port=8000
   ```

5. **Check for errors when starting the server:**
   - Look for error messages in the terminal
   - Common errors:
     - Missing `.env` file → Run: `copy .env.example .env` then `php artisan key:generate`
     - Database connection error → Check your `.env` database settings
     - Missing dependencies → Run: `composer install`

6. **Windows Firewall/Antivirus:**
   - Windows Firewall or antivirus might be blocking the connection
   - Try temporarily disabling firewall to test
   - Add PHP to firewall exceptions

7. **Check if you're using the correct URL:**
   - Try: `http://127.0.0.1:8000` instead of `http://localhost:8000`
   - Some Windows configurations have issues with `localhost`

8. **Verify the server started successfully:**
   - You should see: `Laravel development server started: http://127.0.0.1:8000`
   - If you see errors, fix them first

9. **Alternative: Use a different port:**
   ```bash
   php artisan serve --port=8080
   # Access at: http://localhost:8080
   ```

10. **Check Laravel logs:**
    ```bash
    # View recent errors
    type storage\logs\laravel.log
    # Or use PowerShell
    Get-Content storage\logs\laravel.log -Tail 50
    ```

### Issue: "Class 'PDF' not found"
- Make sure you've run `composer install`
- The DomPDF package should be installed automatically

### Issue: "Storage link not found"
- Run: `php artisan storage:link`
- Ensure the `public/storage` directory exists

### Issue: "Permission denied" (Linux/Mac)
- Set proper permissions:
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Issue: "Vite manifest not found"
- Make sure you've run `npm run dev` or `npm run build`
- For production: `npm run build`

### Issue: Database connection errors
- Verify your `.env` database credentials
- Ensure MySQL service is running
- For SQLite, ensure the database file exists and is writable

### Issue: "Route not found" or 404 errors
- Clear route cache: `php artisan route:clear`
- Clear all caches: `php artisan optimize:clear`

## Production Build

For production deployment:

```bash
# Build frontend assets
npm run build

# Optimize Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Additional Notes

- The application uses **Laravel Breeze** for authentication
- **Laravel Sanctum** is configured for API authentication
- PDF generation uses **DomPDF** with barcode support
- The app uses **Tailwind CSS** for styling
- **Alpine.js** is included for interactive components

## Development Tools

- **Laravel Pail**: Real-time log viewer (included in `composer run dev`)
- **Laravel Pint**: Code formatter (run `./vendor/bin/pint`)
- **PHPUnit**: Testing framework (run `php artisan test`)
