<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| All-in-one Construction Store Management System Schema
|--------------------------------------------------------------------------
| Project: Multi-branch construction material store management system
| Stack: Laravel, Bootstrap 5, jQuery Ajax, SweetAlert2, PHPFlasher, DataTables
|
| Notes:
| - This is intentionally one migration file for quick installation.
| - Status columns use strings for flexibility instead of database enums.
| - Reports such as sales, stock, profit, payable, receivable, and branch
|   performance can be produced from the transactional tables below.
| - If your Laravel project already has the default users/password reset tables,
|   remove or adjust the users/password_reset_tokens/sessions tables here.
*/

return new class extends Migration
{
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        /*
        |--------------------------------------------------------------------------
        | Core company, role, permission, and user tables
        |--------------------------------------------------------------------------
        */

        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('company_code')->unique();
            $table->string('name');
            $table->string('owner_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->text('address')->nullable();
            $table->string('tax_number')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('currency_code', 10)->default('KHR');
            $table->string('language', 10)->default('km');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained('companies')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->boolean('is_system')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['company_id', 'slug']);
        });

        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('module');
            $table->string('action');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete();
            $table->foreignId('permission_id')->constrained('permissions')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['role_id', 'permission_id']);
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained('companies')->nullOnDelete();
            $table->unsignedBigInteger('default_branch_id')->nullable();
            $table->foreignId('role_id')->nullable()->constrained('roles')->nullOnDelete();
            $table->string('user_code')->nullable()->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('password');
            $table->string('avatar_path')->nullable();
            $table->boolean('can_view_money')->default(false);
            $table->boolean('can_view_profit')->default(false);
            $table->boolean('can_override_credit_limit')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_login_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['company_id', 'role_id']);
        });

        /*
        |--------------------------------------------------------------------------
        | Company branches and warehouses
        |--------------------------------------------------------------------------
        */

        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignId('manager_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('branch_code');
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->boolean('is_main_branch')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['company_id', 'branch_code']);
            $table->index(['company_id', 'is_active']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('default_branch_id')->references('id')->on('branches')->nullOnDelete();
        });

        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete();
            $table->string('warehouse_code');
            $table->string('name');
            $table->text('address')->nullable();
            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['branch_id', 'warehouse_code']);
        });

        Schema::create('user_branch_roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete();
            $table->foreignId('role_id')->nullable()->constrained('roles')->nullOnDelete();
            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['user_id', 'branch_id']);
        });

        /*
        |--------------------------------------------------------------------------
        | Product master data
        |--------------------------------------------------------------------------
        */

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained('companies')->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('code')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['company_id', 'code']);
            $table->index(['company_id', 'is_active']);
        });

        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained('companies')->cascadeOnDelete();
            $table->string('name');
            $table->string('short_name');
            $table->decimal('base_quantity', 18, 4)->default(1);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['company_id', 'short_name']);
        });

        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained('companies')->cascadeOnDelete();
            $table->string('name');
            $table->string('country')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->text('note')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['company_id', 'name']);
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->foreignId('brand_id')->nullable()->constrained('brands')->nullOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->string('product_code');
            $table->string('sku')->nullable();
            $table->string('barcode')->nullable();
            $table->string('name');
            $table->string('size')->nullable();
            $table->string('dimension')->nullable();
            $table->decimal('weight', 18, 4)->nullable();
            $table->string('color')->nullable();
            $table->string('model')->nullable();
            $table->decimal('purchase_price', 18, 4)->default(0);
            $table->decimal('retail_price', 18, 4)->default(0);
            $table->decimal('wholesale_price', 18, 4)->default(0);
            $table->decimal('project_price', 18, 4)->nullable();
            $table->decimal('minimum_stock', 18, 4)->default(0);
            $table->boolean('track_stock')->default(true);
            $table->boolean('allow_negative_stock')->default(false);
            $table->string('image_path')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['company_id', 'product_code']);
            $table->unique(['company_id', 'sku']);
            $table->unique(['company_id', 'barcode']);
            $table->index(['company_id', 'category_id', 'brand_id']);
            $table->index('name');
        });

        /*
        |--------------------------------------------------------------------------
        | Supplier and customer master data
        |--------------------------------------------------------------------------
        */

        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->string('supplier_code');
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('contact_person')->nullable();
            $table->decimal('opening_balance', 18, 4)->default(0);
            $table->decimal('current_balance', 18, 4)->default(0);
            $table->decimal('credit_limit', 18, 4)->default(0);
            $table->integer('credit_days')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['company_id', 'supplier_code']);
            $table->index(['company_id', 'is_active']);
        });

        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->string('customer_code');
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('customer_type')->default('walk_in'); // walk_in, regular, wholesale, contractor, company, project_owner
            $table->string('project_name')->nullable();
            $table->decimal('opening_balance', 18, 4)->default(0);
            $table->decimal('current_balance', 18, 4)->default(0);
            $table->decimal('credit_limit', 18, 4)->default(0);
            $table->integer('credit_days')->default(0);
            $table->boolean('is_walk_in')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['company_id', 'customer_code']);
            $table->index(['company_id', 'customer_type', 'is_active']);
            $table->index('phone');
        });

        /*
        |--------------------------------------------------------------------------
        | Inventory balance, movement, adjustments, low stock, and damaged stock
        |--------------------------------------------------------------------------
        */

        Schema::create('stock_balances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete();
            $table->foreignId('warehouse_id')->constrained('warehouses')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->decimal('quantity', 18, 4)->default(0);
            $table->decimal('reserved_quantity', 18, 4)->default(0);
            $table->decimal('available_quantity', 18, 4)->default(0);
            $table->decimal('average_cost', 18, 4)->default(0);
            $table->decimal('stock_value', 18, 4)->default(0);
            $table->timestamp('last_movement_at')->nullable();
            $table->timestamps();

            $table->unique(['warehouse_id', 'product_id']);
            $table->index(['company_id', 'branch_id', 'warehouse_id']);
        });

        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete();
            $table->foreignId('warehouse_id')->constrained('warehouses')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->string('movement_no')->nullable();
            $table->string('movement_type'); // purchase_in, sale_out, return_in, return_out, transfer_in, transfer_out, adjustment_in, adjustment_out, damaged_stock
            $table->string('reference_type')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->decimal('quantity_in', 18, 4)->default(0);
            $table->decimal('quantity_out', 18, 4)->default(0);
            $table->decimal('balance_after', 18, 4)->default(0);
            $table->decimal('unit_cost', 18, 4)->default(0);
            $table->decimal('total_cost', 18, 4)->default(0);
            $table->text('note')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['company_id', 'branch_id', 'warehouse_id', 'product_id']);
            $table->index(['reference_type', 'reference_id']);
            $table->index('movement_type');
        });

        Schema::create('stock_adjustments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete();
            $table->foreignId('warehouse_id')->constrained('warehouses')->cascadeOnDelete();
            $table->string('adjustment_no');
            $table->string('adjustment_type'); // increase, decrease, recount, damaged, lost
            $table->date('adjustment_date');
            $table->text('reason')->nullable();
            $table->string('status')->default('completed'); // draft, completed, cancelled
            $table->string('evidence_path')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['company_id', 'adjustment_no']);
        });

        Schema::create('stock_adjustment_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_adjustment_id')->constrained('stock_adjustments')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->decimal('system_quantity', 18, 4)->default(0);
            $table->decimal('actual_quantity', 18, 4)->default(0);
            $table->decimal('difference_quantity', 18, 4)->default(0);
            $table->decimal('unit_cost', 18, 4)->default(0);
            $table->decimal('total_cost', 18, 4)->default(0);
            $table->text('reason')->nullable();
            $table->timestamps();
        });

        Schema::create('damaged_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete();
            $table->foreignId('warehouse_id')->constrained('warehouses')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->string('damage_no');
            $table->date('damage_date');
            $table->decimal('quantity', 18, 4);
            $table->decimal('unit_cost', 18, 4)->default(0);
            $table->decimal('total_cost', 18, 4)->default(0);
            $table->text('reason')->nullable();
            $table->string('evidence_path')->nullable();
            $table->string('status')->default('recorded'); // recorded, approved, written_off, cancelled
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['company_id', 'damage_no']);
        });

        /*
        |--------------------------------------------------------------------------
        | Purchases, purchase payments, and purchase returns
        |--------------------------------------------------------------------------
        */

        Schema::create('purchase_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete();
            $table->foreignId('warehouse_id')->constrained('warehouses')->cascadeOnDelete();
            $table->foreignId('supplier_id')->constrained('suppliers')->restrictOnDelete();
            $table->string('purchase_no');
            $table->date('purchase_date');
            $table->date('due_date')->nullable();
            $table->string('status')->default('draft'); // draft, ordered, received, partial_received, cancelled
            $table->string('payment_status')->default('unpaid'); // unpaid, partial_paid, paid
            $table->decimal('subtotal', 18, 4)->default(0);
            $table->decimal('discount_amount', 18, 4)->default(0);
            $table->decimal('tax_amount', 18, 4)->default(0);
            $table->decimal('transport_fee', 18, 4)->default(0);
            $table->decimal('other_fee', 18, 4)->default(0);
            $table->decimal('grand_total', 18, 4)->default(0);
            $table->decimal('paid_amount', 18, 4)->default(0);
            $table->decimal('due_amount', 18, 4)->default(0);
            $table->text('note')->nullable();
            $table->timestamp('received_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('received_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['company_id', 'purchase_no']);
            $table->index(['company_id', 'branch_id', 'supplier_id', 'purchase_date']);
            $table->index(['status', 'payment_status']);
        });

        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_invoice_id')->constrained('purchase_invoices')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->restrictOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->decimal('quantity', 18, 4);
            $table->decimal('received_quantity', 18, 4)->default(0);
            $table->decimal('returned_quantity', 18, 4)->default(0);
            $table->decimal('unit_cost', 18, 4)->default(0);
            $table->decimal('discount_amount', 18, 4)->default(0);
            $table->decimal('tax_amount', 18, 4)->default(0);
            $table->decimal('line_total', 18, 4)->default(0);
            $table->text('note')->nullable();
            $table->timestamps();

            $table->index(['purchase_invoice_id', 'product_id']);
        });

        Schema::create('purchase_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete();
            $table->foreignId('supplier_id')->constrained('suppliers')->restrictOnDelete();
            $table->foreignId('purchase_invoice_id')->nullable()->constrained('purchase_invoices')->nullOnDelete();
            $table->string('payment_no');
            $table->date('payment_date');
            $table->decimal('amount', 18, 4);
            $table->string('payment_method'); // cash, aba, wing, bank_transfer, cheque
            $table->string('reference_no')->nullable();
            $table->text('note')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['company_id', 'payment_no']);
            $table->index(['supplier_id', 'payment_date']);
        });

        Schema::create('purchase_returns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete();
            $table->foreignId('warehouse_id')->constrained('warehouses')->cascadeOnDelete();
            $table->foreignId('supplier_id')->constrained('suppliers')->restrictOnDelete();
            $table->foreignId('purchase_invoice_id')->nullable()->constrained('purchase_invoices')->nullOnDelete();
            $table->string('return_no');
            $table->date('return_date');
            $table->decimal('subtotal', 18, 4)->default(0);
            $table->decimal('discount_amount', 18, 4)->default(0);
            $table->decimal('tax_amount', 18, 4)->default(0);
            $table->decimal('return_amount', 18, 4)->default(0);
            $table->string('status')->default('completed'); // draft, completed, cancelled
            $table->text('reason')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['company_id', 'return_no']);
        });

        Schema::create('purchase_return_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_return_id')->constrained('purchase_returns')->cascadeOnDelete();
            $table->foreignId('purchase_item_id')->nullable()->constrained('purchase_items')->nullOnDelete();
            $table->foreignId('product_id')->constrained('products')->restrictOnDelete();
            $table->decimal('quantity', 18, 4);
            $table->decimal('unit_cost', 18, 4)->default(0);
            $table->decimal('discount_amount', 18, 4)->default(0);
            $table->decimal('tax_amount', 18, 4)->default(0);
            $table->decimal('line_total', 18, 4)->default(0);
            $table->text('reason')->nullable();
            $table->timestamps();
        });

        /*
        |--------------------------------------------------------------------------
        | Sales/POS, sale payments, and sale returns
        |--------------------------------------------------------------------------
        */

        Schema::create('sale_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete();
            $table->foreignId('warehouse_id')->constrained('warehouses')->cascadeOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            $table->foreignId('cashier_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('sale_no');
            $table->dateTime('sale_date');
            $table->string('sale_type')->default('retail'); // retail, wholesale, project, credit, cash
            $table->string('status')->default('completed'); // draft, completed, cancelled, returned
            $table->string('payment_status')->default('unpaid'); // unpaid, partial_paid, paid
            $table->decimal('subtotal', 18, 4)->default(0);
            $table->decimal('discount_amount', 18, 4)->default(0);
            $table->decimal('tax_amount', 18, 4)->default(0);
            $table->decimal('transport_fee', 18, 4)->default(0);
            $table->decimal('grand_total', 18, 4)->default(0);
            $table->decimal('paid_amount', 18, 4)->default(0);
            $table->decimal('due_amount', 18, 4)->default(0);
            $table->decimal('received_amount', 18, 4)->default(0);
            $table->decimal('change_amount', 18, 4)->default(0);
            $table->date('due_date')->nullable();
            $table->text('note')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['company_id', 'sale_no']);
            $table->index(['company_id', 'branch_id', 'customer_id', 'sale_date']);
            $table->index(['status', 'payment_status']);
        });

        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_invoice_id')->constrained('sale_invoices')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->restrictOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->decimal('quantity', 18, 4);
            $table->decimal('returned_quantity', 18, 4)->default(0);
            $table->decimal('unit_price', 18, 4)->default(0);
            $table->decimal('unit_cost', 18, 4)->default(0);
            $table->decimal('discount_amount', 18, 4)->default(0);
            $table->decimal('tax_amount', 18, 4)->default(0);
            $table->decimal('line_total', 18, 4)->default(0);
            $table->decimal('profit_amount', 18, 4)->default(0);
            $table->text('note')->nullable();
            $table->timestamps();

            $table->index(['sale_invoice_id', 'product_id']);
        });

        Schema::create('sale_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            $table->foreignId('sale_invoice_id')->nullable()->constrained('sale_invoices')->nullOnDelete();
            $table->string('payment_no');
            $table->dateTime('payment_date');
            $table->decimal('amount', 18, 4);
            $table->string('payment_method'); // cash, aba, wing, khqr, card, bank_transfer, cheque
            $table->string('reference_no')->nullable();
            $table->text('note')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['company_id', 'payment_no']);
            $table->index(['customer_id', 'payment_date']);
        });

        Schema::create('sale_returns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete();
            $table->foreignId('warehouse_id')->constrained('warehouses')->cascadeOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            $table->foreignId('sale_invoice_id')->nullable()->constrained('sale_invoices')->nullOnDelete();
            $table->string('return_no');
            $table->dateTime('return_date');
            $table->decimal('subtotal', 18, 4)->default(0);
            $table->decimal('discount_amount', 18, 4)->default(0);
            $table->decimal('tax_amount', 18, 4)->default(0);
            $table->decimal('refund_amount', 18, 4)->default(0);
            $table->string('status')->default('completed'); // draft, completed, cancelled
            $table->text('reason')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['company_id', 'return_no']);
        });

        Schema::create('sale_return_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_return_id')->constrained('sale_returns')->cascadeOnDelete();
            $table->foreignId('sale_item_id')->nullable()->constrained('sale_items')->nullOnDelete();
            $table->foreignId('product_id')->constrained('products')->restrictOnDelete();
            $table->decimal('quantity', 18, 4);
            $table->decimal('unit_price', 18, 4)->default(0);
            $table->decimal('unit_cost', 18, 4)->default(0);
            $table->decimal('discount_amount', 18, 4)->default(0);
            $table->decimal('tax_amount', 18, 4)->default(0);
            $table->decimal('line_total', 18, 4)->default(0);
            $table->text('reason')->nullable();
            $table->timestamps();
        });

        /*
        |--------------------------------------------------------------------------
        | Quotations
        |--------------------------------------------------------------------------
        */

        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            $table->foreignId('converted_sale_invoice_id')->nullable()->constrained('sale_invoices')->nullOnDelete();
            $table->string('quotation_no');
            $table->date('quotation_date');
            $table->date('valid_until')->nullable();
            $table->string('status')->default('draft'); // draft, sent, accepted, rejected, expired, converted
            $table->decimal('subtotal', 18, 4)->default(0);
            $table->decimal('discount_amount', 18, 4)->default(0);
            $table->decimal('tax_amount', 18, 4)->default(0);
            $table->decimal('transport_fee', 18, 4)->default(0);
            $table->decimal('grand_total', 18, 4)->default(0);
            $table->text('terms')->nullable();
            $table->text('note')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['company_id', 'quotation_no']);
        });

        Schema::create('quotation_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_id')->constrained('quotations')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->restrictOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->decimal('quantity', 18, 4);
            $table->decimal('unit_price', 18, 4)->default(0);
            $table->decimal('discount_amount', 18, 4)->default(0);
            $table->decimal('tax_amount', 18, 4)->default(0);
            $table->decimal('line_total', 18, 4)->default(0);
            $table->text('note')->nullable();
            $table->timestamps();
        });

        /*
        |--------------------------------------------------------------------------
        | Drivers, vehicles, deliveries, and delivery proof
        |--------------------------------------------------------------------------
        */

        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->string('driver_code');
            $table->string('name');
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('license_no')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['company_id', 'driver_code']);
        });

        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignId('driver_id')->nullable()->constrained('drivers')->nullOnDelete();
            $table->string('vehicle_code');
            $table->string('plate_number');
            $table->string('vehicle_type')->nullable();
            $table->string('capacity')->nullable();
            $table->string('status')->default('available'); // available, assigned, maintenance, inactive
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['company_id', 'vehicle_code']);
            $table->unique(['company_id', 'plate_number']);
        });

        Schema::create('vehicle_expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignId('vehicle_id')->constrained('vehicles')->cascadeOnDelete();
            $table->string('expense_type'); // fuel, repair, maintenance, other
            $table->date('expense_date');
            $table->decimal('amount', 18, 4);
            $table->string('receipt_path')->nullable();
            $table->text('note')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['vehicle_id', 'expense_date']);
        });

        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete();
            $table->foreignId('sale_invoice_id')->nullable()->constrained('sale_invoices')->nullOnDelete();
            $table->foreignId('driver_id')->nullable()->constrained('drivers')->nullOnDelete();
            $table->foreignId('vehicle_id')->nullable()->constrained('vehicles')->nullOnDelete();
            $table->string('delivery_no');
            $table->text('delivery_address');
            $table->decimal('delivery_fee', 18, 4)->default(0);
            $table->dateTime('scheduled_at')->nullable();
            $table->dateTime('delivered_at')->nullable();
            $table->string('status')->default('pending'); // pending, preparing, on_delivery, delivered, failed, cancelled
            $table->text('customer_note')->nullable();
            $table->text('driver_note')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['company_id', 'delivery_no']);
            $table->index(['branch_id', 'status', 'scheduled_at']);
        });

        Schema::create('delivery_proofs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('delivery_id')->constrained('deliveries')->cascadeOnDelete();
            $table->string('proof_type'); // signature, photo, note
            $table->string('file_path')->nullable();
            $table->text('note')->nullable();
            $table->dateTime('captured_at')->nullable();
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        /*
        |--------------------------------------------------------------------------
        | Stock transfers between branches/warehouses
        |--------------------------------------------------------------------------
        */

        Schema::create('stock_transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignId('from_branch_id')->constrained('branches')->restrictOnDelete();
            $table->foreignId('to_branch_id')->constrained('branches')->restrictOnDelete();
            $table->foreignId('from_warehouse_id')->constrained('warehouses')->restrictOnDelete();
            $table->foreignId('to_warehouse_id')->nullable()->constrained('warehouses')->nullOnDelete();
            $table->string('transfer_no');
            $table->date('transfer_date');
            $table->string('status')->default('draft'); // draft, requested, approved, sent, received, cancelled
            $table->text('note')->nullable();
            $table->foreignId('requested_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('sent_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('received_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('received_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['company_id', 'transfer_no']);
            $table->index(['from_branch_id', 'to_branch_id', 'status']);
        });

        Schema::create('stock_transfer_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_transfer_id')->constrained('stock_transfers')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->restrictOnDelete();
            $table->decimal('requested_quantity', 18, 4)->default(0);
            $table->decimal('sent_quantity', 18, 4)->default(0);
            $table->decimal('received_quantity', 18, 4)->default(0);
            $table->decimal('unit_cost', 18, 4)->default(0);
            $table->text('note')->nullable();
            $table->timestamps();

            $table->index(['stock_transfer_id', 'product_id']);
        });

        /*
        |--------------------------------------------------------------------------
        | Expenses and accounting ledgers
        |--------------------------------------------------------------------------
        */

        Schema::create('expense_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained('companies')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['company_id', 'name']);
        });

        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete();
            $table->foreignId('expense_category_id')->nullable()->constrained('expense_categories')->nullOnDelete();
            $table->string('expense_no');
            $table->date('expense_date');
            $table->decimal('amount', 18, 4);
            $table->string('receipt_path')->nullable();
            $table->text('note')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['company_id', 'expense_no']);
            $table->index(['branch_id', 'expense_date']);
        });

        Schema::create('customer_ledger_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->string('entry_no')->nullable();
            $table->dateTime('entry_date');
            $table->string('entry_type'); // opening_balance, sale, payment, sale_return, adjustment
            $table->string('reference_type')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->decimal('debit', 18, 4)->default(0);
            $table->decimal('credit', 18, 4)->default(0);
            $table->decimal('balance_after', 18, 4)->default(0);
            $table->text('note')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['customer_id', 'entry_date']);
            $table->index(['reference_type', 'reference_id']);
        });

        Schema::create('supplier_ledger_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->foreignId('supplier_id')->constrained('suppliers')->cascadeOnDelete();
            $table->string('entry_no')->nullable();
            $table->dateTime('entry_date');
            $table->string('entry_type'); // opening_balance, purchase, payment, purchase_return, adjustment
            $table->string('reference_type')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->decimal('debit', 18, 4)->default(0);
            $table->decimal('credit', 18, 4)->default(0);
            $table->decimal('balance_after', 18, 4)->default(0);
            $table->text('note')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['supplier_id', 'entry_date']);
            $table->index(['reference_type', 'reference_id']);
        });

        /*
        |--------------------------------------------------------------------------
        | Notifications, audit/security, settings, templates, and attachments
        |--------------------------------------------------------------------------
        */

        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained('companies')->cascadeOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->string('notification_type'); // system, email, telegram, sms, phpflasher, sweetalert2
            $table->string('event_type'); // low_stock, out_of_stock, customer_due, supplier_due, transfer, delivery, payment, audit
            $table->string('title');
            $table->text('message');
            $table->string('reference_type')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->json('data')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->index(['company_id', 'branch_id', 'user_id', 'is_read']);
            $table->index(['reference_type', 'reference_id']);
        });

        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained('companies')->nullOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('module')->nullable();
            $table->string('action');
            $table->string('auditable_type')->nullable();
            $table->unsignedBigInteger('auditable_id')->nullable();
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('device')->nullable();
            $table->timestamps();

            $table->index(['company_id', 'branch_id', 'user_id']);
            $table->index(['auditable_type', 'auditable_id']);
            $table->index('action');
        });

        Schema::create('login_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('email')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('device')->nullable();
            $table->boolean('is_successful')->default(false);
            $table->string('failure_reason')->nullable();
            $table->timestamp('logged_in_at')->nullable();
            $table->timestamp('logged_out_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'is_successful']);
        });

        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained('companies')->cascadeOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->cascadeOnDelete();
            $table->string('group')->default('general');
            $table->string('key');
            $table->longText('value')->nullable();
            $table->string('value_type')->default('string'); // string, integer, decimal, boolean, json, text
            $table->boolean('is_public')->default(false);
            $table->timestamps();

            $table->unique(['company_id', 'branch_id', 'group', 'key'], 'system_settings_unique_scope');
        });

        Schema::create('number_sequences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained('companies')->cascadeOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->cascadeOnDelete();
            $table->string('document_type'); // company, branch, product, supplier, customer, purchase, sale, quotation, transfer, return, delivery, expense
            $table->string('prefix')->nullable();
            $table->string('date_format')->nullable(); // Ymd, Ym, Y
            $table->unsignedBigInteger('next_number')->default(1);
            $table->unsignedInteger('padding')->default(5);
            $table->string('suffix')->nullable();
            $table->timestamps();

            $table->unique(['company_id', 'branch_id', 'document_type'], 'number_sequences_unique_scope');
        });

        Schema::create('document_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained('companies')->cascadeOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->cascadeOnDelete();
            $table->string('template_type'); // invoice, receipt, quotation, delivery_note, payment_voucher
            $table->string('name');
            $table->string('paper_size')->default('A4'); // A4, A5, POS
            $table->string('logo_path')->nullable();
            $table->text('header')->nullable();
            $table->text('footer')->nullable();
            $table->json('options')->nullable(); // show_discount, show_tax, show_due_amount, etc.
            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['company_id', 'branch_id', 'template_type']);
        });

        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained('companies')->cascadeOnDelete();
            $table->string('attachable_type');
            $table->unsignedBigInteger('attachable_id');
            $table->string('file_name');
            $table->string('file_path');
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();
            $table->text('note')->nullable();
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['attachable_type', 'attachable_id']);
        });

        /*
        |--------------------------------------------------------------------------
        | Optional Laravel authentication/session support tables
        |--------------------------------------------------------------------------
        */

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index()->constrained('users')->nullOnDelete();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('attachments');
        Schema::dropIfExists('document_templates');
        Schema::dropIfExists('number_sequences');
        Schema::dropIfExists('system_settings');
        Schema::dropIfExists('login_histories');
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('supplier_ledger_entries');
        Schema::dropIfExists('customer_ledger_entries');
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('expense_categories');
        Schema::dropIfExists('stock_transfer_items');
        Schema::dropIfExists('stock_transfers');
        Schema::dropIfExists('delivery_proofs');
        Schema::dropIfExists('deliveries');
        Schema::dropIfExists('vehicle_expenses');
        Schema::dropIfExists('vehicles');
        Schema::dropIfExists('drivers');
        Schema::dropIfExists('quotation_items');
        Schema::dropIfExists('quotations');
        Schema::dropIfExists('sale_return_items');
        Schema::dropIfExists('sale_returns');
        Schema::dropIfExists('sale_payments');
        Schema::dropIfExists('sale_items');
        Schema::dropIfExists('sale_invoices');
        Schema::dropIfExists('purchase_return_items');
        Schema::dropIfExists('purchase_returns');
        Schema::dropIfExists('purchase_payments');
        Schema::dropIfExists('purchase_items');
        Schema::dropIfExists('purchase_invoices');
        Schema::dropIfExists('damaged_stocks');
        Schema::dropIfExists('stock_adjustment_items');
        Schema::dropIfExists('stock_adjustments');
        Schema::dropIfExists('stock_movements');
        Schema::dropIfExists('stock_balances');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('products');
        Schema::dropIfExists('brands');
        Schema::dropIfExists('units');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('user_branch_roles');

        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                try {
                    $table->dropForeign(['default_branch_id']);
                } catch (\Throwable $e) {
                    // Ignore if the constraint does not exist in the current database driver.
                }
            });
        }

        Schema::dropIfExists('warehouses');
        Schema::dropIfExists('branches');
        Schema::dropIfExists('users');
        Schema::dropIfExists('role_permissions');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('companies');

        Schema::enableForeignKeyConstraints();
    }
};
