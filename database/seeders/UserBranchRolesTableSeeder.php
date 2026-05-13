<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserBranchRolesTableSeeder extends Seeder
{
    public function run(): void
    {
        $users    = DB::table('users')->get();
        $branches = DB::table('branches')->get();

        $records = [];
        foreach ($users as $user) {
            foreach ($branches as $index => $branch) {
                $records[] = [
                    'user_id'    => $user->id,
                    'branch_id'  => $branch->id,
                    'role_id'    => $user->role_id,
                    'is_default' => $index === 0, // first branch is default
                    'is_active'  => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('user_branch_roles')->insert($records);
    }
}
