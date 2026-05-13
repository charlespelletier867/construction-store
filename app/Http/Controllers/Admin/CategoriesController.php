<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;

class CategoriesController extends BaseCrudController
{
    protected string $modelClass = Category::class;
    protected string $viewPrefix = 'admin.categories';
    protected string $routePrefix = 'admin.categories';

    public function __construct()
    {
        $this->singular = __('admin.menu.categories');
        $this->pluralLabel = __('admin.menu.categories');
    }

    protected function tableColumns(): array
    {
        return [
            ['data' => 'name', 'name' => 'name', 'title' => __('admin.field.name')],
            ['data' => 'code', 'name' => 'code', 'title' => __('admin.field.code')],
            ['data' => 'is_active', 'name' => 'is_active', 'title' => __('admin.field.status'), 'render' => 'status_badge'],
        ];
    }

    protected function formFields(): array
    {
        return [
            ['name' => 'parent_id', 'type' => 'select', 'label' => 'Parent Category', 'options' => \App\Models\Category::query()->orderBy('name')->pluck('name', 'id')->toArray(), 'col' => 6],
            ['name' => 'code', 'type' => 'text', 'label' => __('admin.field.code'), 'col' => 3],
            ['name' => 'name', 'type' => 'text', 'label' => __('admin.field.name'), 'required' => true, 'col' => 3, 'rules' => ['required', 'string', 'max:255']],
            ['name' => 'description', 'type' => 'textarea', 'label' => __('admin.field.description'), 'col' => 12],
            ['name' => 'is_active', 'type' => 'checkbox', 'label' => __('admin.field.active'), 'col' => 6, 'default' => 1],
        ];
    }
}