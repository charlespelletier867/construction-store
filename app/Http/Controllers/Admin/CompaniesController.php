<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;

class CompaniesController extends BaseCrudController
{
    protected string $modelClass = Company::class;
    protected string $viewPrefix = 'admin.companies';
    protected string $routePrefix = 'admin.companies';

    public function __construct()
    {
        $this->singular = __('admin.menu.companies');
        $this->pluralLabel = __('admin.menu.companies');
    }

    protected function tableColumns(): array
    {
        return [
            ['data' => 'company_code', 'name' => 'company_code', 'title' => __('admin.field.code')],
            ['data' => 'name', 'name' => 'name', 'title' => __('admin.field.name')],
            ['data' => 'phone', 'name' => 'phone', 'title' => __('admin.field.phone')],
            ['data' => 'email', 'name' => 'email', 'title' => __('admin.field.email')],
            ['data' => 'is_active', 'name' => 'is_active', 'title' => __('admin.field.status'), 'render' => 'status_badge'],
        ];
    }

    protected function formFields(): array
    {
        return [
            ['name' => 'company_code', 'type' => 'text', 'label' => __('admin.field.code'), 'required' => true, 'col' => 6, 'rules' => ['required', 'string', 'max:255']],
            ['name' => 'name', 'type' => 'text', 'label' => __('admin.field.name'), 'required' => true, 'col' => 6, 'rules' => ['required', 'string', 'max:255']],
            ['name' => 'owner_name', 'type' => 'text', 'label' => 'Owner', 'col' => 6],
            ['name' => 'phone', 'type' => 'tel', 'label' => __('admin.field.phone'), 'col' => 6],
            ['name' => 'email', 'type' => 'email', 'label' => __('admin.field.email'), 'col' => 6],
            ['name' => 'website', 'type' => 'url', 'label' => 'Website', 'col' => 6],
            ['name' => 'tax_number', 'type' => 'text', 'label' => 'Tax Number', 'col' => 6],
            ['name' => 'currency_code', 'type' => 'text', 'label' => 'Currency Code', 'col' => 6, 'default' => 'KHR'],
            ['name' => 'language', 'type' => 'select', 'label' => 'Default Language', 'options' => ['en' => 'English', 'km' => 'ខ្មែរ'], 'col' => 6, 'default' => 'km'],
            ['name' => 'address', 'type' => 'textarea', 'label' => __('admin.field.address'), 'col' => 12],
            ['name' => 'is_active', 'type' => 'checkbox', 'label' => __('admin.field.active'), 'col' => 6, 'default' => 1],
        ];
    }
}