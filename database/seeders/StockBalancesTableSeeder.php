<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockBalancesTableSeeder extends Seeder
{
    public function run(): void
    {
        $companyId  = DB::table('companies')->value('id');
        $products   = DB::table('products')->where('company_id', $companyId)->get();
        $warehouses = DB::table('warehouses')->where('company_id', $companyId)->where('is_default', true)->get();

        $records = [];
        foreach ($warehouses as $wh) {
            foreach ($products as $product) {
                $qty = rand(20, 500);
                $records[] = [
                    'company_id'         => $companyId,
                    'branch_id'          => $wh->branch_id,
                    'warehouse_id'       => $wh->id,
                    'product_id'         => $product->id,
                    'quantity'           => $qty,
                    'reserved_quantity'  => 0,
                    'available_quantity' => $qty,
                    'average_cost'       => $product->purchase_price,
                    'stock_value'        => $qty * $product->purchase_price,
                    'last_movement_at'   => now(),
                    'created_at'         => now(),
                    'updated_at'         => now(),
                ];
            }
        }

        DB::table('stock_balances')->insert($records);
    }
}
