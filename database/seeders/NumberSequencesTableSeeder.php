<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NumberSequencesTableSeeder extends Seeder
{
    public function run(): void
    {
        $companyId = DB::table('companies')->value('id');

        $types = [
            ['doc' => 'company',   'prefix' => 'CMP', 'date_format' => null,  'padding' => 3],
            ['doc' => 'branch',    'prefix' => 'BR',  'date_format' => null,  'padding' => 3],
            ['doc' => 'product',   'prefix' => 'PRD', 'date_format' => null,  'padding' => 4],
            ['doc' => 'supplier',  'prefix' => 'SUP', 'date_format' => null,  'padding' => 3],
            ['doc' => 'customer',  'prefix' => 'CUST','date_format' => null,  'padding' => 3],
            ['doc' => 'purchase',  'prefix' => 'PO',  'date_format' => 'Ymd', 'padding' => 5],
            ['doc' => 'sale',      'prefix' => 'INV', 'date_format' => 'Ymd', 'padding' => 5],
            ['doc' => 'quotation', 'prefix' => 'QT',  'date_format' => 'Ymd', 'padding' => 5],
            ['doc' => 'transfer',  'prefix' => 'TRF', 'date_format' => 'Ymd', 'padding' => 5],
            ['doc' => 'return',    'prefix' => 'RET', 'date_format' => 'Ymd', 'padding' => 5],
            ['doc' => 'delivery',  'prefix' => 'DLV', 'date_format' => 'Ymd', 'padding' => 5],
            ['doc' => 'expense',   'prefix' => 'EXP', 'date_format' => 'Ym',  'padding' => 5],
        ];

        $records = [];
        foreach ($types as $t) {
            $records[] = [
                'company_id'   => $companyId,
                'branch_id'    => null,
                'document_type'=> $t['doc'],
                'prefix'       => $t['prefix'],
                'date_format'  => $t['date_format'],
                'next_number'  => 1,
                'padding'      => $t['padding'],
                'suffix'       => null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ];
        }

        DB::table('number_sequences')->insert($records);
    }
}
