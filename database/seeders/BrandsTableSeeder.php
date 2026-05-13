<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandsTableSeeder extends Seeder
{
    public function run(): void
    {
        $companyId = DB::table('companies')->value('id');

        DB::table('brands')->insert([
            ['company_id' => $companyId, 'name' => 'Scg',         'country' => 'Thailand',  'contact_phone' => null, 'contact_email' => null, 'note' => null, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['company_id' => $companyId, 'name' => 'Insee',       'country' => 'Thailand',  'contact_phone' => null, 'contact_email' => null, 'note' => null, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['company_id' => $companyId, 'name' => 'Kampot Cement','country' => 'Cambodia', 'contact_phone' => null, 'contact_email' => null, 'note' => null, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['company_id' => $companyId, 'name' => 'Chip Mong',   'country' => 'Cambodia',  'contact_phone' => null, 'contact_email' => null, 'note' => null, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['company_id' => $companyId, 'name' => 'Posco',       'country' => 'South Korea','contact_phone'=> null, 'contact_email' => null, 'note' => null, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['company_id' => $companyId, 'name' => 'Nippon Paint', 'country' => 'Japan',    'contact_phone' => null, 'contact_email' => null, 'note' => null, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['company_id' => $companyId, 'name' => 'Beger',       'country' => 'Thailand',  'contact_phone' => null, 'contact_email' => null, 'note' => null, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['company_id' => $companyId, 'name' => 'Bosch',       'country' => 'Germany',   'contact_phone' => null, 'contact_email' => null, 'note' => null, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['company_id' => $companyId, 'name' => 'Makita',      'country' => 'Japan',     'contact_phone' => null, 'contact_email' => null, 'note' => null, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['company_id' => $companyId, 'name' => 'PPR Pipe',    'country' => 'China',     'contact_phone' => null, 'contact_email' => null, 'note' => null, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
