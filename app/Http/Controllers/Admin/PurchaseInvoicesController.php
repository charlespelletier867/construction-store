<?php

namespace App\Http\Controllers\Admin;

use App\Models\PurchaseInvoice;

class PurchaseInvoicesController extends SchemaResourceController
{
    protected string $modelClass = PurchaseInvoice::class;
    protected string $viewPrefix = 'admin.purchase_invoices';
    protected string $routePrefix = 'admin.purchase_invoices';

    public function __construct()
    {
        $this->singular = __('admin.menu.purchase_invoices');
        $this->pluralLabel = __('admin.menu.purchase_invoices');
    }

    protected function tableColumns(): array
    {
        return [
            ['data' => 'purchase_no', 'name' => 'purchase_no', 'title' => '#'],
            ['data' => 'purchase_date', 'name' => 'purchase_date', 'title' => __('admin.field.date')],
            ['data' => 'grand_total', 'name' => 'grand_total', 'title' => __('admin.field.total')],
            ['data' => 'paid_amount', 'name' => 'paid_amount', 'title' => __('admin.field.paid')],
            ['data' => 'due_amount', 'name' => 'due_amount', 'title' => __('admin.field.due')],
            ['data' => 'payment_status', 'name' => 'payment_status', 'title' => __('admin.field.status')],
        ];
    }
}
