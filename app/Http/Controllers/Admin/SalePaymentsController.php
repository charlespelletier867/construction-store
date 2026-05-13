<?php

namespace App\Http\Controllers\Admin;

use App\Models\SalePayment;

class SalePaymentsController extends BaseCrudController
{
    protected string $modelClass = SalePayment::class;
    protected string $viewPrefix = 'admin.sale_payments';
    protected string $routePrefix = 'admin.sale_payments';

    public function __construct()
    {
        $this->singular = __('admin.menu.sale_payments');
        $this->pluralLabel = __('admin.menu.sale_payments');
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

    protected function formFields(): array
    {
        // Transactional forms are managed through dedicated UIs; this is a fallback.
        return [
            ['name' => 'note', 'type' => 'textarea', 'label' => __('admin.field.note'), 'col' => 12],
        ];
    }

}