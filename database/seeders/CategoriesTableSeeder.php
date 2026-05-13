<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        $companyId = DB::table('companies')->value('id');

        $parents = [
            ['code' => 'CAT01', 'name' => 'សម្ភារៈសំណង់ (Construction Materials)'],
            ['code' => 'CAT02', 'name' => 'ដែក និងរ៉ែ (Steel & Metal)'],
            ['code' => 'CAT03', 'name' => 'ឧបករណ៍ (Tools & Equipment)'],
            ['code' => 'CAT04', 'name' => 'ការពាក់ (Plumbing)'],
            ['code' => 'CAT05', 'name' => 'អគ្គិសនី (Electrical)'],
            ['code' => 'CAT06', 'name' => 'ថ្នាំលាប និងធ្វើ Finish (Paint & Finishing)'],
        ];

        $parentIds = [];
        foreach ($parents as $p) {
            $id = DB::table('categories')->insertGetId([
                'company_id'  => $companyId,
                'parent_id'   => null,
                'name'        => $p['name'],
                'slug'        => str_replace(['(', ')', ' ', '&'], ['-', '-', '-', '-'], strtolower($p['name'])),
                'code'        => $p['code'],
                'description' => null,
                'is_active'   => true,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
            $parentIds[$p['code']] = $id;
        }

        // Sub-categories
        $children = [
            ['parent' => 'CAT01', 'code' => 'CAT0101', 'name' => 'ថ្ម (Stone)'],
            ['parent' => 'CAT01', 'code' => 'CAT0102', 'name' => 'ខ្សាច់ (Sand)'],
            ['parent' => 'CAT01', 'code' => 'CAT0103', 'name' => 'ស៊ីម៉ង់ (Cement)'],
            ['parent' => 'CAT01', 'code' => 'CAT0104', 'name' => 'ឥដ្ឋ (Brick)'],
            ['parent' => 'CAT02', 'code' => 'CAT0201', 'name' => 'ដែកប្រឡោះ (Steel Rod)'],
            ['parent' => 'CAT02', 'code' => 'CAT0202', 'name' => 'ដែកសន្លឹក (Steel Sheet)'],
            ['parent' => 'CAT02', 'code' => 'CAT0203', 'name' => 'សសរដែក (Steel Column)'],
            ['parent' => 'CAT03', 'code' => 'CAT0301', 'name' => 'ដងស (Drill)'],
            ['parent' => 'CAT03', 'code' => 'CAT0302', 'name' => 'ណាំ (Hammer)'],
            ['parent' => 'CAT04', 'code' => 'CAT0401', 'name' => 'បំពង់ (Pipe)'],
            ['parent' => 'CAT04', 'code' => 'CAT0402', 'name' => 'ក្បាប (Fittings)'],
            ['parent' => 'CAT05', 'code' => 'CAT0501', 'name' => 'ខ្សែភ្លើង (Electrical Wire)'],
            ['parent' => 'CAT05', 'code' => 'CAT0502', 'name' => 'ប្រអប់ Switch (Switches)'],
            ['parent' => 'CAT06', 'code' => 'CAT0601', 'name' => 'ថ្នាំលាបជញ្ជាំង (Wall Paint)'],
            ['parent' => 'CAT06', 'code' => 'CAT0602', 'name' => 'ថ្នាំលាបទ្វារ (Door Paint)'],
        ];

        $childRecords = [];
        foreach ($children as $c) {
            $childRecords[] = [
                'company_id'  => $companyId,
                'parent_id'   => $parentIds[$c['parent']],
                'name'        => $c['name'],
                'slug'        => str_replace(['(', ')', ' ', '&'], ['-', '-', '-', '-'], strtolower($c['name'])),
                'code'        => $c['code'],
                'description' => null,
                'is_active'   => true,
                'created_at'  => now(),
                'updated_at'  => now(),
            ];
        }
        DB::table('categories')->insert($childRecords);
    }
}
