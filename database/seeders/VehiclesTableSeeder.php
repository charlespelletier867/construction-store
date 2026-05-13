<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehiclesTableSeeder extends Seeder
{
    public function run(): void
    {
        $companyId = DB::table('companies')->value('id');
        $drivers   = DB::table('drivers')->where('company_id', $companyId)->get();

        DB::table('vehicles')->insert([
            [
                'company_id'   => $companyId,
                'driver_id'    => $drivers->get(0)?->id,
                'vehicle_code' => 'VH001',
                'plate_number' => '2A-1234',
                'vehicle_type' => 'truck',
                'capacity'     => '5 tons',
                'status'       => 'available',
                'note'         => 'ឡានដឹកទំនិញធំ',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'company_id'   => $companyId,
                'driver_id'    => $drivers->get(1)?->id,
                'vehicle_code' => 'VH002',
                'plate_number' => '2B-5678',
                'vehicle_type' => 'pickup',
                'capacity'     => '1 ton',
                'status'       => 'available',
                'note'         => 'ឡានជាប់',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'company_id'   => $companyId,
                'driver_id'    => $drivers->get(2)?->id,
                'vehicle_code' => 'VH003',
                'plate_number' => '3C-9012',
                'vehicle_type' => 'van',
                'capacity'     => '2 tons',
                'status'       => 'available',
                'note'         => 'ឡានដឹកទំនិញតូច',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ]);
    }
}
