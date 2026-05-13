<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchesTableSeeder extends Seeder
{
    public function run(): void
    {
        $companyId = DB::table('companies')->value('id');
        $managerId = DB::table('users')->where('email', 'manager1@demo.local')->value('id');

        DB::table('branches')->insert([
            [
                'company_id'     => $companyId,
                'manager_user_id'=> $managerId,
                'branch_code'    => 'BR001',
                'name'           => 'សាខាកណ្តាល (ភ្នំពេញ)',
                'phone'          => '023 456 789',
                'email'          => 'branch.main@demo.local',
                'address'        => 'ផ្លូវ 271, សង្កាត់វាលវង់, ខណ្ឌ៧មករា, ភ្នំពេញ',
                'is_main_branch' => true,
                'is_active'      => true,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'company_id'     => $companyId,
                'manager_user_id'=> null,
                'branch_code'    => 'BR002',
                'name'           => 'សាខាទួលគោក',
                'phone'          => '023 567 890',
                'email'          => 'branch.tk@demo.local',
                'address'        => 'ផ្លូវ 315, សង្កាត់ទួលគោក, ខណ្ឌទួលគោក, ភ្នំពេញ',
                'is_main_branch' => false,
                'is_active'      => true,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'company_id'     => $companyId,
                'manager_user_id'=> null,
                'branch_code'    => 'BR003',
                'name'           => 'សាខាមានជ័យ',
                'phone'          => '023 678 901',
                'email'          => 'branch.mj@demo.local',
                'address'        => 'ផ្លូវ 1, ខណ្ឌមានជ័យ, ភ្នំពេញ',
                'is_main_branch' => false,
                'is_active'      => true,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ]);

        // Update users' default_branch_id
        $mainBranchId = DB::table('branches')->where('branch_code', 'BR001')->value('id');
        DB::table('users')->update(['default_branch_id' => $mainBranchId]);
    }
}
