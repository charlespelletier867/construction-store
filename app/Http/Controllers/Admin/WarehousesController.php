<?php

namespace App\Http\Controllers\Admin;

use App\Models\Warehouse;

class WarehousesController extends BaseCrudController
{
    protected string $modelClass = Warehouse::class;
    protected string $viewPrefix = 'admin.warehouses';
    protected string $routePrefix = 'admin.warehouses';

    public function __construct()
    {
        $this->singular = __('admin.menu.warehouses');
        $this->pluralLabel = __('admin.menu.warehouses');
    }

    protected function tableColumns(): array
    {
        return [
            ['data' => 'warehouse_code', 'name' => 'warehouse_code', 'title' => __('admin.field.code')],
            ['data' => 'name', 'name' => 'name', 'title' => __('admin.field.name')],
            ['data' => 'is_active', 'name' => 'is_active', 'title' => __('admin.field.status'), 'render' => 'status_badge'],
        ];
    }

    protected function formFields(): array
    {
        return [
            ['name' => 'branch_id', 'type' => 'select', 'label' => __('admin.field.branch'), 'required' => true, 'col' => 6, 'options' => \App\Models\Branch::query()->orderBy('name')->pluck('name', 'id')->toArray(), 'rules' => ['required', 'integer', 'exists:branches,id']],
            ['name' => 'warehouse_code', 'type' => 'text', 'required' => true, 'col' => 3, 'rules' => ['required', 'string', 'max:255']],
            ['name' => 'name', 'type' => 'text', 'required' => true, 'col' => 3, 'rules' => ['required', 'string', 'max:255']],
            ['name' => 'address', 'type' => 'textarea', 'col' => 12],
            ['name' => 'is_default', 'type' => 'checkbox', 'col' => 6],
            ['name' => 'is_active', 'type' => 'checkbox', 'label' => __('admin.field.active'), 'col' => 6, 'default' => 1],
        ];
    }
}