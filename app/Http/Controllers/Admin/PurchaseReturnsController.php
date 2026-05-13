<?php

namespace App\Http\Controllers\Admin;

use App\Models\PurchaseReturn;

class PurchaseReturnsController extends BaseCrudController
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
            ['data' => 'grand_total', 'name' => 'grand_total', 'title' => __('admin.field.total')],
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