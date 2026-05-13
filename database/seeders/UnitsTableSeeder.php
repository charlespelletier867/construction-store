<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitsTableSeeder extends Seeder
{
    public function run(): void
    {
        $companyId = DB::table('companies')->value('id');

        DB::table('units')->insert([
            ['company_id' => $companyId, 'name' => 'គ្រាប់ (Piece)',      'short_name' => 'pcs',  'base_quantity' => 1,    'description' => null, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['company_id' => $companyId, 'name' => 'ប្រអប់ (Box)',        'short_name' => 'box',  'base_quantity' => 1,    'description' => null, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['company_id' => $companyId, 'name' => 'គីឡូក្រាម (Kg)',      'short_name' => 'kg',   'base_quantity' => 1,    'description' => null, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['company_id' => $companyId, 'name' => 'តោន (Ton)',            'short_name' => 'ton',  'base_quantity' => 1000, 'description' => null, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['company_id' => $companyId, 'name' => 'ម៉ែត្រ (Meter)',       'short_name' => 'm',    'base_quantity' => 1,    'description' => null, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['company_id' => $companyId, 'name' => 'ម៉ែត្រការ៉េ (m²)',     'short_name' => 'm2',   'base_quantity' => 1,    'description' => null, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['company_id' => $companyId, 'name' => 'ម៉ែត្រគូប (m³)',       'short_name' => 'm3',   'base_quantity' => 1,    'description' => null, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['company_id' => $companyId, 'name' => 'លីត្រ (Liter)',        'short_name' => 'L',    'base_quantity' => 1,    'description' => null, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['company_id' => $companyId, 'name' => 'ថង់ (Bag)',            'short_name' => 'bag',  'base_quantity' => 1,    'description' => null, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['company_id' => $companyId, 'name' => 'ដំបូង (Roll)',         'short_name' => 'roll', 'base_quantity' => 1,    'description' => null, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['company_id' => $companyId, 'name' => 'ជើង (Feet)',           'short_name' => 'ft',   'base_quantity' => 1,    'description' => null, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['company_id' => $companyId, 'name' => 'គំនរ (Bundle)',        'short_name' => 'bnd',  'base_quantity' => 1,    'description' => null, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
