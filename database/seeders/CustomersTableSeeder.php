<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomersTableSeeder extends Seeder
{
    public function run(): void
    {
        $companyId = DB::table('companies')->value('id');

        $types = ['walk_in', 'regular', 'wholesale', 'contractor', 'company', 'project_owner'];

        $customers = [
            ['code'=>'CUST001','name'=>'អតិថិជនទូទៅ (Walk-in)','phone'=>null,          'email'=>null,                     'type'=>'walk_in',     'is_walk_in'=>true, 'credit_limit'=>0,       'credit_days'=>0],
            ['code'=>'CUST002','name'=>'លោក ហេង ចាន់ណា',       'phone'=>'012 111 222', 'email'=>'hchanna@gmail.com',      'type'=>'regular',     'is_walk_in'=>false,'credit_limit'=>500000, 'credit_days'=>15],
            ['code'=>'CUST003','name'=>'លោក ស្រ៊ី វ៉ាន់ណឺ',    'phone'=>'012 222 333', 'email'=>'svannor@gmail.com',      'type'=>'regular',     'is_walk_in'=>false,'credit_limit'=>800000, 'credit_days'=>15],
            ['code'=>'CUST004','name'=>'ក្រុមហ៊ុន សំណង់ ចំការ', 'phone'=>'023 333 444', 'email'=>'chamkar@company.com',    'type'=>'company',     'is_walk_in'=>false,'credit_limit'=>5000000,'credit_days'=>30],
            ['code'=>'CUST005','name'=>'ក្រុមហ៊ុន យូ អេ អាយ',  'phone'=>'023 444 555', 'email'=>'uai@company.com',        'type'=>'company',     'is_walk_in'=>false,'credit_limit'=>8000000,'credit_days'=>30],
            ['code'=>'CUST006','name'=>'ម្ចាស់ Project ល្វើយ',   'phone'=>'012 555 666', 'email'=>null,                     'type'=>'project_owner','is_walk_in'=>false,'credit_limit'=>3000000,'credit_days'=>45],
            ['code'=>'CUST007','name'=>'អ្នកម៉ៅ ដារ៉ា',         'phone'=>'012 666 777', 'email'=>'dara.mao@gmail.com',     'type'=>'contractor',  'is_walk_in'=>false,'credit_limit'=>2000000,'credit_days'=>30],
            ['code'=>'CUST008','name'=>'លក់ដុំ - ហ្សុង',        'phone'=>'012 777 888', 'email'=>'jong.wholesale@gmail.com','type'=>'wholesale',   'is_walk_in'=>false,'credit_limit'=>6000000,'credit_days'=>30],
            ['code'=>'CUST009','name'=>'ក្រុមហ៊ុន កសិករ ស្ថាបនា','phone'=>'023 888 999','email'=>'kasikor@company.com',   'type'=>'company',     'is_walk_in'=>false,'credit_limit'=>10000000,'credit_days'=>60],
            ['code'=>'CUST010','name'=>'លោក ចាន់ ​ស្រ៊ីណា',     'phone'=>'012 999 000', 'email'=>null,                     'type'=>'regular',     'is_walk_in'=>false,'credit_limit'=>300000, 'credit_days'=>15],
            ['code'=>'CUST011','name'=>'លោកស្រី ​ ចន្ទ ​ ម៉ារីន', 'phone'=>'011 100 200', 'email'=>'marin@gmail.com',       'type'=>'regular',     'is_walk_in'=>false,'credit_limit'=>500000, 'credit_days'=>15],
            ['code'=>'CUST012','name'=>'ក្រុមហ៊ុន ​ ដំណើរ ​ ថ្ម',  'phone'=>'023 100 300', 'email'=>'damnor@company.com',    'type'=>'company',     'is_walk_in'=>false,'credit_limit'=>4000000,'credit_days'=>30],
            ['code'=>'CUST013','name'=>'អ្នកម៉ៅ វ៉ា',             'phone'=>'015 100 400', 'email'=>null,                     'type'=>'contractor',  'is_walk_in'=>false,'credit_limit'=>1500000,'credit_days'=>30],
            ['code'=>'CUST014','name'=>'ម្ចាស់ Project បឹងកេង',  'phone'=>'012 100 500', 'email'=>null,                     'type'=>'project_owner','is_walk_in'=>false,'credit_limit'=>5000000,'credit_days'=>45],
            ['code'=>'CUST015','name'=>'លក់ដុំ - ណូ',            'phone'=>'016 100 600', 'email'=>null,                     'type'=>'wholesale',   'is_walk_in'=>false,'credit_limit'=>4000000,'credit_days'=>30],
        ];

        $records = [];
        foreach ($customers as $c) {
            $records[] = [
                'company_id'      => $companyId,
                'customer_code'   => $c['code'],
                'name'            => $c['name'],
                'phone'           => $c['phone'],
                'email'           => $c['email'],
                'address'         => 'ភ្នំពេញ, កម្ពុជា',
                'customer_type'   => $c['type'],
                'project_name'    => null,
                'opening_balance' => 0,
                'current_balance' => 0,
                'credit_limit'    => $c['credit_limit'],
                'credit_days'     => $c['credit_days'],
                'is_walk_in'      => $c['is_walk_in'],
                'is_active'       => true,
                'created_at'      => now(),
                'updated_at'      => now(),
            ];
        }

        DB::table('customers')->insert($records);
    }
}
