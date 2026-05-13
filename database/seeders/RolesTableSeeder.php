<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    public function run(): void
    {
        $companyId = DB::table('companies')->value('id');

        DB::table('roles')->insert([
            [
                'company_id'  => $companyId,
                'name'        => 'Super Admin',
                'slug'        => 'super-admin',
                'description' => 'Full system access',
                'is_system'   => true,
                'is_active'   => true,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'company_id'  => $companyId,
                'name'        => 'Admin',
                'slug'        => 'admin',
                'description' => 'Company admin access',
                'is_system'   => true,
                'is_active'   => true,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'company_id'  => $companyId,
                'name'        => 'Branch Manager',
                'slug'        => 'branch-manager',
                'description' => 'Manage branch operations',
                'is_system'   => false,
                'is_active'   => true,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'company_id'  => $companyId,
                'name'        => 'Cashier',
                'slug'        => 'cashier',
                'description' => 'POS sales only',
                'is_system'   => false,
                'is_active'   => true,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'company_id'  => $companyId,
                'name'        => 'Warehouse Staff',
                'slug'        => 'warehouse-staff',
                'description' => 'Manage inventory and stock',
                'is_system'   => false,
                'is_active'   => true,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'company_id'  => $companyId,
                'name'        => 'Accountant',
                'slug'        => 'accountant',
                'description' => 'Finance and accounting access',
                'is_system'   => false,
                'is_active'   => true,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}
