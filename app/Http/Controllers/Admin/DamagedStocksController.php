<?php

namespace App\Http\Controllers\Admin;

use App\Models\DamagedStock;

class DamagedStocksController extends BaseCrudController
{
    protected string $modelClass = DamagedStock::class;
    protected string $viewPrefix = 'admin.damaged_stocks';
    protected string $routePrefix = 'admin.damaged_stocks';

    public function __construct()
    {
        $this->singular = __('admin.menu.damaged_stocks');
        $this->pluralLabel = __('admin.menu.damaged_stocks');
    }

    protected function tableColumns(): array
    {
        return [
            ['data' => 'damaged_no', 'name' => 'damaged_no', 'title' => '#'],
            ['data' => 'damaged_date', 'name' => 'damaged_date', 'title' => __('admin.field.date')],
            ['data' => 'quantity', 'name' => 'quantity', 'title' => __('admin.field.quantity')],
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