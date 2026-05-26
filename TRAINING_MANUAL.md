# មេរៀនប្រើប្រាស់ប្រព័ន្ធ — Construction Store Management System with POS
# (Training Manual)

> **ជំពូកទី ១ — ទិដ្ឋភាពទូទៅ (Overview)**

---

## ១.១ អ្វីជា Project នេះ?

**Construction Store Management System with POS** គឺជា Web Application សម្រាប់គ្រប់គ្រងហាងលក់សម្ភារសំណង់បែបពហុសាខា (multi-branch construction material store)។ ប្រព័ន្ធនេះរួមមាន៖

- **POS (Point of Sale)** ផ្នែកលក់រហ័សដោយប្រើ Vue 3 — ស្វែងរកផលិតផល បន្ថែមទៅកន្ត្រក ទូទាត់ កាត់ស្តុក និងបោះពុម្ពវិក្កយបត្រ។
- **Sales / Purchases / Quotations / Returns** — ការគ្រប់គ្រងវិក្កយបត្រលក់-ទិញ ការត្រឡប់ និងតម្លៃផ្ដល់ជូន។
- **Inventory & Stock** — ស្តុកនៅតាមឃ្លាំង ការផ្ទេរស្តុក ការកែតម្រូវស្តុក ស្តុកខូច និងចលនាស្តុក។
- **Delivery** — អ្នកបើកបរ យានយន្ត ការដឹកជញ្ជូន និងភស្តុតាងដឹក។
- **Finance** — ការចំណាយ ប្រភេទចំណាយ និងបញ្ជី (ledger) របស់អតិថិជន/ផ្គត់ផ្គង់។
- **Reports** — របាយការណ៍លក់ ស្តុក ប្រាក់ចំណេញ ប្រាក់ត្រូវសង/ត្រូវយក និងលទ្ធផលតាមសាខា។
- **Administration** — ក្រុមហ៊ុន សាខា ឃ្លាំង អ្នកប្រើ តួនាទី សិទ្ធិ ការកំណត់ប្រព័ន្ធ លេខលំដាប់ឯកសារ ពុម្ពឯកសារ និងកំណត់ត្រាសវនកម្ម (audit log)។

ប្រព័ន្ធនេះគាំទ្រការប្ដូរភាសាភ្លាមៗ (**English ↔ ខ្មែរ**) ដោយមិនបាច់ផ្ទុកទំព័រឡើងវិញ និងគាំទ្រ ការប្ដូរសាខា (branch switching) តាម session។

## ១.២ បច្ចេកវិទ្យាដែលប្រើ (Tech Stack)

| ផ្នែក | បច្ចេកវិទ្យា |
|---|---|
| Backend Framework | **Laravel 12** (PHP 8.2+, recommended PHP 8.3) |
| Auth | **Laravel built-in session auth** (custom `Admin\Auth\LoginController`, no Breeze/Jetstream) |
| RBAC | តារាង `roles` / `permissions` / `role_permissions` ផ្ទាល់ខ្លួន + `spatie/laravel-permission` ៦.x (installed but optional) |
| Frontend JS | **Vue 3** + **Inertia.js** + **Ziggy** (routes), **jQuery** for DataTables |
| Frontend CSS | **Bootstrap 5** (មិនមែន Tailwind) |
| Build Tool | **Vite 7** + `@vitejs/plugin-vue` + `laravel-vite-plugin` |
| Database | **SQLite** (default for dev) ឬ **MySQL / PostgreSQL** សម្រាប់ production |
| DataTables | **Yajra DataTables** (server-side) + `datatables.net-bs5` |
| Notifications | **PHP-Flasher (SweetAlert)** ខាង server + **SweetAlert2** ខាង client |
| Date Picker | **Flatpickr** |
| Select Box | **Tom Select** |
| i18n | **vue-i18n** + Blade `[data-i18n]` attribute |

> **ចំណាំ**: `composer.json` រួមមាន `spatie/laravel-permission` ៦.x ប៉ុន្តែ project នេះប្រើតារាង `roles`, `permissions`, `role_permissions` ផ្ទាល់ខ្លួន (custom). សិទ្ធិត្រូវបានពិនិត្យតាម method `User::hasPermission($slug)` ដែលអាន `permissions.slug` ឧ. `product.view`, `sale.create`, `report.export` ។ល។

## ១.៣ រចនាសម្ព័ន្ធ Project (Folder Structure)

```
construction-store/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/                       # 50+ admin controllers
│   │   │   │   ├── Auth/LoginController.php # ការ login / logout
│   │   │   │   ├── BaseCrudController.php   # មូលដ្ឋាន CRUD generic
│   │   │   │   ├── SchemaResourceController.php # CRUD ដែលអានពី schema ដោយស្វ័យប្រវត្តិ
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── POSController.php        # API ឆ្ពោះទៅ POS Vue island
│   │   │   │   ├── ReportsController.php
│   │   │   │   ├── BranchSwitchController.php
│   │   │   │   └── …                          # រាល់ module CRUD
│   │   │   └── LocaleController.php         # POST /locale/{en|km}
│   │   └── Middleware/
│   │       ├── HandleInertiaRequests.php    # Inertia shared props (auth, locale, ziggy, …)
│   │       ├── SetCurrentBranch.php         # រក្សា current_branch_id ក្នុង session
│   │       └── SetLocale.php                # តម្រូវភាសាជា en|km
│   ├── Models/                                # 51 Eloquent Models
│   ├── Services/
│   │   ├── NumberSequenceService.php        # បង្កើតលេខឯកសារ (INV-, PAY-, …)
│   │   └── StockService.php                 # ផ្លាស់ប្ដូរស្តុក + record movement
│   └── Providers/AppServiceProvider.php
├── bootstrap/app.php                          # Laravel 12 bootstrapper + middleware
├── config/
│   ├── permission.php                         # Spatie config (installed but not actively used)
│   ├── datatables.php                         # Yajra config
│   └── …                                       # auth, database, session, mail, …
├── database/
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php          # Laravel default (sessions etc.)
│   │   ├── 0001_01_01_000001_create_cache_table.php
│   │   ├── 0001_01_01_000002_create_jobs_table.php
│   │   └── 2026_05_13_000000_create_construction_store_all_in_one_schema.php  # 48+ business tables
│   ├── factories/UserFactory.php
│   └── seeders/                                # 21 seeders + DatabaseSeeder
├── lang/
│   ├── en/admin.php                            # English UI strings
│   └── km/admin.php                            # Khmer UI strings
├── resources/
│   ├── views/
│   │   ├── app.blade.php                       # Inertia root (used by Inertia pages)
│   │   └── admin/
│   │       ├── auth/login.blade.php
│   │       ├── dashboard/index.blade.php
│   │       ├── layouts/
│   │       │   ├── admin_layout.blade.php      # Master layout
│   │       │   └── admin_partials/
│   │       │       ├── head.blade.php
│   │       │       ├── header.blade.php
│   │       │       ├── left_sidebar.blade.php
│   │       │       └── scripts.blade.php
│   │       ├── _partials/                      # generic_index, generic_form, datatable, actions, …
│   │       ├── pos/index.blade.php             # ផ្ទុក POSApp Vue island
│   │       └── <module>/                       # index/create/edit/show blades per module
│   └── js/
│       ├── app.js                              # entry; Vite, Inertia, vue-i18n, DataTables, Flatpickr, …
│       ├── bootstrap.js
│       └── Pages/POS/POSApp.vue                # Vue 3 POS UI
├── routes/
│   ├── web.php                                 # public + auth + admin (groups)
│   └── admin/
│       ├── master_data.php
│       ├── transactions.php
│       ├── inventory.php
│       ├── delivery.php
│       ├── finance.php
│       ├── administration.php
│       ├── reports.php
│       └── pos.php
├── public/                                     # entry / assets
├── tests/                                      # Feature + Unit (skeleton)
├── vite.config.js
├── composer.json
├── package.json
├── README.md
└── TRAINING_MANUAL.md                          # ឯកសារនេះ
```

---

> **ជំពូកទី ២ — ការដំឡើង (Installation & Setup)**

---

## ២.១ តម្រូវការប្រព័ន្ធ (System Requirements)

- **PHP** 8.2 ឬខ្ពស់ជាង (recommended **8.3**)
- **Composer** ជំនាន់ចុងក្រោយ
- **Node.js** 18+ និង **NPM** (`package.json` ប្រើ Vite 7)
- **Database** — SQLite (default for dev) ឬ MySQL 8 / PostgreSQL 14+
- **Web server** — `php artisan serve` (dev) ឬ Nginx / Apache (prod)

## ២.២ ជំហានដំឡើង (Quick Start)

ដូចក្នុង [`README.md`](README.md) ផងដែរ៖

```bash
# 1) Clone project
git clone https://github.com/charlespelletier867/construction-store.git
cd construction-store

# 2) Install PHP dependencies
composer install

# 3) កំណត់ environment
cp .env.example .env
php artisan key:generate

# 4) បង្កើត database SQLite (សម្រាប់ dev)
touch database/database.sqlite

# 5) Run migrations + seed demo data
php artisan migrate:fresh --seed --force

# 6) Install JS dependencies + build frontend
npm install
npm run build       # ឬ npm run dev សម្រាប់ Vite hot-reload

# 7) Start server
php artisan serve
```

បើក browser ទៅ <http://127.0.0.1:8000> ។ ប្រព័ន្ធនឹង redirect ទៅ `/login` ដោយស្វ័យប្រវត្តិ។

> **ចំណាំ**៖ មាន composer script `composer setup` និង `composer dev` ដែលអាចហៅពាក្យបញ្ជារួមក្នុងជំហានតែមួយ៖
> - `composer setup` — install + .env + key:generate + migrate + npm install + npm run build
> - `composer dev` — ដំណើរការ `php artisan serve`, `queue:listen`, `pail` (logs), និង `vite` ដោយប្រើ `concurrently`

## ២.៣ ការផ្ដាស់ប្ដូរទៅ MySQL (Optional)

កែ `.env` ដូចខាងក្រោម៖

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=construction_store
DB_USERNAME=root
DB_PASSWORD=
```

រួចបង្កើត database ឈ្មោះ `construction_store` ហើយ run `php artisan migrate:fresh --seed --force` ម្ដងទៀត។

> **ចំណាំ**៖ migration ដាក់ `Schema::disableForeignKeyConstraints()` ដើម្បីឱ្យដំណើរការបានទាំង SQLite និង MySQL។ Seeder `DatabaseSeeder` ក៏បិទ `FOREIGN_KEY_CHECKS` សម្រាប់ MySQL ដែរ។

## ២.៤ គណនី Default (Login Credentials)

បន្ទាប់ពី `php artisan db:seed` (ឬ `migrate:fresh --seed`) មាន ៦ គណនី demo (សុទ្ធតែលេខសម្ងាត់ = `password`)៖

| Email | Role (slug) | មុខងារ |
|---|---|---|
| `superadmin@demo.local` | `super-admin` | សិទ្ធិទាំងអស់ |
| `admin@demo.local` | `admin` | គ្រប់គ្រងក្រុមហ៊ុនទាំងមូល |
| `manager1@demo.local` | `branch-manager` | គ្រប់គ្រងសាខា |
| `cashier1@demo.local` | `cashier` | លក់ POS តែប៉ុណ្ណោះ |
| `warehouse1@demo.local` | `warehouse-staff` | គ្រប់គ្រងស្តុក |
| `accountant1@demo.local` | `accountant` | ហិរញ្ញវត្ថុ និងគណនេយ្យ |

> **សុវត្ថិភាព**: ប្ដូរលេខសម្ងាត់ភ្លាមនៅពេលដំឡើងលើ production។

---

> **ជំពូកទី ៣ — រចនាសម្ព័ន្ធទិន្នន័យ (Database Architecture)**

---

## ៣.១ All-in-one Migration

តារាងពាណិជ្ជកម្មទាំងអស់ត្រូវបានបង្កើតក្នុង file តែមួយ៖

```
database/migrations/2026_05_13_000000_create_construction_store_all_in_one_schema.php
```

រួមមាន **៤៨ តារាងពាណិជ្ជកម្ម (business tables)** + **៣ តារាងស្តង់ដារ Laravel** (`users` redefined, `password_reset_tokens`, `sessions`) = **៥១ tables**។ បន្ថែម migration ស្តង់ដារសម្រាប់ `cache`, `cache_locks`, `jobs`, `job_batches`, `failed_jobs` ។

## ៣.២ ក្រុមតារាងសំខាន់ (Table Groups)

| # | Group | Tables | គោលបំណង |
|---|---|---|---|
| 1 | **Foundation** | `companies` | ក្រុមហ៊ុនជាស្នូល (multi-tenant friendly) |
| 2 | **Roles & Permissions** | `roles`, `permissions`, `role_permissions` | RBAC ផ្ទាល់ខ្លួន |
| 3 | **Users** | `users` (re-defined), `user_branch_roles` | អ្នកប្រើ និងតួនាទីពហុសាខា |
| 4 | **Branches & Warehouses** | `branches`, `warehouses` | សាខា និងឃ្លាំងស្តុក |
| 5 | **Product Master Data** | `categories` (self-referencing), `units`, `brands`, `products` | ប្រភេទ ឯកតា ម៉ាក និងផលិតផល |
| 6 | **Contacts** | `suppliers`, `customers` | អ្នកផ្គត់ផ្គង់ និងអតិថិជន |
| 7 | **Stock Core** | `stock_balances`, `stock_movements`, `stock_adjustments`, `stock_adjustment_items`, `damaged_stocks` | ស្តុកបច្ចុប្បន្ន ចលនាស្តុក និងការកែតម្រូវ |
| 8 | **Purchases** | `purchase_invoices`, `purchase_items`, `purchase_payments`, `purchase_returns`, `purchase_return_items` | ការទិញ ការទូទាត់ និងការត្រឡប់ |
| 9 | **Sales** | `sale_invoices`, `sale_items`, `sale_payments`, `sale_returns`, `sale_return_items` | ការលក់ ការទូទាត់ និងការត្រឡប់ |
| 10 | **Quotations** | `quotations`, `quotation_items` | តម្លៃផ្ដល់ជូន (អាច convert ទៅ sale) |
| 11 | **Delivery** | `drivers`, `vehicles`, `vehicle_expenses`, `deliveries`, `delivery_proofs` | ការដឹកជញ្ជូន |
| 12 | **Stock Transfer** | `stock_transfers`, `stock_transfer_items` | ការផ្ទេរសម្ភារពីឃ្លាំងមួយទៅឃ្លាំងមួយ |
| 13 | **Finance** | `expense_categories`, `expenses`, `customer_ledger_entries`, `supplier_ledger_entries` | ការចំណាយ និងបញ្ជី (ledger) |
| 14 | **System** | `notifications`, `audit_logs`, `login_histories`, `system_settings`, `number_sequences`, `document_templates`, `attachments` | ការកំណត់ប្រព័ន្ធ និងសវនកម្ម |

## ៣.៣ Relationships សំខាន់ៗ

```
Company (1)
├── Branches (N)
│   ├── Warehouses (N)
│   ├── StockBalances (N)            ── Product (N)
│   ├── StockMovements (N)           ── Product, Warehouse, references SaleInvoice / PurchaseInvoice / …
│   ├── SaleInvoices (N)             ── Customer, Cashier(User), Warehouse
│   │   ├── SaleItems (N)            ── Product, Unit
│   │   ├── SalePayments (N)
│   │   └── SaleReturns (N)
│   │       └── SaleReturnItems (N)
│   ├── PurchaseInvoices (N)         ── Supplier, Warehouse
│   │   ├── PurchaseItems (N)        ── Product, Unit
│   │   ├── PurchasePayments (N)
│   │   └── PurchaseReturns (N)
│   │       └── PurchaseReturnItems (N)
│   ├── Quotations (N)               ── Customer (optional convert to SaleInvoice)
│   │   └── QuotationItems (N)
│   ├── StockTransfers (N)           ── from_warehouse, to_warehouse
│   │   └── StockTransferItems (N)
│   ├── StockAdjustments (N)
│   │   └── StockAdjustmentItems (N) ── Product
│   ├── DamagedStocks (N)            ── Product
│   ├── Expenses (N)                 ── ExpenseCategory
│   ├── Deliveries (N)               ── Driver, Vehicle, SaleInvoice (optional)
│   │   └── DeliveryProofs (N)
│   └── VehicleExpenses (N)          ── Vehicle, Driver
├── Users (N)                         ── Role (default), UserBranchRoles (M)
├── Roles (N) ── Permissions (M via role_permissions)
├── Categories (self-referencing parent_id)
├── Units / Brands / Products
├── Suppliers (with current_balance)
├── Customers (with current_balance, credit_limit)
├── Drivers / Vehicles
├── ExpenseCategories
├── SystemSettings (key/value, public/private)
├── NumberSequences (per company + branch + document_type)
├── DocumentTemplates (invoice/receipt/quotation/delivery template HTML)
└── Attachments (polymorphic: attachable_type + attachable_id)
```

## ៣.៤ Naming conventions

- **Primary keys**: `id` (bigint)
- **Foreign keys**: `<table_singular>_id` (ឧ. `branch_id`, `product_id`)
- **Money columns**: ប្រើ `decimal(18,2)` ឬ `decimal(18,4)` និងផ្ទុក KHR ឬ USD ដោយ `currency` column នៅលើ `companies`
- **Status / type columns**: ប្រើ `string` ជាជាង database enum ដើម្បីបត់បែន
- **Soft deletes**: តារាងគ្រឹះភាគច្រើនមាន `softDeletes()` (companies, users, branches, warehouses, products, customers, suppliers, sale_invoices, purchase_invoices, …)
- **Unique constraints**: ភាគច្រើនជា composite ឧ. `(company_id, product_code)`, `(company_id, sale_no)`, `(company_id, supplier_code)`

---

> **ជំពូកទី ៤ — រចនាសម្ព័ន្ធកម្មវិធី (Application Architecture)**

---

## ៤.១ Routing

`routes/web.php` កំណត់៖

1. **Public** — `/` redirect ទៅ login ឬ dashboard, និង `POST /locale/{en|km}` សម្រាប់ប្ដូរភាសា។
2. **Guest** — `GET /login`, `POST /login`
3. **Authenticated admin** (`/admin/...`) — `dashboard`, `branch.switch`, និងរួមបញ្ចូល route files មកពី `routes/admin/`:
   - `master_data.php` — products, categories, brands, units, customers, suppliers
   - `transactions.php` — sale_invoices/items/payments/returns, quotations
   - `inventory.php` — stock_balances/movements/transfers/adjustments/damaged_stocks
   - `delivery.php` — deliveries, delivery_proofs, drivers, vehicles, vehicle_expenses
   - `finance.php` — expenses, expense_categories, customer_ledger, supplier_ledger
   - `administration.php` — companies, branches, warehouses, users, roles, permissions, role_permissions, user_branch_roles, system_settings, number_sequences, document_templates, notifications, attachments, audit_logs, login_histories
   - `reports.php` — sales, stock, profit, payable, receivable, branch-performance
   - `pos.php` — pos.index, pos.search_products, pos.checkout

Route names ត្រូវបាន prefix ដោយ `admin.` ឧ. `admin.products.index`, `admin.pos.checkout` ។ Ziggy export route names ទៅ JavaScript សម្រាប់ Inertia/Vue ប្រើតាមរយៈ `route('admin.products.index')`.

## ៤.២ Middleware

នៅក្នុង `bootstrap/app.php` Middleware ខាងក្រោមត្រូវបាន append ទៅ `web` group ដោយស្វ័យប្រវត្តិ៖

| Middleware | មុខងារ |
|---|---|
| `SetLocale` | អានភាសាពី session, header `X-Locale`, ឬ config; បើ valid នោះ `App::setLocale()` |
| `SetCurrentBranch` | ប្រសិនបើ user login ហើយមិនទាន់មាន `current_branch_id` ក្នុង session នោះ default ទៅ `user.default_branch_id` ឬ branch ដំបូងរបស់ក្រុមហ៊ុន |
| `HandleInertiaRequests` | Share `auth`, `locale`, `translations[en|km]`, `flash`, `ziggy`, `current_branch` ទៅ Inertia |

Guest redirects: `redirectGuestsTo(fn () => route('admin.login'))`.

## ៤.៣ Controllers — BaseCrudController & SchemaResourceController

ដើម្បីកាត់បន្ថយ boilerplate, project នេះមាន base controllers ពីរ៖

### `BaseCrudController` (abstract)
- កំណត់ flow ស្តង់ដារ៖ `index` (DataTables JSON ឬ Blade view) → `create` → `store` → `show` → `edit` → `update` → `destroy`
- Subclass override:
  - `$modelClass`, `$viewPrefix`, `$routePrefix`, `$singular`, `$pluralLabel`
  - `tableColumns()` — DataTables columns
  - `formFields()` — form field definitions (name, type, label, options, rules, required, col, default, help)
  - `validationRules()` (optional)
  - `applyIndexQuery(Builder $q)` — បន្ថែម scope (company/branch)
  - `beforeStore/Update`, `afterSave` hooks
- Auto-scope ដោយ `company_id` ប្រសិន model មាន column នោះ
- បង្ហាញ notifications ដោយ `flash()->success(__('admin.alert.created|updated|deleted'))`

### `SchemaResourceController` (extends BaseCrudController)
- **អានគ្រោងពី database schema ដោយស្វ័យប្រវត្តិ** ដើម្បីបង្កើត form fields និង DataTables columns
- មាន `selectSources` map (`branch_id` → `Branch::class`, name; `product_id` → `Product::class`, name; ល។ល។)
- Subclass គ្រាន់តែប្រកាស `$modelClass` + `$viewPrefix` + `$routePrefix` ហើយ override `$indexColumns` ឬ `$fieldOverrides` តាមតម្រូវការ
- ត្រូវបានប្រើដោយ ~28 controllers (purchase_invoices, sale_invoices, stock_*, deliveries, ល។ល។)

> ProductsController, BranchesController, CategoriesController, និងផ្សេងទៀតប្រើ `BaseCrudController` ដោយផ្ទាល់សម្រាប់ការគ្រប់គ្រងលម្អិតបន្ថែម។

## ៤.៤ POS (Point of Sale) Module

POS គឺជា **Vue 3 island** ដែលត្រូវ mount ចូលក្នុង Blade page (មិនមែន full Inertia page)៖

1. Blade view `resources/views/admin/pos/index.blade.php` ផ្ដល់ `<div data-vue-island="POSApp" data-props='@json([...])'></div>`.
2. `resources/js/app.js` ស្គាល់ island name `POSApp` ហើយ mount Vue component `Pages/POS/POSApp.vue`.
3. Component ប្រើ `vue-i18n` សម្រាប់ UI strings (`t('pos.cart')`, `t('pos.grand_total')`, …)។

### Flow ខាងក្នុង

| ជំហាន | Endpoint | មុខងារ |
|---|---|---|
| 1. Open POS | `GET /admin/pos` | រាយ customers (active), warehouses របស់ branch |
| 2. Search product | `GET /admin/pos/search-products?q=...&warehouse_id=...` | ស្វែងរកតាម name/code/sku/barcode + return `quantity_on_hand` តាម `StockService::quantityOnHand()` |
| 3. Checkout | `POST /admin/pos/checkout` | Validate → `DB::transaction` → បង្កើត `sale_invoices` + `sale_items` + (បើ paid > 0) `sale_payments` → call `StockService::move()` ប្រសិន `product.track_stock` |

### លេខវិក្កយបត្រ (Document numbering)
- `NumberSequenceService::next('sale_invoice', $companyId, $branchId, 'INV-', 5)` ផ្ដល់លេខបន្ទាប់ ឧ. `INV-00001`.
- ឧបករណ៍នេះក៏ប្រើដោយ `sale_payment` (`PAY-`), `purchase_invoice`, ល។ល។ – Type ត្រូវ map ទៅ row ក្នុង `number_sequences` (company + branch + document_type unique)។

### ការទូទាត់ និងការគណនា
- `subtotal = Σ (quantity × unit_price − line_discount)`
- `grand_total = max(0, subtotal − discount_amount + tax_amount)`
- `change_amount = max(0, paid − grand_total)`
- `payment_status`: `paid` (paid ≥ grand_total) / `partial_paid` / `unpaid`

## ៤.៥ StockService

ស្តុកត្រូវរក្សាទុកទាំងជា **balance** (តារាង `stock_balances` per company/branch/warehouse/product) និងជា **movement** (តារាង `stock_movements` ដែលរក្សា audit trail)។

API សំខាន់៖

```php
$this->stock->move([
    'company_id'    => $companyId,
    'branch_id'     => $branchId,
    'warehouse_id'  => $warehouseId,
    'product_id'    => $productId,
    'movement_type' => 'sale' | 'purchase' | 'transfer_in' | 'transfer_out' | 'adjustment' | 'damage' | 'return_in' | 'return_out',
    'quantity'      => $signedQuantity,   // ឡើង + ចុះ −
    'unit_cost'     => $unitCost,
    'reference_type'=> SaleInvoice::class, // optional polymorphic ref
    'reference_id'  => $invoiceId,
    'created_by'    => $userId,
]);
```

- ប្រើ `lockForUpdate()` ដើម្បីការពារ race condition
- ធ្វើបច្ចុប្បន្នភាព `average_cost` តាមមធ្យមភាគថ្លៃរំកិលនៅពេលស្តុកចូល
- Recompute `available_quantity = quantity − reserved_quantity`

`quantityOnHand($productId, $branchId, $warehouseId = null)` ផ្ដល់ស្តុកសរុបបច្ចុប្បន្ន។

## ៤.៦ Layout & Frontend assets

Layout `resources/views/admin/layouts/admin_layout.blade.php` រួមមាន partials៖

```
admin_layout.blade.php
└── admin_partials/
    ├── head.blade.php      # meta, Vite @vite(['resources/css/app.css','resources/js/app.js']), CSRF
    ├── header.blade.php    # top bar, branch switcher, language switcher, user dropdown
    ├── left_sidebar.blade.php  # metismenu — Dashboard, POS, Products, Contacts, Sales, Purchases, Inventory, Delivery, Finance, Reports, Administration
    └── scripts.blade.php   # window.__APP_LOCALE__, window.__APP_TRANSLATIONS__
```

`resources/js/app.js` ៖

- Initialize **vue-i18n** ដោយយក translations ពី `window.__APP_TRANSLATIONS__` (ផ្ដល់ដោយ HandleInertiaRequests + scripts.blade)
- `applyDomTranslations(locale)` — re-translate `[data-i18n]` និង `[data-i18n-placeholder]` ភ្លាមៗ
- `switchLocale(locale)` — Update i18n + DOM + `POST /locale/{locale}` + reload DataTables AJAX
- Init Flatpickr & Tom Select on `.flatpickr` / `.tom-select`
- SweetAlert2 confirm-delete delegation សម្រាប់ `form.confirm-delete`
- Inertia setup (បើ `#app[data-page]` មាន) — auto-discover Pages ពី `resources/js/Pages/**/*.vue`
- Vue **island registry** — សម្រាប់ផ្ទុក component ដូច `POSApp` ចូលក្នុង Blade page

## ៤.៧ ការប្ដូរភាសា (No-refresh i18n)

មាន ៣ កម្រិត៖

| កម្រិត | របៀប |
|---|---|
| Server | `POST /locale/{en\|km}` → ដាក់ក្នុង session → `SetLocale` middleware ហៅ `App::setLocale()` |
| Blade | រាល់ element ដែលត្រូវប្ដូរ មាន `data-i18n="key"` ឧ. `<span data-i18n="menu.dashboard">{{ __('admin.menu.dashboard') }}</span>` |
| Vue / SPA | `vue-i18n` យកពី `window.__APP_TRANSLATIONS__` ដែលផ្ទុក `en` និង `km` ទាំងពីរ |

Keys ដាក់ក្នុង `lang/en/admin.php` និង `lang/km/admin.php` ដោយប្រើ dot-notation (`menu.dashboard`, `pos.grand_total`, `auth.login_title`, `alert.created`, ល។ល។)។

---

> **ជំពូកទី ៥ — សិទ្ធិ និងតួនាទី (Roles & Permissions)**

---

## ៥.១ Roles (តួនាទីមាន seed ស្រាប់)

| Slug | Name | សិទ្ធិសំខាន់ |
|---|---|---|
| `super-admin` | Super Admin | គ្រប់សិទ្ធិទាំងអស់ (ឆ្លងក្រុមហ៊ុន) |
| `admin` | Admin | គ្រប់គ្រងក្រុមហ៊ុនមួយ |
| `branch-manager` | Branch Manager | គ្រប់គ្រងសាខា |
| `cashier` | Cashier | លក់ POS ប៉ុណ្ណោះ |
| `warehouse-staff` | Warehouse Staff | ស្តុក និងការផ្ទេរ |
| `accountant` | Accountant | ហិរញ្ញវត្ថុ + របាយការណ៍ |

## ៥.២ Permissions

Permissions ត្រូវបាន seed ដោយ `PermissionsTableSeeder.php` តាមរបៀប `<module>.<action>`. មាន module ខាងក្រោម (សរុបជាង ១៣០ permission)៖

```
company  branch  warehouse  user  role  permission
category unit  brand  product  supplier  customer
stock_balance  stock_movement  stock_adjustment  damaged_stock  stock_transfer
purchase  purchase_payment  purchase_return
sale  sale_payment  sale_return  quotation
driver  vehicle  vehicle_expense  delivery
expense_category  expense
report  system_setting
```

Actions ស្តង់ដារ៖ `view`, `create`, `edit`, `delete`, និងបន្ថែម `approve`, `receive`, `send`, `convert`, `assign`, `export` តាមកម្រិត module។

## ៥.៣ ការពិនិត្យសិទ្ធិ (Permission check)

នៅក្នុង controller/view៖

```php
if (auth()->user()?->hasPermission('sale.create')) {
    // …
}
```

`User::hasPermission(string $slug): bool` ត្រួតពិនិត្យតាមរយៈ `role_permissions` table ដែលភ្ជាប់នឹង `Role` បច្ចុប្បន្នរបស់អ្នកប្រើ។

## ៥.៤ Multi-Branch Role (`user_branch_roles`)

User មួយអាចមាន role ផ្សេងគ្នាសម្រាប់ sata នីមួយៗ៖

- Default role នៅលើ `users.role_id`
- Per-branch role override នៅលើ `user_branch_roles(user_id, branch_id, role_id, is_default, is_active)`

ការប្ដូរ branch ត្រូវធ្វើឡើងតាមរយៈ `POST /admin/branch/switch` ដោយផ្ដល់ `branch_id`។ `BranchSwitchController` ផ្ទៀងថាសាខានោះស្ថិតក្នុង company របស់ user ហើយរក្សា `current_branch_id` + `current_branch_name` ក្នុង session។

---

> **ជំពូកទី ៦ — Module Reference**

---

## ៦.១ Dashboard

**URL**: `/admin/dashboard`
**Controller**: `App\Http\Controllers\Admin\DashboardController` (invokable)

ស្ថិតិដែលបង្ហាញ៖

- `sales_today` — សរុបនៃ `grand_total` នៃ `sale_invoices` ថ្ងៃនេះ (scope by branch)
- `sales_count_today` — ចំនួនវិក្កយបត្រលក់ថ្ងៃនេះ
- `purchases_today` — សរុបនៃ `grand_total` នៃ `purchase_invoices` ថ្ងៃនេះ
- `product_count`, `customer_count`, `supplier_count`
- `recentSales`, `recentPurchases` — ៨ វិក្កយបត្រចុងក្រោយ

## ៦.២ POS

**URL**: `/admin/pos`
**Permissions**: `sale.create`, `sale.view`

មុខងារ៖
- ស្វែងរកផលិតផលដោយ keyword, code, sku, ឬ barcode
- បន្ថែមទៅកន្ត្រក, កែបរិមាណ និងថ្លៃឯកតា, ដាក់បញ្ចុះតម្លៃក្នុង line
- ជ្រើស customer (មិនបង្ខំ — អាច Walk-in)
- ជ្រើស warehouse (default = warehouse `is_default = true` ឬមួយដំបូងនៃ branch)
- ប្រភេទទូទាត់: `cash` / `bank` / `credit` (string flexible)
- Calculate subtotal / discount / tax / grand total / change
- Pay → បង្កើត `sale_invoices`, `sale_items`, `sale_payments`, `stock_movements` ក្នុង transaction
- Print receipt window ឡើងវិញតាម `printReceipt()`

## ៦.៣ Sales Module

| URL | មុខងារ |
|---|---|
| `/admin/sale_invoices` | បញ្ជីវិក្កយបត្រលក់ |
| `/admin/sale_items` | បញ្ជី line items |
| `/admin/sale_payments` | ការទូទាត់ |
| `/admin/sale_returns` / `/admin/sale_return_items` | ការប្រគល់ត្រឡប់ |
| `/admin/quotations` / `/admin/quotation_items` | តម្លៃផ្ដល់ជូន |

Sale invoice មាន column សំខាន់ៗ៖ `sale_no`, `sale_date`, `sale_type` (retail/wholesale/project), `status` (draft/completed/cancelled), `payment_status`, `subtotal`, `discount_amount`, `tax_amount`, `transport_fee`, `grand_total`, `paid_amount`, `due_amount`, `change_amount`, `customer_id`, `cashier_id`, `warehouse_id`, `branch_id`, `approved_by`, …

## ៦.៤ Purchases Module

| URL | មុខងារ |
|---|---|
| `/admin/purchase_invoices` | ការទិញចូល |
| `/admin/purchase_items` | line items |
| `/admin/purchase_payments` | ការទូទាត់ទៅ supplier |
| `/admin/purchase_returns` / `/admin/purchase_return_items` | ការត្រឡប់ទៅ supplier |

Purchase invoice មាន `purchase_no`, `purchase_date`, `received_by`, `supplier_id`, `warehouse_id`, និងស្ថានភាពស្តុក (បាន receive ឬមិនទាន់)។

## ៦.៥ Inventory Module

| URL | មុខងារ |
|---|---|
| `/admin/stock_balances` | បរិមាណបច្ចុប្បន្នក្នុង warehouse |
| `/admin/stock_movements` | កំណត់ត្រាចូល-ចេញទាំងអស់ |
| `/admin/stock_transfers` / `/admin/stock_transfer_items` | ផ្ទេររវាងឃ្លាំង (in/out) |
| `/admin/stock_adjustments` / `/admin/stock_adjustment_items` | កែតម្រូវចំនួន (gain/loss) |
| `/admin/damaged_stocks` | ស្តុកខូច / បាត់បង់ |

## ៦.៦ Delivery Module

| URL | មុខងារ |
|---|---|
| `/admin/deliveries` | គ្រប់គ្រងការដឹក (ភ្ជាប់ sale_invoice + driver + vehicle) |
| `/admin/delivery_proofs` | រូបភាព/ហត្ថលេខាសន្និដ្ឋាន |
| `/admin/drivers` | អ្នកបើកបរ |
| `/admin/vehicles` | យានយន្ត |
| `/admin/vehicle_expenses` | ចំណាយយានយន្ត |

## ៦.៧ Finance Module

| URL | មុខងារ |
|---|---|
| `/admin/expenses` | ការចំណាយ |
| `/admin/expense_categories` | ប្រភេទចំណាយ |
| `/admin/customer_ledger` | សង្ខេបបញ្ជី customer; `show/{customer}` បង្ហាញលម្អិត |
| `/admin/customer_ledger_entries` | កំណត់ត្រា debit/credit |
| `/admin/supplier_ledger` / `/admin/supplier_ledger_entries` | ដូចគ្នាសម្រាប់ supplier |

## ៦.៨ Reports

| URL | មុខងារ |
|---|---|
| `/admin/reports/sales` | តាមរយៈ from/to date — បង្ហាញ invoice + totals |
| `/admin/reports/stock` | Stock balance របស់ branch បច្ចុប្បន្ន |
| `/admin/reports/profit` | ផលបូកនៃ `profit_amount` លើ sale items + total sales |
| `/admin/reports/payable` | Supplier ដែលមាន `current_balance > 0` |
| `/admin/reports/receivable` | Customer ដែលមាន `current_balance > 0` |
| `/admin/reports/branch-performance` | សរុបនៃ invoice + sales + profit ក្នុង period តាម branch |

## ៦.៩ Master Data

| URL | មុខងារ |
|---|---|
| `/admin/products` | ផលិតផល (មាន purchase_price, retail_price, wholesale_price, project_price, sku, barcode, minimum_stock, weight, track_stock, allow_negative_stock) |
| `/admin/categories` | ប្រភេទ (self-referencing parent_id សម្រាប់ hierarchy) |
| `/admin/brands` | ម៉ាក |
| `/admin/units` | ឯកតា (មាន base_quantity សម្រាប់ conversion) |
| `/admin/customers` | អតិថិជន (មាន current_balance, credit_limit) |
| `/admin/suppliers` | អ្នកផ្គត់ផ្គង់ (មាន current_balance) |

## ៦.១០ Administration

| URL | មុខងារ |
|---|---|
| `/admin/companies` | ក្រុមហ៊ុន — currency, logo, language, tax_number |
| `/admin/branches` | សាខា |
| `/admin/warehouses` | ឃ្លាំងតាមសាខា |
| `/admin/users` | អ្នកប្រើ + role + flags (`can_view_money`, `can_view_profit`, `can_override_credit_limit`) |
| `/admin/roles` | តួនាទី |
| `/admin/permissions` | សិទ្ធិ |
| `/admin/role_permissions` | ភ្ជាប់ role ↔ permission |
| `/admin/user_branch_roles` | ភ្ជាប់ user ↔ branch ↔ role |
| `/admin/system_settings` | (only index/edit/update) — key/value, public flag |
| `/admin/number_sequences` | លេខលំដាប់ឯកសារ (prefix, padding, date_format, suffix) |
| `/admin/document_templates` | ពុម្ពឯកសារ (invoice/receipt/quotation/delivery) |
| `/admin/notifications` | សារ in-app |
| `/admin/attachments` | ឯកសារភ្ជាប់ (polymorphic) |
| `/admin/audit_logs` | កំណត់ត្រាសកម្មភាព (read-only index) |
| `/admin/login_histories` | ប្រវត្តិចូលប្រព័ន្ធ (read-only index) |

---

> **ជំពូកទី ៧ — ការអភិវឌ្ឍន៍បន្ថែម (Extending the System)**

---

## ៧.១ បន្ថែម Module CRUD ថ្មី (Recommended Workflow)

មានសម្រាប់ table ដែលមាន `company_id` រួចហើយ ហើយ field សាមញ្ញ —

1. **Migration**: បន្ថែម `Schema::create('<table>', …)` ទៅ migration `2026_05_13_000000_create_construction_store_all_in_one_schema.php` (ឬបង្កើត migration ថ្មីបើ deploy ហើយ)។
2. **Model**: បង្កើតក្នុង `app/Models/<Name>.php` — បន្ថែម `$fillable` ឬ `$guarded`, `$casts`, relationships, និង `SoftDeletes` ប្រសិនបើត្រូវការ។
3. **Controller**: បង្កើតក្នុង `app/Http/Controllers/Admin/<Name>sController.php`៖

   ```php
   class WidgetsController extends SchemaResourceController
   {
       protected string $modelClass = Widget::class;
       protected string $viewPrefix = 'admin.widgets';
       protected string $routePrefix = 'admin.widgets';

       public function __construct()
       {
           $this->singular = __('admin.menu.widget');
           $this->pluralLabel = __('admin.menu.widgets');
       }
   }
   ```

4. **Route**: បន្ថែម `Route::resource('widgets', WidgetsController::class);` ទៅ `routes/admin/<group>.php`.
5. **Sidebar**: បន្ថែម `<li>` ទៅ `resources/views/admin/layouts/admin_partials/left_sidebar.blade.php`.
6. **Translations**: បន្ថែម keys ទៅ `lang/en/admin.php` និង `lang/km/admin.php` (`menu.widget`, `menu.widgets`)។
7. **Views**: ប្រសិនបើគ្មាន `admin/widgets/index.blade.php` etc., generic views (`_partials/generic_index.blade.php` + `_partials/generic_form.blade.php` + `_partials/generic_show.blade.php`) នឹងត្រូវបានប្រើដោយស្វ័យប្រវត្តិ។
8. **Permission**: បន្ថែម entry `widget` ទៅ `PermissionsTableSeeder.php` + assign ទៅ roles via `RolePermissionsTableSeeder.php`.
9. **Seeder** (optional): បន្ថែម `WidgetsTableSeeder` ហើយ register ក្នុង `DatabaseSeeder::run()`។

## ៧.២ ការបន្ថែម language key

កែទាំងពីរនៃ៖
- `lang/en/admin.php`
- `lang/km/admin.php`

ហើយ Inertia នឹង auto-share ទាំងពីរទៅ Vue (`window.__APP_TRANSLATIONS__`)។ Blade ប្រើ `__('admin.<dotted.key>')` បន្ថែម `data-i18n="<dotted.key>"` ដើម្បីឱ្យ JS update ភ្លាមៗដោយមិន reload។

## ៧.៣ ការប្ដូរ logic ស្តុក

រាល់ការផ្លាស់ប្ដូរស្តុកត្រូវ pass through `App\Services\StockService::move()` ដើម្បីរក្សា audit trail ក្នុង `stock_movements` និងធ្វើបច្ចុប្បន្នភាព `stock_balances.average_cost` ត្រឹមត្រូវ។ កុំ update ផ្ទាល់លើ `stock_balances` ដោយខ្លួនឯង។

## ៧.៤ ការប្ដូរលេខលំដាប់ឯកសារ

កែ row ក្នុង `number_sequences` តាមរយៈ `/admin/number_sequences` ឬ seeder។ Field សំខាន់៖

- `document_type` (ឧ. `sale_invoice`, `sale_payment`, `purchase_invoice`)
- `company_id`, `branch_id` — ដាច់ដោយឡែកសម្រាប់សាខានីមួយៗ
- `prefix`, `padding`, `suffix`, `date_format` (PHP `now()->format(...)`)
- `next_number` — counter

`NumberSequenceService::next()` lock row ហើយ increment ដោយ atomic។

---

> **ជំពូកទី ៨ — ការដោះស្រាយបញ្ហា (Troubleshooting)**

---

| ករណី | មូលហេតុ | ដំណោះស្រាយ |
|---|---|---|
| `php artisan migrate` បរាជ័យ ដោយ FOREIGN KEY error | Migration ប្រើ `Schema::disableForeignKeyConstraints()` ប៉ុន្តែ DB driver មិនគាំទ្រ | ប្រើ `migrate:fresh` ឬចូល MySQL run `SET FOREIGN_KEY_CHECKS=0` ដោយដៃ |
| `Class "Database\Seeders\…" not found` | មិនបាន `composer dump-autoload` | `composer dump-autoload` ហើយ run seeder ឡើងវិញ |
| Vite manifest missing | មិនបាន `npm run build` (សម្រាប់ prod) ឬ `npm run dev` កំពុង run | Run `npm run build` ឬ start `npm run dev` ឱ្យ Vite ផ្ដល់ HMR manifest |
| `/admin/pos` បង្ហាញ "No branch selected" | Session មិនមាន `current_branch_id` | ចូលក្នុង UI `Switch Branch` (header) ឬ run `migrate:fresh --seed` ឱ្យមាន branch + user.default_branch_id |
| Translations មិនប្ដូរ | Cache | `php artisan optimize:clear` + reload browser |
| DataTables មិនបង្ហាញទិន្នន័យ | Yajra package ត្រូវការ `composer require yajra/laravel-datatables-oracle` (តម្លើងស្រាប់) | ត្រួតពិនិត្យ `config/datatables.php` និង controller `dataTableResponse()` |
| POS checkout 422 "no_branch_selected" | Session loss | Re-login ឬ run `php artisan session:table` + migrate |
| SQLite "general error: 8 attempt to write a readonly database" | File permissions | `chmod 664 database/database.sqlite && chmod 775 database/` |

## ៨.១ ការ Clear cache

```bash
php artisan optimize:clear
# ឬដាច់ដោយឡែក
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
```

## ៨.២ ការ Reset database

```bash
php artisan migrate:fresh --seed --force
```

> ⚠️ ការនេះនឹង **លុបទិន្នន័យទាំងអស់** ហើយ seed ឡើងវិញ។ កុំ run នៅលើ production!

---

> **ជំពូកទី ៩ — ឯកសារយោង (References)**

---

- **Laravel 12 Documentation** — <https://laravel.com/docs/12.x>
- **Inertia.js** — <https://inertiajs.com>
- **Ziggy** — <https://github.com/tighten/ziggy>
- **Yajra DataTables** — <https://yajrabox.com/docs/laravel-datatables>
- **PHP-Flasher** — <https://php-flasher.io>
- **SweetAlert2** — <https://sweetalert2.github.io>
- **Vue 3** — <https://vuejs.org>
- **vue-i18n** — <https://vue-i18n.intlify.dev>
- **Bootstrap 5** — <https://getbootstrap.com>
- **Tom Select** — <https://tom-select.js.org>
- **Flatpickr** — <https://flatpickr.js.org>

---

## សេចក្ដីសរុប (Conclusion)

ឯកសារនេះគ្របដណ្ដប់៖
- ទិដ្ឋភាពទូទៅ និងបច្ចេកវិទ្យារបស់ **Construction Store Management System with POS**
- ការដំឡើង និងគណនី demo
- រចនាសម្ព័ន្ធ database 51 តារាង និងទំនាក់ទំនង
- រចនាសម្ព័ន្ធ application (routes, middleware, controllers, POS island, StockService)
- សិទ្ធិ និងតួនាទី
- Module reference ដែលអាចប្រើជា bookmark
- របៀបបន្ថែម module ថ្មី និងដោះស្រាយបញ្ហាទូទៅ

សម្រាប់សំណួរបច្ចេកទេស ឬដើម្បីបន្ថែម feature ថ្មី សូមផ្ដើមដោយការអាន `README.md` និងឯកសារនេះ ហើយប្រើ `BaseCrudController` / `SchemaResourceController` ដើម្បីសន្សំការសរសេរ code។
