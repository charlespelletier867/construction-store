<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SystemSettingsTableSeeder extends Seeder
{
    public function run(): void
    {
        $companyId = DB::table('companies')->value('id');

        $settings = [
            // General
            ['group' => 'general', 'key' => 'app_name',            'value' => 'Construction Store',      'value_type' => 'string',  'is_public' => true],
            ['group' => 'general', 'key' => 'app_tagline',         'value' => 'ប្រព័ន្ធគ្រប់គ្រងហាងសំណង់', 'value_type' => 'string',  'is_public' => true],
            ['group' => 'general', 'key' => 'currency_code',       'value' => 'KHR',                     'value_type' => 'string',  'is_public' => true],
            ['group' => 'general', 'key' => 'currency_symbol',     'value' => '៛',                       'value_type' => 'string',  'is_public' => true],
            ['group' => 'general', 'key' => 'usd_rate',            'value' => '4100',                    'value_type' => 'decimal', 'is_public' => true],
            ['group' => 'general', 'key' => 'default_language',    'value' => 'km',                      'value_type' => 'string',  'is_public' => true],
            ['group' => 'general', 'key' => 'date_format',         'value' => 'd/m/Y',                   'value_type' => 'string',  'is_public' => false],
            ['group' => 'general', 'key' => 'timezone',            'value' => 'Asia/Phnom_Penh',         'value_type' => 'string',  'is_public' => false],
            // Tax
            ['group' => 'tax',     'key' => 'tax_enabled',         'value' => '0',                       'value_type' => 'boolean', 'is_public' => false],
            ['group' => 'tax',     'key' => 'default_tax_rate',    'value' => '10',                      'value_type' => 'decimal', 'is_public' => false],
            ['group' => 'tax',     'key' => 'tax_label',           'value' => 'VAT',                     'value_type' => 'string',  'is_public' => false],
            // Stock
            ['group' => 'stock',   'key' => 'allow_negative_stock','value' => '0',                       'value_type' => 'boolean', 'is_public' => false],
            ['group' => 'stock',   'key' => 'low_stock_alert',     'value' => '1',                       'value_type' => 'boolean', 'is_public' => false],
            ['group' => 'stock',   'key' => 'cost_method',         'value' => 'average',                 'value_type' => 'string',  'is_public' => false],
            // Sale
            ['group' => 'sale',    'key' => 'default_sale_type',   'value' => 'retail',                  'value_type' => 'string',  'is_public' => false],
            ['group' => 'sale',    'key' => 'print_after_sale',    'value' => '1',                       'value_type' => 'boolean', 'is_public' => false],
            ['group' => 'sale',    'key' => 'allow_credit_sale',   'value' => '1',                       'value_type' => 'boolean', 'is_public' => false],
            // Purchase
            ['group' => 'purchase','key' => 'auto_receive',        'value' => '0',                       'value_type' => 'boolean', 'is_public' => false],
        ];

        $records = [];
        foreach ($settings as $s) {
            $records[] = [
                'company_id'  => $companyId,
                'branch_id'   => null,
                'group'       => $s['group'],
                'key'         => $s['key'],
                'value'       => $s['value'],
                'value_type'  => $s['value_type'],
                'is_public'   => $s['is_public'],
                'created_at'  => now(),
                'updated_at'  => now(),
            ];
        }

        DB::table('system_settings')->insert($records);
    }
}
