# MA Hospitality & Mart — Catering Booking, Inventory & Sales Management System

PSA Project — Aisha Dauda (Student ID: 01025076873), BIT Software Engineering, Semester 4,
Lincoln University College.

A Laravel 10 web application that centralizes supermarket inventory, sales records and
catering bookings for MA Hospitality & Mart, with automatic double-booking prevention for
catering events.

## Tech stack
- **Backend:** PHP 8.1+ / Laravel 10
- **Database:** MySQL
- **Frontend:** Blade + Tailwind CSS (CDN, no build step) + vanilla JavaScript

## Features

### Public storefront (no login required)
- **Home** (`/`) — hero banner + featured products
- **Shop** (`/shop`) — browse/search/filter products by category, add to cart
- **Cart** (`/cart`) — session-based cart, update quantities, remove items
- **Checkout** (`/checkout`) — customer details + delivery address, places an order
  (payment is on delivery/pickup — no online payment gateway, matching the proposal's
  excluded scope) and automatically deducts stock
- **Book Catering** (`/book-catering`) — public booking request form with the same live
  AJAX date-availability check as the staff panel; submissions land as `pending` bookings
  for staff to confirm

### Staff admin panel (login required, at `/login`)
- Dashboard — product count, low-stock alerts, today's/month's sales, upcoming bookings,
  and a "needs attention" banner for new online orders / customer booking requests
- Inventory — add/edit/delete products, stock levels, reorder-level low-stock flagging
- Sales — record in-store sales (multi-item, auto stock deduction) **and** see/manage
  online orders placed through the storefront (marked "Online" + "Pending" until staff
  mark them fulfilled)
- Customers — add/edit/delete customer records (shared with storefront checkouts/bookings)
- Catering Bookings — create/edit/delete; each booking shows whether it came from staff or
  a customer's online request; the double-booking check runs both client-side (AJAX) and
  server-side (can't be bypassed) on both the public and staff forms
- Reports — sales totals/count for a date range, top-selling products, low-stock list,
  catering bookings in the period by status

## How online orders and booking requests flow to staff
- A storefront checkout creates a `Sale` with `channel = online`, `status = pending`. It
  shows up in **Sales** with an "Online"/"Pending" badge; staff click **Mark Fulfilled**
  once it's prepared/delivered.
- A public catering request creates a `CateringBooking` with `source = customer`,
  `status = pending`. It shows up in **Catering Bookings** with a "Customer request" badge;
  staff edit it to change status to `confirmed` (or `cancelled`).
- Both flows re-use the exact same `Customer` model — a phone number match reuses an
  existing customer record instead of creating duplicates.

## Project structure
Standard Laravel structure. Notable spots:
- `app/Models/CateringBooking.php` — `isDateAvailable()` implements the conflict check
- `app/Http/Controllers/CateringBookingController.php` — staff-side booking management;
  `checkAvailability()` is the AJAX endpoint
- `app/Http/Controllers/Storefront/` — the public-facing site (Home, Shop, Cart, Checkout,
  CateringRequest controllers), all reusing the same `isDateAvailable()` and stock logic
- `app/Http/Controllers/SaleController.php` — staff sales; `fulfil()` marks an online order
  as completed
- `database/seeders/DatabaseSeeder.php` — demo login accounts + sample products/customers

## 1. Run it locally (do this first, before hosting)

You'll need PHP 8.1+, Composer, and MySQL installed.

```bash
cd psa-ma-hospitality
composer install
cp .env.example .env
php artisan key:generate
```

Open `.env` and set your MySQL credentials:
```
DB_DATABASE=ma_hospitality
DB_USERNAME=root
DB_PASSWORD=your_password
```

Create the database (in MySQL: `CREATE DATABASE ma_hospitality;`), then:

```bash
php artisan migrate --seed
php artisan serve
```

Visit `http://127.0.0.1:8000`. Demo logins:
- **Admin:** admin@mahospitalityandmart.test / password
- **Staff:** staff@mahospitalityandmart.test / password

Change these passwords (or the seeded emails) before your defence/demo.

## 2. Hosting it

Since submission is coming up, pick whichever of these is fastest for you:

### Option A — Railway or Render (recommended, free tier, real Laravel+MySQL host)
Both platforms run PHP and provision a MySQL database for you, and both deploy straight
from a GitHub repo.

1. Push this project to a GitHub repo.
2. On Railway: New Project → Deploy from GitHub repo → add a MySQL plugin → set the `DB_*`
   env vars (and `APP_KEY`, `APP_ENV=production`) to match what Railway gives you.
3. Add a **Start Command**: `php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT`
   (or use Railway's Nixpacks PHP builder, which auto-detects Laravel).
4. Render works the same way — "New Web Service" from your repo, add a MySQL instance,
   set env vars, and use a build command of `composer install --no-dev` with a start
   command similar to the one above.

This is the closest to how the app runs locally and is the safest choice for a working demo.

### Option B — Shared cPanel hosting (InfinityFree, 000webhost, Hostinger)
Common for Nigerian student projects. The catch: most free shared hosts don't give you
SSH/Composer access, so you'll need to run `composer install` **locally first**, then
upload the whole project including the generated `vendor/` folder.

1. Locally: `composer install --no-dev --optimize-autoloader`
2. Zip the whole project (including `vendor/`) and upload via the host's File Manager, or
   use FTP.
3. Point the domain's document root at the `public/` folder (cPanel: "Domains" → set
   document root to `public`). If you can't change the document root, copy everything
   from `public/` into the domain root and edit `index.php`'s two `require` paths to point
   up to `../vendor/autoload.php` and `../bootstrap/app.php` accordingly.
4. Create a MySQL database and user from cPanel, update `.env` with those credentials.
5. Since you likely won't have terminal access, run migrations from a one-off script: add a
   temporary route like `Route::get('/migrate-now', fn () => Artisan::call('migrate', ['--seed' => true]))`,
   hit it once in the browser, then **delete that route immediately**.
6. Set `APP_ENV=production` and `APP_DEBUG=false` in `.env` before going live.

### Option C — A cheap Nigerian/African VPS or shared host with SSH (e.g. Hostinger
Business, Qservers, Whogohost)
If your host gives you SSH access, it's just: upload the project (without `vendor/`), SSH
in, run the same `composer install` / `.env` / `php artisan migrate --seed` steps as local
setup, and point the web server's document root at `public/`.

## Notes for your defence
- The OOP class design in the proposal maps directly onto the Eloquent models in
  `app/Models/` — e.g. `CateringBooking::checkAvailability()` is realized as the static
  `isDateAvailable()` method, called both from the AJAX endpoint (live UI feedback) and
  again inside `store()`/`update()` (server-side guarantee, so it can't be bypassed).
- `Sale::calculateTotal()` and the `SaleController@store` stock-deduction logic together
  cover the sales/inventory link from the proposal's scope table.
- Reports cover the "basic reports" requirement: sales, stock and catering summaries for
  a selectable date range.
