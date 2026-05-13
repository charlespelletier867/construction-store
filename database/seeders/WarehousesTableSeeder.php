<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WarehousesTableSeeder extends Seeder
{
    public function run(): void
    {
        $companyId = DB::table('companies')->value('id');
        $branches  = DB::table('branches')->get();

        $warehouses = [];
        foreach ($branches as $branch) {
            $warehouses[] = [
                'company_id'     => $companyId,
                'branch_id'      => $branch->id,
                'warehouse_code' => 'WH' . str_pad($branch->id, 3, '0', STR_PAD_LEFT) . 'A',
                'name'           => $branch->name . ' - ឃ្លាំងទី១',
                'address'        => $branch->address,
                'is_default'     => true,
                'is_active'      => true,
                'created_at'     => now(),
                'updated_at'     => now(),
            ];
            $warehouses[] = [
                'company_id'     => $companyId,
                'branch_id'      => $branch->id,
                'warehouse_code' => 'WH' . str_pad($branch->id, 3, '0', STR_PAD_LEFT) . 'B',
                'name'           => $branch->name . ' - ឃ្លាំងទី២',
                'address'        => $branch->address,
                'is_default'     => false,
                'is_active'      => true,
                'created_at'     => now(),
                'updated_at'     => now(),
            ];
        }

        DB::table('warehouses')->insert($warehouses);
    }
}
