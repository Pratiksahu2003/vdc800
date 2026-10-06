# VDC800 — Sustainable Nordic Data Centres

A full-stack marketing website and content management system for **VDC800 Data Centres**. Built with Laravel 13, Tailwind CSS 4, Alpine.js, and GSAP. Includes a public-facing site with mega-menu navigation, blog, data centre listings, contact forms with maps, and a complete admin panel to manage all content.

**Copyright © [VedMint](https://vedmint.com). All rights reserved.**

This project is proprietary software. Unauthorized copying, distribution, or modification is prohibited without written permission from VedMint.

---

## Features

### Public website
- Homepage with hero carousel, statistics, benefits, infrastructure section, services/solutions previews, blog insights, client reviews slider, and CTA
- **Services** and **Solutions** listing and detail pages with SEO fields
- **Blog** with categories, filtering, and article pages
- **Data Centre** listing and per-facility detail pages (specs, features, gallery)
- **About** and **Contact** pages
- Embedded **Google Map** on contact page (admin-configurable map link)
- Mega-menu navigation for Services, Solutions, and Blog
- Auto-generated **sitemap.xml** and **robots.txt**
- Responsive Nordic-themed UI with GSAP animations

### Admin panel (`/admin`)
- Dashboard with content overview
- **Company settings** — contact info, address, Google Maps link
- **Branding** — logos and favicon upload
- **Website settings** — SEO, GTM, language defaults
- **Social links** management
- **Homepage** — hero slides, intro, sustainability, infrastructure, benefits, statistics, final CTA
- **About** page and company values
- **Services** and **Solutions** CRUD with drag-and-drop image uploads
- **Data Centres** — multiple facilities, specs, features, gallery
- **Blog** — categories and posts
- **Contact submissions** inbox
- **Media library**
- Admin profile and password change

---

## Tech stack

| Layer | Technology |
|-------|------------|
| Backend | PHP 8.3+, Laravel 13 |
| Database | SQLite (default) — MySQL/MariaDB supported |
| Frontend | Blade, Tailwind CSS 4, Alpine.js, GSAP, Lucide icons |
| Build | Vite 7 |
| Auth | Laravel session auth with admin middleware |

---

## Requirements

- **PHP** 8.3 or higher with extensions: `pdo`, `sqlite3` (or `pdo_mysql`), `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `fileinfo`
- **Composer** 2.x
- **Node.js** 20+ and **npm** 10+
- **Git**

Optional for local development:
- [Laravel Herd](https://herd.laravel.com) (Windows/macOS) — serves `https://VDC800.test` automatically
- Or `php artisan serve` for `http://localhost:8000`

---

## Quick start

### 1. Clone the repository

```bash
git clone <repository-url> VDC800
cd VDC800
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Environment configuration

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` and set at minimum:

```env
APP_NAME=VDC800
APP_URL=https://VDC800.test
ADMIN_PASSWORD=your-secure-password
```

> Use `http://localhost:8000` if you run `php artisan serve` instead of Herd.

### 4. Database setup

SQLite is used by default. Create the database file and run migrations with demo content:

```bash
# Windows (PowerShell)
New-Item -ItemType File -Force -Path database\database.sqlite

# macOS / Linux
touch database/database.sqlite

php artisan migrate:fresh --seed
```

This seeds:
- Admin user, company & site settings
- 12 services and 12 solutions with SEO content
- 2 data centres (Oslo, Stockholm)
- 20 blog posts across 5 categories
- Homepage content, hero slides, testimonials, and more

### 5. Storage link (required for admin uploads)

```bash
php artisan storage:link
```

### 6. Frontend assets

**Production build:**

```bash
npm install
npm run build
```

**Development (with hot reload):**

```bash
npm install
npm run dev
```

### 7. Run the application

**Option A — Laravel Herd (recommended)**

Place the project in your Herd sites folder. Visit:

```
https://VDC800.test
```

**Option B — Artisan serve**

```bash
php artisan serve
```

Visit `http://localhost:8000`.

**Option C — Full dev stack (server + queue + logs + Vite)**

```bash
composer dev
```

---

## Default admin login

| Field | Value |
|-------|-------|
| URL | `/admin/login` |
| Email | `admin@example.com` |
| Password | Value of `ADMIN_PASSWORD` in `.env` (default: `password`) |

Change the admin password immediately after first login via **Admin → Profile**.

---

## Useful commands

| Command | Description |
|---------|-------------|
| `php artisan migrate:fresh --seed` | Reset database and load demo data |
| `php artisan storage:link` | Enable public access to uploaded files |
| `php artisan sitemap:generate` | Regenerate `public/sitemap.xml` and `public/robots.txt` |
| `php artisan cache:clear` | Clear application cache (settings are cached) |
| `npm run build` | Compile production CSS/JS to `public/build/` |
| `npm run dev` | Start Vite dev server with HMR |
| `composer dev` | Run server, queue, logs, and Vite concurrently |
| `php artisan test` | Run PHPUnit tests |

---

## Environment variables

| Variable | Description | Default |
|----------|-------------|---------|
| `APP_NAME` | Application name | `VDC800` |
| `APP_URL` | Public site URL (used in sitemap) | `http://localhost` |
| `APP_DEBUG` | Debug mode — set `false` in production | `true` |
| `DB_CONNECTION` | Database driver | `sqlite` |
| `ADMIN_PASSWORD` | Initial admin password for seeder | `password` |
| `FILESYSTEM_DISK` | Upload disk | `local` |
| `MAIL_*` | Mail settings for contact notifications | `log` driver in dev |

For **MySQL**, update `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=VDC800
DB_USERNAME=root
DB_PASSWORD=
```

Then run `php artisan migrate:fresh --seed`.

---

## Project structure

```
VDC800/
├── app/
│   ├── Http/Controllers/     # Public & admin controllers
│   ├── Models/               # Eloquent models
│   ├── Services/             # Site settings, sitemap generator
│   └── helpers.php           # settings(), logo_url(), favicon_url(), etc.
├── database/
│   ├── migrations/
│   └── seeders/              # DatabaseSeeder, BlogSeeder, ServiceSolutionSeeder
├── public/
│   ├── Logo/                 # Static logo & favicon.ico
│   ├── images/               # Hero, service, solution, blog images
│   ├── build/                # Vite compiled assets
│   ├── sitemap.xml
│   └── robots.txt
├── resources/
│   ├── css/app.css
│   ├── js/app.js             # Alpine components (carousel, reviews, uploads)
│   └── views/                # Blade templates & components
└── routes/web.php            # All public and admin routes
```

---

## Public routes

| URL | Page |
|-----|------|
| `/` | Homepage |
| `/services` | Services listing |
| `/services/{slug}` | Service detail |
| `/solutions` | Solutions listing |
| `/solutions/{slug}` | Solution detail |
| `/data-centre` | Data centre listing |
| `/data-centre/{slug}` | Facility detail |
| `/blog` | Blog listing (optional `?category=slug`) |
| `/blog/{slug}` | Blog article |
| `/about` | About page |
| `/contact` | Contact form + map |
| `/admin` | Admin panel |

---

## Production deployment

1. Set `APP_ENV=production`, `APP_DEBUG=false`, and correct `APP_URL`
2. Run `composer install --no-dev --optimize-autoloader`
3. Run `php artisan migrate --force` (omit `--seed` on production unless intentional)
4. Run `php artisan storage:link`
5. Run `npm ci && npm run build`
6. Run `php artisan config:cache`, `php artisan route:cache`, `php artisan view:cache`
7. Run `php artisan sitemap:generate`
8. Ensure `storage/` and `bootstrap/cache/` are writable by the web server
9. Point the web server document root to `public/`
10. Set a strong `ADMIN_PASSWORD` before seeding, or change password after deploy

---

## Branding assets

Static branding files live in `public/Logo/`:

- `logo.png` — main logo
- `favicon.ico` — site favicon (multi-size)

Admins can override logos and favicon from **Admin → Settings → Branding**. Company map settings are under **Admin → Settings → Company**.

---

## Support & licensing

**Developed by [VedMint](https://vedmint.com)**

For support, customisation, or licensing enquiries, visit [https://vedmint.com](https://vedmint.com).

**© VedMint. All rights reserved.**
