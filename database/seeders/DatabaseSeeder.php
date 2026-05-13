<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Company;
use App\Models\Customer;
use App\Models\ExpenseCategory;
use App\Models\Permission;
use App\Models\Product;
use App\Models\Role;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $company = Company::create([
                'company_code' => 'CS-001',
                'name' => 'Demo Construction Store',
                'owner_name' => 'Demo Owner',
                'phone' => '+855 12 345 678',
                'email' => 'info@demo.local',
                'address' => '#1, Street 1, Phnom Penh',
                'currency_code' => 'KHR',
                'language' => 'km',
                'is_active' => true,
            ]);

            $adminRole = Role::create([
                'company_id' => $company->id,
                'name' => 'Administrator',
                'slug' => 'admin',
                'description' => 'Full access',
                'is_active' => true,
            ]);

            $cashierRole = Role::create([
                'company_id' => $company->id,
                'name' => 'Cashier',
                'slug' => 'cashier',
                'description' => 'POS access',
                'is_active' => true,
            ]);

            foreach ([
                ['module' => 'products', 'action' => 'view'],
                ['module' => 'products', 'action' => 'create'],
                ['module' => 'products', 'action' => 'update'],
                ['module' => 'products', 'action' => 'delete'],
                ['module' => 'pos', 'action' => 'use'],
                ['module' => 'reports', 'action' => 'view'],
            ] as $p) {
                Permission::create([
                    'module' => $p['module'],
                    'action' => $p['action'],
                    'name' => ucfirst($p['action']) . ' ' . ucfirst($p['module']),
                    'slug' => $p['module'] . '.' . $p['action'],
                ]);
            }

            $branchA = Branch::create([
                'company_id' => $company->id,
                'branch_code' => 'BR-001',
                'name' => 'Main Branch',
                'phone' => '+855 12 000 001',
                'address' => 'Phnom Penh',
                'is_main_branch' => true,
                'is_active' => true,
            ]);

            $branchB = Branch::create([
                'company_id' => $company->id,
                'branch_code' => 'BR-002',
                'name' => 'Siem Reap Branch',
                'phone' => '+855 12 000 002',
                'address' => 'Siem Reap',
                'is_active' => true,
            ]);

            $warehouseA = Warehouse::create([
                'company_id' => $company->id,
                'branch_id' => $branchA->id,
                'warehouse_code' => 'WH-001',
                'name' => 'Main Warehouse',
                'is_default' => true,
                'is_active' => true,
            ]);

            $warehouseB = Warehouse::create([
                'company_id' => $company->id,
                'branch_id' => $branchB->id,
                'warehouse_code' => 'WH-002',
                'name' => 'Siem Reap Warehouse',
                'is_default' => true,
                'is_active' => true,
            ]);

            $admin = User::create([
                'company_id' => $company->id,
                'default_branch_id' => $branchA->id,
                'role_id' => $adminRole->id,
                'user_code' => 'USR-001',
                'name' => 'Administrator',
                'email' => 'admin@demo.local',
                'phone' => '+855 12 000 010',
                'password' => Hash::make('password'),
                'can_view_money' => true,
                'can_view_profit' => true,
                'is_active' => true,
            ]);

            User::create([
                'company_id' => $company->id,
                'default_branch_id' => $branchA->id,
                'role_id' => $cashierRole->id,
                'user_code' => 'USR-002',
                'name' => 'Demo Cashier',
                'email' => 'cashier@demo.local',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]);

            // Master data
            $cementCat = Category::create(['company_id' => $company->id, 'name' => 'Cement', 'code' => 'CEM', 'is_active' => true]);
            $steelCat = Category::create(['company_id' => $company->id, 'name' => 'Steel', 'code' => 'STL', 'is_active' => true]);
            $sandCat = Category::create(['company_id' => $company->id, 'name' => 'Sand & Aggregate', 'code' => 'SND', 'is_active' => true]);
            $toolsCat = Category::create(['company_id' => $company->id, 'name' => 'Tools', 'code' => 'TLS', 'is_active' => true]);

            $bagUnit = Unit::create(['company_id' => $company->id, 'name' => 'Bag', 'short_name' => 'bag', 'base_quantity' => 1, 'is_active' => true]);
            $tonUnit = Unit::create(['company_id' => $company->id, 'name' => 'Ton', 'short_name' => 'ton', 'base_quantity' => 1, 'is_active' => true]);
            $pcsUnit = Unit::create(['company_id' => $company->id, 'name' => 'Piece', 'short_name' => 'pcs', 'base_quantity' => 1, 'is_active' => true]);

            $brandA = Brand::create(['company_id' => $company->id, 'name' => 'Kampot Cement', 'country' => 'Cambodia', 'is_active' => true]);
            $brandB = Brand::create(['company_id' => $company->id, 'name' => 'Holcim', 'country' => 'Cambodia', 'is_active' => true]);
            $brandC = Brand::create(['company_id' => $company->id, 'name' => 'Generic', 'is_active' => true]);

            $products = [
                ['P001', 'Cement (50kg)', $cementCat, $bagUnit, $brandA, 25000, 28000],
                ['P002', 'Cement Holcim (50kg)', $cementCat, $bagUnit, $brandB, 26000, 29000],
                ['P003', 'Rebar 10mm', $steelCat, $pcsUnit, $brandC, 22000, 25000],
                ['P004', 'Rebar 12mm', $steelCat, $pcsUnit, $brandC, 27000, 30000],
                ['P005', 'Sand (1 ton)', $sandCat, $tonUnit, $brandC, 30000, 35000],
                ['P006', 'Gravel (1 ton)', $sandCat, $tonUnit, $brandC, 35000, 40000],
                ['P007', 'Hammer 1kg', $toolsCat, $pcsUnit, $brandC, 15000, 22000],
                ['P008', 'Tape Measure 5m', $toolsCat, $pcsUnit, $brandC, 8000, 12000],
            ];

            foreach ($products as [$code, $name, $cat, $unit, $brand, $purchase, $retail]) {
                Product::create([
                    'company_id' => $company->id,
                    'product_code' => $code,
                    'name' => $name,
                    'category_id' => $cat->id,
                    'unit_id' => $unit->id,
                    'brand_id' => $brand->id,
                    'purchase_price' => $purchase,
                    'retail_price' => $retail,
                    'wholesale_price' => $retail - 1500,
                    'minimum_stock' => 5,
                    'track_stock' => true,
                    'is_active' => true,
                ]);
            }

            Supplier::create([
                'company_id' => $company->id,
                'supplier_code' => 'SUP-001',
                'name' => 'Cement Supplier Co.',
                'phone' => '+855 12 111 000',
                'address' => 'Phnom Penh',
                'is_active' => true,
            ]);

            Customer::create([
                'company_id' => $company->id,
                'customer_code' => 'CUS-001',
                'name' => 'Walk-in Customer',
                'customer_type' => 'walk_in',
                'is_walk_in' => true,
                'is_active' => true,
            ]);

            Customer::create([
                'company_id' => $company->id,
                'customer_code' => 'CUS-002',
                'name' => 'ABC Construction Ltd.',
                'phone' => '+855 12 222 000',
                'customer_type' => 'contractor',
                'project_name' => 'Sample Project',
                'credit_limit' => 5000000,
                'is_active' => true,
            ]);

            ExpenseCategory::create([
                'company_id' => $company->id,
                'name' => 'Office Supplies',
                'is_active' => true,
            ]);
            ExpenseCategory::create([
                'company_id' => $company->id,
                'name' => 'Utilities',
                'is_active' => true,
            ]);

            $this->command?->info('Seeded company, branches, roles, users, products, categories, units, brands, customers, suppliers.');
            $this->command?->info('Login: admin@demo.local / password');
        });
    }
}
