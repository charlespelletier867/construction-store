<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DriversTableSeeder extends Seeder
{
    public function run(): void
    {
        $companyId = DB::table('companies')->value('id');

        DB::table('drivers')->insert([
            [
                'company_id'  => $companyId,
                'driver_code' => 'DRV001',
                'name'        => 'លោក ​ ស៊ុន ​ ណារ៉ា',
                'phone'       => '012 100 001',
                'address'     => 'ភ្នំពេញ, កម្ពុជា',
                'license_no'  => 'LIC-2024-001',
                'is_active'   => true,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'company_id'  => $companyId,
                'driver_code' => 'DRV002',
                'name'        => 'លោក ​ ហ៊ាន ​ ឌីណា',
                'phone'       => '012 100 002',
                'address'     => 'ភ្នំពេញ, កម្ពុជា',
                'license_no'  => 'LIC-2024-002',
                'is_active'   => true,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'company_id'  => $companyId,
                'driver_code' => 'DRV003',
                'name'        => 'លោក ​ ផន ​ ​ ស្រ៊ីណា',
                'phone'       => '012 100 003',
                'address'     => 'ភ្នំពេញ, កម្ពុជា',
                'license_no'  => 'LIC-2024-003',
                'is_active'   => true,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}
