<?php

namespace App\Http\Controllers\Admin;

use App\Models\PurchaseReturn;

class PurchaseReturnsController extends SchemaResourceController
{
    protected string $modelClass = PurchaseReturn::class;
    protected string $viewPrefix = 'admin.purchase_returns';
    protected string $routePrefix = 'admin.purchase_returns';

    public function __construct()
    {
        $this->singular = __('admin.menu.purchase_returns');
        $this->pluralLabel = __('admin.menu.purchase_returns');
    }

    protected function tableColumns(): array
    {
        return [
            ['data' => 'return_no', 'name' => 'return_no', 'title' => '#'],
            ['data' => 'return_date', 'name' => 'return_date', 'title' => __('admin.field.date')],
            ['data' => 'return_amount', 'name' => 'return_amount', 'title' => __('admin.field.total')],
        ];
    }
}
