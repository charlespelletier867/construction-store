<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;

class BrandsController extends BaseCrudController
{
    protected string $modelClass = Brand::class;
    protected string $viewPrefix = 'admin.brands';
    protected string $routePrefix = 'admin.brands';

    public function __construct()
    {
        $this->singular = __('admin.menu.brands');
        $this->pluralLabel = __('admin.menu.brands');
    }

    protected function tableColumns(): array
    {
        return [
            ['data' => 'name', 'name' => 'name', 'title' => __('admin.field.name')],
            ['data' => 'country', 'name' => 'country', 'title' => 'Country'],
            ['data' => 'contact_phone', 'name' => 'contact_phone', 'title' => __('admin.field.phone')],
            ['data' => 'is_active', 'name' => 'is_active', 'title' => __('admin.field.status'), 'render' => 'status_badge'],
        ];
    }

    protected function formFields(): array
    {
        return [
            ['name' => 'name', 'type' => 'text', 'required' => true, 'col' => 6, 'rules' => ['required', 'string', 'max:255']],
            ['name' => 'country', 'type' => 'text', 'col' => 6],
            ['name' => 'contact_phone', 'type' => 'tel', 'col' => 6],
            ['name' => 'contact_email', 'type' => 'email', 'col' => 6],
            ['name' => 'note', 'type' => 'textarea', 'col' => 12],
            ['name' => 'is_active', 'type' => 'checkbox', 'label' => __('admin.field.active'), 'col' => 6, 'default' => 1],
        ];
    }
}