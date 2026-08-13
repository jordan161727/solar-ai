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

## Installation

### Requirements

- PHP >= 8.2
- Composer
- Node.js >= 18 & npm
- MySQL / MariaDB

### Setup

1. **Clone the repository**

```bash
git clone <repository-url>
cd <project-folder>
```

2. **Install PHP dependencies**

```bash
composer install
```

3. **Install JavaScript dependencies**

```bash
npm install
```

4. **Create the environment file**

```bash
cp .env.example .env
```

   On Windows: `copy .env.example .env`

5. **Generate the application key**

```bash
php artisan key:generate
```

6. **Configure the database**

   Open `.env`, set `DB_CONNECTION` to `mysql`, then uncomment the remaining `DB_*` lines
   (they ship commented out) and fill in your credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=root
DB_PASSWORD=
```

   Create the database first — Laravel will not create it for you:

```sql
CREATE DATABASE your_database_name CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

7. **Add your Google API key**

   The property form, satellite previews and roof analysis all call Google. Set this in
   `.env` or those features will fail:

```env
GOOGLE_MAPS_API_KEY=your_key_here
```

   Enable **Places API (New)**, **Maps Static API** and **Solar API** on the key in Google
   Cloud. Every call is made server-side, so restrict the key by **IP address**, not by
   HTTP referrer — a referrer restriction rejects server-to-server calls.

   `GOOGLE_SOLAR_API_KEY` and `GOOGLE_PLACES_API_KEY` are optional; both fall back to
   `GOOGLE_MAPS_API_KEY` when unset.

8. **Run the migrations and seed the demo data**

```bash
php artisan migrate --seed
```

   Every page in the app sits behind authentication, so seeding matters: it creates the
   login below plus sample customers and properties. Without `--seed` the database has no
   users and you will have to register an account first.

   | Email | Password |
   | --- | --- |
   | `admin@solarai.test` | `password` |

9. **Create the storage symlink**

   Required — uploaded roof images are served from the `public` disk.

```bash
php artisan storage:link
```

10. **Build the frontend assets**

```bash
npm run dev
```

    For production: `npm run build`

11. **Start the development server**

    In a second terminal:

```bash
php artisan serve
```

    The app will be available at [http://localhost:8000](http://localhost:8000), which
    redirects to the login page.

### Useful commands

| Command | Description |
| --- | --- |
| `composer dev` | Run the server, queue worker, log viewer and Vite together |
| `php artisan migrate:fresh --seed` | Drop all tables, re-run migrations, re-seed |
| `php artisan optimize:clear` | Clear config, route, view and cache files |
| `php artisan queue:work` | Process queued jobs |
| `php artisan test` | Run the test suite |

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

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
