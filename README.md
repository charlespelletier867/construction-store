# Construction Store Management System with POS

Multi-branch construction store management system built with **Laravel 12**, **Vue 3 + Inertia + Ziggy**, **Bootstrap 5**, with Khmer / English language switching and a Vue-based POS.

## Stack

- Laravel 12, PHP 8.3
- Vue 3 + Inertia.js + Ziggy
- Bootstrap 5
- Yajra DataTables (server-side, Bootstrap 5 pagination)
- SweetAlert2 (delete confirmations)
- PHP Flasher (Sweet Alert) for success notifications
- flatpickr (date/datetime fields)
- Tom Select (select dropdowns)
- vue-i18n + `[data-i18n]` for no-refresh language switching (English / ខ្មែរ)

## Quick start

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate:fresh --seed --force
npm install
npm run build
php artisan serve
```

Open http://127.0.0.1:8000 and log in with:

| Email               | Password   |
| ------------------- | ---------- |
| admin@demo.local    | `password` |
| cashier@demo.local  | `password` |

## Modules

- **Foundation** — companies, branches, warehouses, users, roles, permissions
- **Master data** — categories, units, brands, products, suppliers, customers
- **POS** (Vue 3) — product search, cart, payment, stock deduction, receipt
- **Sales** — invoices, payments, returns, quotations
- **Purchases** — invoices, payments, returns
- **Inventory** — transfers, adjustments, damaged stock, stock movements
- **Delivery** — deliveries, drivers, vehicles, vehicle expenses
- **Finance** — expenses, expense categories, customer/supplier ledgers
- **Reports** — sales, stock, profit, payable, receivable, branch performance
- **Administration** — settings, number sequences, document templates, audit logs

## Layout

The admin shell uses separate Blade partials as requested:

```
resources/views/admin/layouts/
├── admin_layout.blade.php
└── admin_partials/
    ├── head.blade.php
    ├── header.blade.php
    ├── scripts.blade.php
    └── left_sidebar.blade.php
```

## Language switching (no refresh)

- Server side: `POST /locale/{en|km}` stores in session, `SetLocale` middleware applies it.
- Blade side: each translatable element has `data-i18n="key"`; `applyDomTranslations(locale)` in `resources/js/app.js` rewrites text instantly.
- Vue side: `vue-i18n` reads from `window.__APP_TRANSLATIONS__`.

## Notes

- SQLite is used for development. Switch `DB_CONNECTION` in `.env` to `mysql` / `pgsql` for production.
- The migration file is intentionally one large file; all 50 tables are created in a single migration.
