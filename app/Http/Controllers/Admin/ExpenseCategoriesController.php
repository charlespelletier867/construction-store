<?php

namespace App\Http\Controllers\Admin;

use App\Models\ExpenseCategory;

class ExpenseCategoriesController extends BaseCrudController
{
    protected string $modelClass = ExpenseCategory::class;
    protected string $viewPrefix = 'admin.expense_categories';
    protected string $routePrefix = 'admin.expense_categories';

    public function __construct()
    {
        $this->singular = __('admin.menu.expense_categories');
        $this->pluralLabel = __('admin.menu.expense_categories');
    }

    protected function tableColumns(): array
    {
        return [
            ['data' => 'name', 'name' => 'name', 'title' => __('admin.field.name')],
            ['data' => 'is_active', 'name' => 'is_active', 'title' => __('admin.field.status'), 'render' => 'status_badge'],
        ];
    }

    protected function formFields(): array
    {
        return [
            ['name' => 'name', 'type' => 'text', 'required' => true, 'col' => 6, 'rules' => ['required', 'string', 'max:255']],
            ['name' => 'description', 'type' => 'textarea', 'col' => 12],
            ['name' => 'is_active', 'type' => 'checkbox', 'label' => __('admin.field.active'), 'col' => 6, 'default' => 1],
        ];
    }
}