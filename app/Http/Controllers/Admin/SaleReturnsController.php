<?php

namespace App\Http\Controllers\Admin;

use App\Models\SaleReturn;

class SaleReturnsController extends BaseCrudController
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
            ['data' => 'grand_total', 'name' => 'grand_total', 'title' => __('admin.field.total')],
            ['data' => 'status', 'name' => 'status', 'title' => __('admin.field.status')],
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