<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionsTableSeeder extends Seeder
{
    public function run(): void
    {
        // Assign ALL permissions to Super Admin role
        $superAdminRole = DB::table('roles')->where('slug', 'super-admin')->first();
        $allPermissions = DB::table('permissions')->pluck('id');

        $records = [];
        foreach ($allPermissions as $permId) {
            $records[] = [
                'role_id'       => $superAdminRole->id,
                'permission_id' => $permId,
                'created_at'    => now(),
                'updated_at'    => now(),
            ];
        }
        DB::table('role_permissions')->insert($records);

        // Assign sale, purchase, customer, supplier permissions to Admin
        $adminRole = DB::table('roles')->where('slug', 'admin')->first();
        $adminModules = ['sale', 'sale_payment', 'sale_return', 'purchase', 'purchase_payment',
                         'purchase_return', 'customer', 'supplier', 'product', 'category',
                         'brand', 'unit', 'stock_balance', 'stock_movement', 'quotation',
                         'delivery', 'report'];
        $adminPermIds = DB::table('permissions')->whereIn('module', $adminModules)->pluck('id');
        $adminRecords = [];
        foreach ($adminPermIds as $permId) {
            $adminRecords[] = [
                'role_id'       => $adminRole->id,
                'permission_id' => $permId,
                'created_at'    => now(),
                'updated_at'    => now(),
            ];
        }
        DB::table('role_permissions')->insert($adminRecords);

        // Assign sale only to Cashier
        $cashierRole = DB::table('roles')->where('slug', 'cashier')->first();
        $cashierPermIds = DB::table('permissions')->where('module', 'sale')->pluck('id');
        $cashierRecords = [];
        foreach ($cashierPermIds as $permId) {
            $cashierRecords[] = [
                'role_id'       => $cashierRole->id,
                'permission_id' => $permId,
                'created_at'    => now(),
                'updated_at'    => now(),
            ];
        }
        DB::table('role_permissions')->insert($cashierRecords);
    }
}
