<?php

namespace App\Http\Controllers\Admin;

use App\Models\Customer;

class CustomersController extends BaseCrudController
{
    protected string $modelClass = Customer::class;
    protected string $viewPrefix = 'admin.customers';
    protected string $routePrefix = 'admin.customers';

    public function __construct()
    {
        $this->singular = __('admin.menu.customers');
        $this->pluralLabel = __('admin.menu.customers');
    }

    protected function tableColumns(): array
    {
        return [
            ['data' => 'customer_code', 'name' => 'customer_code', 'title' => __('admin.field.code')],
            ['data' => 'name', 'name' => 'name', 'title' => __('admin.field.name')],
            ['data' => 'phone', 'name' => 'phone', 'title' => __('admin.field.phone')],
            ['data' => 'customer_type', 'name' => 'customer_type', 'title' => 'Type'],
            ['data' => 'current_balance', 'name' => 'current_balance', 'title' => 'Balance'],
            ['data' => 'is_active', 'name' => 'is_active', 'title' => __('admin.field.status'), 'render' => 'status_badge'],
        ];
    }

    protected function formFields(): array
    {
        return [
            ['name' => 'customer_code', 'type' => 'text', 'label' => __('admin.field.code'), 'required' => true, 'col' => 4, 'rules' => ['required', 'string', 'max:255']],
            ['name' => 'name', 'type' => 'text', 'label' => __('admin.field.name'), 'required' => true, 'col' => 8, 'rules' => ['required', 'string', 'max:255']],
            ['name' => 'phone', 'type' => 'tel', 'label' => __('admin.field.phone'), 'col' => 4],
            ['name' => 'email', 'type' => 'email', 'label' => __('admin.field.email'), 'col' => 4],
            ['name' => 'customer_type', 'type' => 'select', 'label' => 'Type', 'options' => ['walk_in' => 'Walk-in', 'regular' => 'Regular', 'wholesale' => 'Wholesale', 'contractor' => 'Contractor', 'company' => 'Company', 'project_owner' => 'Project Owner'], 'col' => 4, 'default' => 'walk_in'],
            ['name' => 'project_name', 'type' => 'text', 'label' => 'Project Name', 'col' => 6],
            ['name' => 'address', 'type' => 'textarea', 'label' => __('admin.field.address'), 'col' => 12],
            ['name' => 'opening_balance', 'type' => 'number', 'label' => 'Opening Balance', 'col' => 4, 'default' => 0],
            ['name' => 'credit_limit', 'type' => 'number', 'label' => 'Credit Limit', 'col' => 4, 'default' => 0],
            ['name' => 'credit_days', 'type' => 'number', 'label' => 'Credit Days', 'col' => 4, 'default' => 0],
            ['name' => 'is_walk_in', 'type' => 'checkbox', 'label' => 'Walk-in', 'col' => 6],
            ['name' => 'is_active', 'type' => 'checkbox', 'label' => __('admin.field.active'), 'col' => 6, 'default' => 1],
        ];
    }
}