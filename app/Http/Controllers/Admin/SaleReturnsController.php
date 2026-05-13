<?php

namespace App\Http\Controllers\Admin;

use App\Models\SaleReturn;

class SaleReturnsController extends SchemaResourceController
{
    protected string $modelClass = SaleReturn::class;
    protected string $viewPrefix = 'admin.sale_returns';
    protected string $routePrefix = 'admin.sale_returns';

    public function __construct()
    {
        $this->singular = __('admin.menu.sale_returns');
        $this->pluralLabel = __('admin.menu.sale_returns');
    }

    protected function tableColumns(): array
    {
        return [
            ['data' => 'return_no', 'name' => 'return_no', 'title' => '#'],
            ['data' => 'return_date', 'name' => 'return_date', 'title' => __('admin.field.date')],
            ['data' => 'refund_amount', 'name' => 'refund_amount', 'title' => __('admin.field.total')],
            ['data' => 'status', 'name' => 'status', 'title' => __('admin.field.status')],
        ];
    }
}
