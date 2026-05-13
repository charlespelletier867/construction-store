<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        $this->call([
            // 1. Core: Company
            CompaniesTableSeeder::class,

            // 2. Roles & Permissions
            RolesTableSeeder::class,
            PermissionsTableSeeder::class,
            RolePermissionsTableSeeder::class,

            // 3. Users
            UsersTableSeeder::class,

            // 4. Branches & Warehouses
            BranchesTableSeeder::class,
            WarehousesTableSeeder::class,

            // 5. User-Branch-Role mapping
            UserBranchRolesTableSeeder::class,

            // 6. Product master data
            CategoriesTableSeeder::class,
            UnitsTableSeeder::class,
            BrandsTableSeeder::class,
            ProductsTableSeeder::class,

            // 7. Supplier & Customer
            SuppliersTableSeeder::class,
            CustomersTableSeeder::class,

            // 8. Stock opening balances
            StockBalancesTableSeeder::class,

            // 9. Delivery assets
            DriversTableSeeder::class,
            VehiclesTableSeeder::class,

            // 10. Expense categories
            ExpenseCategoriesTableSeeder::class,

            // 11. System configuration
            SystemSettingsTableSeeder::class,
            NumberSequencesTableSeeder::class,
            DocumentTemplatesTableSeeder::class,
        ]);

        if ($driver === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        $this->command->info('');
        $this->command->info('✅ ទិន្នន័យ Demo បានបញ្ចូលគ្រប់ជ្រុងជ្រោយ!');
        $this->command->info('-------------------------------------------');
        $this->command->info('🔑 Login Accounts:');
        $this->command->info('   superadmin@demo.local  / password');
        $this->command->info('   admin@demo.local       / password');
        $this->command->info('   manager1@demo.local    / password');
        $this->command->info('   cashier1@demo.local    / password');
        $this->command->info('   warehouse1@demo.local  / password');
        $this->command->info('   accountant1@demo.local / password');
        $this->command->info('-------------------------------------------');
    }
}
