<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompaniesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('companies')->insert([
            [
                'company_code'  => 'CMP001',
                'name'          => 'Construction Store Co., Ltd.',
                'owner_name'    => 'ស្រ៊ី សំណាំង',
                'phone'         => '012 345 678',
                'email'         => 'info@constructionstore.com',
                'website'       => 'https://constructionstore.com',
                'address'       => 'ភ្នំពេញ, កម្ពុជា',
                'tax_number'    => 'TAX-2024-001',
                'logo_path'     => null,
                'currency_code' => 'KHR',
                'language'      => 'km',
                'is_active'     => true,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ]);
    }
}
