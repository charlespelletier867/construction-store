<?php

namespace App\Http\Controllers\Admin;

use App\Models\Unit;

class UnitsController extends BaseCrudController
{
    protected string $modelClass = Unit::class;
    protected string $viewPrefix = 'admin.units';
    protected string $routePrefix = 'admin.units';

    public function __construct()
    {
        $this->singular = __('admin.menu.units');
        $this->pluralLabel = __('admin.menu.units');
    }

    protected function tableColumns(): array
    {
        return [
            ['data' => 'name', 'name' => 'name', 'title' => __('admin.field.name')],
            ['data' => 'short_name', 'name' => 'short_name', 'title' => 'Short Name'],
            ['data' => 'base_quantity', 'name' => 'base_quantity', 'title' => 'Base Qty'],
            ['data' => 'is_active', 'name' => 'is_active', 'title' => __('admin.field.status'), 'render' => 'status_badge'],
        ];
    }

    protected function formFields(): array
    {
        return [
            ['name' => 'name', 'type' => 'text', 'required' => true, 'col' => 6, 'rules' => ['required', 'string', 'max:255']],
            ['name' => 'short_name', 'type' => 'text', 'label' => 'Short Name', 'required' => true, 'col' => 3, 'rules' => ['required', 'string', 'max:20']],
            ['name' => 'base_quantity', 'type' => 'number', 'label' => 'Base Quantity', 'col' => 3, 'default' => 1],
            ['name' => 'description', 'type' => 'textarea', 'col' => 12],
            ['name' => 'is_active', 'type' => 'checkbox', 'label' => __('admin.field.active'), 'col' => 6, 'default' => 1],
        ];
    }
}