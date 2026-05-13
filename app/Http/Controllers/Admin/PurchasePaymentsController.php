<?php

namespace App\Http\Controllers\Admin;

use App\Models\PurchasePayment;

class PurchasePaymentsController extends SchemaResourceController
{
    protected string $modelClass = PurchasePayment::class;
    protected string $viewPrefix = 'admin.purchase_payments';
    protected string $routePrefix = 'admin.purchase_payments';

    public function __construct()
    {
        $this->singular = __('admin.menu.purchase_payments');
        $this->pluralLabel = __('admin.menu.purchase_payments');
    }

    protected function tableColumns(): array
    {
        return [
            ['data' => 'payment_no', 'name' => 'payment_no', 'title' => '#'],
            ['data' => 'payment_date', 'name' => 'payment_date', 'title' => __('admin.field.date')],
            ['data' => 'amount', 'name' => 'amount', 'title' => __('admin.field.amount')],
            ['data' => 'payment_method', 'name' => 'payment_method', 'title' => 'Method'],
        ];
    }
}
