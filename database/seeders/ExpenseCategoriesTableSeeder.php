<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExpenseCategoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        $companyId = DB::table('companies')->value('id');

        DB::table('expense_categories')->insert([
            ['company_id' => $companyId, 'name' => 'ប្រាក់ខែ (Salary)',            'slug' => 'salary',           'description' => null, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['company_id' => $companyId, 'name' => 'ថ្លៃជួល (Rent)',               'slug' => 'rent',             'description' => null, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['company_id' => $companyId, 'name' => 'ភ្លើង-ទឹក (Utilities)',         'slug' => 'utilities',        'description' => null, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['company_id' => $companyId, 'name' => 'ឥន្ធនៈ (Fuel)',                'slug' => 'fuel',             'description' => null, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['company_id' => $companyId, 'name' => 'ថ្ងៃភ្ជុំ-ម្ហូបទទួល (Meals)',  'slug' => 'meals',            'description' => null, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['company_id' => $companyId, 'name' => 'ថ្លៃដឹក (Delivery Expenses)',  'slug' => 'delivery-expense', 'description' => null, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['company_id' => $companyId, 'name' => 'ថ្លៃថែទាំ (Maintenance)',     'slug' => 'maintenance',      'description' => null, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['company_id' => $companyId, 'name' => 'ផ្សេងៗ (Miscellaneous)',       'slug' => 'miscellaneous',    'description' => null, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
