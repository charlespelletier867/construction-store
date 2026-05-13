<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        $companyId     = DB::table('companies')->value('id');
        $superAdminRole = DB::table('roles')->where('slug', 'super-admin')->value('id');
        $adminRole     = DB::table('roles')->where('slug', 'admin')->value('id');
        $cashierRole   = DB::table('roles')->where('slug', 'cashier')->value('id');
        $managerRole   = DB::table('roles')->where('slug', 'branch-manager')->value('id');
        $warehouseRole = DB::table('roles')->where('slug', 'warehouse-staff')->value('id');
        $accountRole   = DB::table('roles')->where('slug', 'accountant')->value('id');

        DB::table('users')->insert([
            [
                'company_id'                => $companyId,
                'default_branch_id'         => null,
                'role_id'                   => $superAdminRole,
                'user_code'                 => 'USR0001',
                'name'                      => 'Super Administrator',
                'email'                     => 'superadmin@demo.local',
                'phone'                     => '012 000 001',
                'password'                  => Hash::make('password'),
                'avatar_path'               => null,
                'can_view_money'            => true,
                'can_view_profit'           => true,
                'can_override_credit_limit' => true,
                'is_active'                 => true,
                'last_login_at'             => null,
                'created_at'                => now(),
                'updated_at'                => now(),
            ],
            [
                'company_id'                => $companyId,
                'default_branch_id'         => null,
                'role_id'                   => $adminRole,
                'user_code'                 => 'USR0002',
                'name'                      => 'Admin Demo',
                'email'                     => 'admin@demo.local',
                'phone'                     => '012 000 002',
                'password'                  => Hash::make('password'),
                'avatar_path'               => null,
                'can_view_money'            => true,
                'can_view_profit'           => true,
                'can_override_credit_limit' => false,
                'is_active'                 => true,
                'last_login_at'             => null,
                'created_at'                => now(),
                'updated_at'                => now(),
            ],
            [
                'company_id'                => $companyId,
                'default_branch_id'         => null,
                'role_id'                   => $managerRole,
                'user_code'                 => 'USR0003',
                'name'                      => 'Branch Manager 1',
                'email'                     => 'manager1@demo.local',
                'phone'                     => '012 000 003',
                'password'                  => Hash::make('password'),
                'avatar_path'               => null,
                'can_view_money'            => true,
                'can_view_profit'           => false,
                'can_override_credit_limit' => false,
                'is_active'                 => true,
                'last_login_at'             => null,
                'created_at'                => now(),
                'updated_at'                => now(),
            ],
            [
                'company_id'                => $companyId,
                'default_branch_id'         => null,
                'role_id'                   => $cashierRole,
                'user_code'                 => 'USR0004',
                'name'                      => 'Cashier 1',
                'email'                     => 'cashier1@demo.local',
                'phone'                     => '012 000 004',
                'password'                  => Hash::make('password'),
                'avatar_path'               => null,
                'can_view_money'            => false,
                'can_view_profit'           => false,
                'can_override_credit_limit' => false,
                'is_active'                 => true,
                'last_login_at'             => null,
                'created_at'                => now(),
                'updated_at'                => now(),
            ],
            [
                'company_id'                => $companyId,
                'default_branch_id'         => null,
                'role_id'                   => $warehouseRole,
                'user_code'                 => 'USR0005',
                'name'                      => 'Warehouse Staff 1',
                'email'                     => 'warehouse1@demo.local',
                'phone'                     => '012 000 005',
                'password'                  => Hash::make('password'),
                'avatar_path'               => null,
                'can_view_money'            => false,
                'can_view_profit'           => false,
                'can_override_credit_limit' => false,
                'is_active'                 => true,
                'last_login_at'             => null,
                'created_at'                => now(),
                'updated_at'                => now(),
            ],
            [
                'company_id'                => $companyId,
                'default_branch_id'         => null,
                'role_id'                   => $accountRole,
                'user_code'                 => 'USR0006',
                'name'                      => 'Accountant 1',
                'email'                     => 'accountant1@demo.local',
                'phone'                     => '012 000 006',
                'password'                  => Hash::make('password'),
                'avatar_path'               => null,
                'can_view_money'            => true,
                'can_view_profit'           => true,
                'can_override_credit_limit' => false,
                'is_active'                 => true,
                'last_login_at'             => null,
                'created_at'                => now(),
                'updated_at'                => now(),
            ],
        ]);
    }
}
