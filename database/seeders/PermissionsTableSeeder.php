<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{
    public function run(): void
    {
        $modules = [
            'company'         => ['view', 'create', 'edit', 'delete'],
            'branch'          => ['view', 'create', 'edit', 'delete'],
            'warehouse'       => ['view', 'create', 'edit', 'delete'],
            'user'            => ['view', 'create', 'edit', 'delete'],
            'role'            => ['view', 'create', 'edit', 'delete'],
            'permission'      => ['view', 'assign'],
            'category'        => ['view', 'create', 'edit', 'delete'],
            'unit'            => ['view', 'create', 'edit', 'delete'],
            'brand'           => ['view', 'create', 'edit', 'delete'],
            'product'         => ['view', 'create', 'edit', 'delete'],
            'supplier'        => ['view', 'create', 'edit', 'delete'],
            'customer'        => ['view', 'create', 'edit', 'delete'],
            'stock_balance'   => ['view'],
            'stock_movement'  => ['view'],
            'stock_adjustment'=> ['view', 'create', 'edit', 'delete', 'approve'],
            'damaged_stock'   => ['view', 'create', 'edit', 'delete', 'approve'],
            'purchase'        => ['view', 'create', 'edit', 'delete', 'receive', 'approve'],
            'purchase_payment'=> ['view', 'create', 'delete'],
            'purchase_return' => ['view', 'create', 'edit', 'delete'],
            'sale'            => ['view', 'create', 'edit', 'delete', 'approve'],
            'sale_payment'    => ['view', 'create', 'delete'],
            'sale_return'     => ['view', 'create', 'edit', 'delete'],
            'quotation'       => ['view', 'create', 'edit', 'delete', 'convert'],
            'stock_transfer'  => ['view', 'create', 'edit', 'delete', 'approve', 'send', 'receive'],
            'driver'          => ['view', 'create', 'edit', 'delete'],
            'vehicle'         => ['view', 'create', 'edit', 'delete'],
            'vehicle_expense' => ['view', 'create', 'edit', 'delete'],
            'delivery'        => ['view', 'create', 'edit', 'delete'],
            'expense_category'=> ['view', 'create', 'edit', 'delete'],
            'expense'         => ['view', 'create', 'edit', 'delete'],
            'report'          => ['view', 'export'],
            'system_setting'  => ['view', 'edit'],
        ];

        $records = [];
        foreach ($modules as $module => $actions) {
            foreach ($actions as $action) {
                $records[] = [
                    'module'      => $module,
                    'action'      => $action,
                    'name'        => ucfirst(str_replace('_', ' ', $module)) . ' ' . ucfirst($action),
                    'slug'        => $module . '.' . $action,
                    'description' => null,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ];
            }
        }

        DB::table('permissions')->insert($records);
    }
}
