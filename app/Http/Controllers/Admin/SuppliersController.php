<?php

namespace App\Http\Controllers\Admin;

use App\Models\Supplier;

class SuppliersController extends BaseCrudController
{
    protected string $modelClass = Supplier::class;
    protected string $viewPrefix = 'admin.suppliers';
    protected string $routePrefix = 'admin.suppliers';

    public function __construct()
    {
        $this->singular = __('admin.menu.suppliers');
        $this->pluralLabel = __('admin.menu.suppliers');
    }

    protected function tableColumns(): array
    {
        return [
            ['data' => 'supplier_code', 'name' => 'supplier_code', 'title' => __('admin.field.code')],
            ['data' => 'name', 'name' => 'name', 'title' => __('admin.field.name')],
            ['data' => 'phone', 'name' => 'phone', 'title' => __('admin.field.phone')],
            ['data' => 'current_balance', 'name' => 'current_balance', 'title' => 'Balance'],
            ['data' => 'is_active', 'name' => 'is_active', 'title' => __('admin.field.status'), 'render' => 'status_badge'],
        ];
    }

    protected function formFields(): array
    {
        return [
            ['name' => 'supplier_code', 'type' => 'text', 'label' => __('admin.field.code'), 'required' => true, 'col' => 4, 'rules' => ['required', 'string', 'max:255']],
            ['name' => 'name', 'type' => 'text', 'label' => __('admin.field.name'), 'required' => true, 'col' => 8, 'rules' => ['required', 'string', 'max:255']],
            ['name' => 'phone', 'type' => 'tel', 'label' => __('admin.field.phone'), 'col' => 4],
            ['name' => 'email', 'type' => 'email', 'label' => __('admin.field.email'), 'col' => 4],
            ['name' => 'contact_person', 'type' => 'text', 'label' => 'Contact Person', 'col' => 4],
            ['name' => 'address', 'type' => 'textarea', 'label' => __('admin.field.address'), 'col' => 12],
            ['name' => 'opening_balance', 'type' => 'number', 'label' => 'Opening Balance', 'col' => 4, 'default' => 0],
            ['name' => 'credit_limit', 'type' => 'number', 'label' => 'Credit Limit', 'col' => 4, 'default' => 0],
            ['name' => 'credit_days', 'type' => 'number', 'label' => 'Credit Days', 'col' => 4, 'default' => 0],
            ['name' => 'is_active', 'type' => 'checkbox', 'label' => __('admin.field.active'), 'col' => 6, 'default' => 1],
        ];
    }
}