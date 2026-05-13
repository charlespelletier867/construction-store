<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    public function run(): void
    {
        $companyId = DB::table('companies')->value('id');
        $catMap    = DB::table('categories')->where('company_id', $companyId)->pluck('id', 'code');
        $brandMap  = DB::table('brands')->where('company_id', $companyId)->pluck('id', 'name');
        $unitMap   = DB::table('units')->where('company_id', $companyId)->pluck('id', 'short_name');

        $products = [
            // Construction Materials
            ['code'=>'PRD0001','name'=>'ស៊ីម៉ង់ SCG 50kg','cat'=>'CAT0103','brand'=>'Scg',    'unit'=>'bag', 'buy'=>28000,'retail'=>32000,'wholesale'=>30000,'size'=>'50kg'],
            ['code'=>'PRD0002','name'=>'ស៊ីម៉ង់ INSEE 50kg','cat'=>'CAT0103','brand'=>'Insee',  'unit'=>'bag', 'buy'=>27000,'retail'=>31000,'wholesale'=>29000,'size'=>'50kg'],
            ['code'=>'PRD0003','name'=>'ស៊ីម៉ង់ Kampot 50kg','cat'=>'CAT0103','brand'=>'Kampot Cement','unit'=>'bag','buy'=>26000,'retail'=>30000,'wholesale'=>28000,'size'=>'50kg'],
            ['code'=>'PRD0004','name'=>'ថ្ម 0.5 (ស្ករ)','cat'=>'CAT0101','brand'=>'Chip Mong','unit'=>'m3', 'buy'=>60000,'retail'=>75000,'wholesale'=>68000,'size'=>'0.5m'],
            ['code'=>'PRD0005','name'=>'ថ្ម 1 (ស)',      'cat'=>'CAT0101','brand'=>'Chip Mong','unit'=>'m3', 'buy'=>55000,'retail'=>70000,'wholesale'=>63000,'size'=>'1m'],
            ['code'=>'PRD0006','name'=>'ខ្សាច់',         'cat'=>'CAT0102','brand'=>'Chip Mong','unit'=>'m3', 'buy'=>30000,'retail'=>45000,'wholesale'=>38000,'size'=>null],
            ['code'=>'PRD0007','name'=>'ឥដ្ឋ (1000 គ្រាប់)','cat'=>'CAT0104','brand'=>'Chip Mong','unit'=>'pcs','buy'=>400,'retail'=>550,'wholesale'=>480,'size'=>null],
            // Steel
            ['code'=>'PRD0008','name'=>'ដែកប្រឡោះ Ø10 (12m)','cat'=>'CAT0201','brand'=>'Posco','unit'=>'pcs','buy'=>28000,'retail'=>33000,'wholesale'=>30000,'size'=>'Ø10'],
            ['code'=>'PRD0009','name'=>'ដែកប្រឡោះ Ø12 (12m)','cat'=>'CAT0201','brand'=>'Posco','unit'=>'pcs','buy'=>40000,'retail'=>48000,'wholesale'=>44000,'size'=>'Ø12'],
            ['code'=>'PRD0010','name'=>'ដែកប្រឡោះ Ø16 (12m)','cat'=>'CAT0201','brand'=>'Posco','unit'=>'pcs','buy'=>70000,'retail'=>82000,'wholesale'=>76000,'size'=>'Ø16'],
            ['code'=>'PRD0011','name'=>'ដែកសន្លឹក 1.2mm (4x8)','cat'=>'CAT0202','brand'=>'Posco','unit'=>'pcs','buy'=>35000,'retail'=>42000,'wholesale'=>38000,'size'=>'1.2mm'],
            // Paint
            ['code'=>'PRD0012','name'=>'ថ្នាំ Nippon 5L (ស)','cat'=>'CAT0601','brand'=>'Nippon Paint','unit'=>'L','buy'=>55000,'retail'=>70000,'wholesale'=>63000,'size'=>'5L'],
            ['code'=>'PRD0013','name'=>'ថ្នាំ Nippon 5L (ខ្មៅ)','cat'=>'CAT0601','brand'=>'Nippon Paint','unit'=>'L','buy'=>55000,'retail'=>70000,'wholesale'=>63000,'size'=>'5L'],
            ['code'=>'PRD0014','name'=>'ថ្នាំ Beger 18L (ស)','cat'=>'CAT0601','brand'=>'Beger',       'unit'=>'L','buy'=>120000,'retail'=>145000,'wholesale'=>132000,'size'=>'18L'],
            // Tools
            ['code'=>'PRD0015','name'=>'ដ្រីល Bosch GSB 13RE','cat'=>'CAT0301','brand'=>'Bosch', 'unit'=>'pcs','buy'=>120000,'retail'=>145000,'wholesale'=>133000,'size'=>null],
            ['code'=>'PRD0016','name'=>'ដ្រីល Makita HP1630','cat'=>'CAT0301','brand'=>'Makita','unit'=>'pcs','buy'=>110000,'retail'=>135000,'wholesale'=>122000,'size'=>null],
            ['code'=>'PRD0017','name'=>'ស្រួចដំ (Nail Gun)',  'cat'=>'CAT0302','brand'=>'Bosch', 'unit'=>'pcs','buy'=>80000,'retail'=>98000,'wholesale'=>89000,'size'=>null],
            // Plumbing
            ['code'=>'PRD0018','name'=>'បំពង់ PPR 20mm (4m)','cat'=>'CAT0401','brand'=>'PPR Pipe','unit'=>'pcs','buy'=>8000,'retail'=>12000,'wholesale'=>10000,'size'=>'20mm'],
            ['code'=>'PRD0019','name'=>'បំពង់ PPR 25mm (4m)','cat'=>'CAT0401','brand'=>'PPR Pipe','unit'=>'pcs','buy'=>12000,'retail'=>17000,'wholesale'=>14500,'size'=>'25mm'],
            ['code'=>'PRD0020','name'=>'ក្បាប់ PPR Elbow 20mm','cat'=>'CAT0402','brand'=>'PPR Pipe','unit'=>'pcs','buy'=>1200,'retail'=>2000,'wholesale'=>1600,'size'=>'20mm'],
            // Electrical
            ['code'=>'PRD0021','name'=>'ខ្សែភ្លើង 1.5mm² (100m)','cat'=>'CAT0501','brand'=>'Bosch','unit'=>'roll','buy'=>45000,'retail'=>58000,'wholesale'=>51000,'size'=>'1.5mm²'],
            ['code'=>'PRD0022','name'=>'ខ្សែភ្លើង 2.5mm² (100m)','cat'=>'CAT0501','brand'=>'Bosch','unit'=>'roll','buy'=>68000,'retail'=>82000,'wholesale'=>74000,'size'=>'2.5mm²'],
            ['code'=>'PRD0023','name'=>'Switch តែមួយ',           'cat'=>'CAT0502','brand'=>'Bosch','unit'=>'pcs', 'buy'=>3500,'retail'=>5500,'wholesale'=>4500,'size'=>null],
            ['code'=>'PRD0024','name'=>'Switch ពីរ',              'cat'=>'CAT0502','brand'=>'Bosch','unit'=>'pcs', 'buy'=>5500,'retail'=>8000,'wholesale'=>6800,'size'=>null],
            ['code'=>'PRD0025','name'=>'សសរដែក H200 (12m)',     'cat'=>'CAT0203','brand'=>'Posco','unit'=>'pcs', 'buy'=>350000,'retail'=>420000,'wholesale'=>385000,'size'=>'H200'],
        ];

        $records = [];
        foreach ($products as $i => $p) {
            $records[] = [
                'company_id'          => $companyId,
                'category_id'         => $catMap[$p['cat']] ?? null,
                'brand_id'            => $brandMap[$p['brand']] ?? null,
                'unit_id'             => $unitMap[$p['unit']] ?? null,
                'product_code'        => $p['code'],
                'sku'                 => 'SKU-' . $p['code'],
                'barcode'             => '855' . str_pad($i + 1, 9, '0', STR_PAD_LEFT),
                'name'                => $p['name'],
                'size'                => $p['size'],
                'dimension'           => null,
                'weight'              => null,
                'color'               => null,
                'model'               => null,
                'purchase_price'      => $p['buy'],
                'retail_price'        => $p['retail'],
                'wholesale_price'     => $p['wholesale'],
                'project_price'       => null,
                'minimum_stock'       => 10,
                'track_stock'         => true,
                'allow_negative_stock'=> false,
                'image_path'          => null,
                'description'         => null,
                'is_active'           => true,
                'created_at'          => now(),
                'updated_at'          => now(),
            ];
        }

        DB::table('products')->insert($records);
    }
}
