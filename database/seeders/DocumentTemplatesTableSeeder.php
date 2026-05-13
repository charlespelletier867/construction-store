<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentTemplatesTableSeeder extends Seeder
{
    public function run(): void
    {
        $companyId = DB::table('companies')->value('id');

        DB::table('document_templates')->insert([
            [
                'company_id'    => $companyId,
                'branch_id'     => null,
                'template_type' => 'invoice',
                'name'          => 'វិក្កយបត្រលក់ (Default)',
                'paper_size'    => 'A4',
                'logo_path'     => null,
                'header'        => 'Construction Store Co., Ltd. | ភ្នំពេញ | Tel: 012 345 678',
                'footer'        => 'សូមអរគុណដែលបានប្រើប្រាស់សេវាកម្មរបស់យើងខ្ញុំ!',
                'options'       => json_encode(['show_discount' => true, 'show_tax' => false, 'show_due_amount' => true]),
                'is_default'    => true,
                'is_active'     => true,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'company_id'    => $companyId,
                'branch_id'     => null,
                'template_type' => 'receipt',
                'name'          => 'បង្កាន់ដៃទទួលប្រាក់ (Default)',
                'paper_size'    => 'A5',
                'logo_path'     => null,
                'header'        => 'Construction Store Co., Ltd.',
                'footer'        => 'ទទួលប្រាក់ដោយ: ___________________',
                'options'       => json_encode(['show_signature' => true]),
                'is_default'    => true,
                'is_active'     => true,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'company_id'    => $companyId,
                'branch_id'     => null,
                'template_type' => 'quotation',
                'name'          => 'សំណើតម្លៃ (Default)',
                'paper_size'    => 'A4',
                'logo_path'     => null,
                'header'        => 'Construction Store Co., Ltd.',
                'footer'        => 'តម្លៃអាចផ្លាស់ប្ដូរបានដោយមិនបាច់ជូនដំណឹងជាមុន',
                'options'       => json_encode(['show_discount' => true, 'show_terms' => true]),
                'is_default'    => true,
                'is_active'     => true,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'company_id'    => $companyId,
                'branch_id'     => null,
                'template_type' => 'delivery_note',
                'name'          => 'វិក្ក័យបត្រដឹក (Default)',
                'paper_size'    => 'A5',
                'logo_path'     => null,
                'header'        => 'Construction Store Co., Ltd. - ការដឹកជញ្ជូន',
                'footer'        => 'ហត្ថលេខាអ្នកទទួល: ___________________',
                'options'       => json_encode(['show_signature' => true]),
                'is_default'    => true,
                'is_active'     => true,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'company_id'    => $companyId,
                'branch_id'     => null,
                'template_type' => 'payment_voucher',
                'name'          => 'ប័ណ្ណបង់ប្រាក់ (Default)',
                'paper_size'    => 'A5',
                'logo_path'     => null,
                'header'        => 'Construction Store Co., Ltd.',
                'footer'        => 'អ្នកប្រគល់: ___________ អ្នកទទួល: ___________',
                'options'       => json_encode(['show_signature' => true]),
                'is_default'    => true,
                'is_active'     => true,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ]);
    }
}
