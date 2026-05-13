<?php

namespace App\Http\Controllers\Admin;

use App\Models\Branch;

class BranchesController extends BaseCrudController
{
    protected string $modelClass = Branch::class;
    protected string $viewPrefix = 'admin.branches';
    protected string $routePrefix = 'admin.branches';

    public function __construct()
    {
        $this->singular = __('admin.menu.branch');
        $this->pluralLabel = __('admin.menu.branches');
    }

    protected function tableColumns(): array
    {
        return [
            ['data' => 'branch_code', 'name' => 'branch_code', 'title' => __('admin.field.code')],
            ['data' => 'name', 'name' => 'name', 'title' => __('admin.field.name')],
            ['data' => 'phone', 'name' => 'phone', 'title' => __('admin.field.phone')],
            ['data' => 'is_active', 'name' => 'is_active', 'title' => __('admin.field.status'), 'render' => 'status_badge'],
        ];
    }

    protected function formFields(): array
    {
        return [
            ['name' => 'branch_code', 'type' => 'text', 'required' => true, 'col' => 6, 'rules' => ['required', 'string', 'max:255']],
            ['name' => 'name', 'type' => 'text', 'required' => true, 'col' => 6, 'rules' => ['required', 'string', 'max:255']],
            ['name' => 'phone', 'type' => 'tel', 'col' => 6],
            ['name' => 'email', 'type' => 'email', 'col' => 6],
            ['name' => 'address', 'type' => 'textarea', 'col' => 12],
            ['name' => 'is_main_branch', 'type' => 'checkbox', 'label' => 'Is Main Branch', 'col' => 6],
            ['name' => 'is_active', 'type' => 'checkbox', 'label' => __('admin.field.active'), 'col' => 6, 'default' => 1],
        ];
    }
}