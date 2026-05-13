<?php

namespace App\Http\Controllers\Admin;

use App\Models\SaleInvoice;

class SaleInvoicesController extends SchemaResourceController
{
    protected string $modelClass = SaleInvoice::class;
    protected string $viewPrefix = 'admin.sale_invoices';
    protected string $routePrefix = 'admin.sale_invoices';

    public function __construct()
    {
        $this->singular = __('admin.menu.sale_invoices');
        $this->pluralLabel = __('admin.menu.sale_invoices');
    }

    protected function tableColumns(): array
    {
        return [
            ['data' => 'sale_no', 'name' => 'sale_no', 'title' => '#'],
            ['data' => 'sale_date', 'name' => 'sale_date', 'title' => __('admin.field.date')],
            ['data' => 'grand_total', 'name' => 'grand_total', 'title' => __('admin.field.total')],
            ['data' => 'paid_amount', 'name' => 'paid_amount', 'title' => __('admin.field.paid')],
            ['data' => 'due_amount', 'name' => 'due_amount', 'title' => __('admin.field.due')],
            ['data' => 'payment_status', 'name' => 'payment_status', 'title' => __('admin.field.status')],
        ];
    }
}
