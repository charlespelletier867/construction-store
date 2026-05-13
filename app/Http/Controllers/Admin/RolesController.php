<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;

class RolesController extends BaseCrudController
{
    protected string $modelClass = Role::class;
    protected string $viewPrefix = 'admin.roles';
    protected string $routePrefix = 'admin.roles';

    public function __construct()
    {
        $this->singular = __('admin.menu.roles');
        $this->pluralLabel = __('admin.menu.roles');
    }

    protected function tableColumns(): array
    {
        return [
            ['data' => 'name', 'name' => 'name', 'title' => __('admin.field.name')],
            ['data' => 'slug', 'name' => 'slug', 'title' => __('admin.field.code')],
            ['data' => 'is_active', 'name' => 'is_active', 'title' => __('admin.field.status'), 'render' => 'status_badge'],
        ];
    }

    protected function formFields(): array
    {
        return [
            ['name' => 'name', 'type' => 'text', 'label' => __('admin.field.name'), 'required' => true, 'col' => 6, 'rules' => ['required', 'string', 'max:255']],
            ['name' => 'slug', 'type' => 'text', 'label' => 'Slug', 'required' => true, 'col' => 6, 'rules' => ['required', 'string', 'max:255']],
            ['name' => 'description', 'type' => 'textarea', 'col' => 12],
            ['name' => 'is_active', 'type' => 'checkbox', 'label' => __('admin.field.active'), 'col' => 6, 'default' => 1],
        ];
    }
}