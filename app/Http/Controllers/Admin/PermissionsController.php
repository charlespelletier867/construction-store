<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;

class PermissionsController extends BaseCrudController
{
    protected string $modelClass = Permission::class;
    protected string $viewPrefix = 'admin.permissions';
    protected string $routePrefix = 'admin.permissions';

    public function __construct()
    {
        $this->singular = __('admin.menu.permissions');
        $this->pluralLabel = __('admin.menu.permissions');
    }

    protected function tableColumns(): array
    {
        return [
            ['data' => 'module', 'name' => 'module', 'title' => 'Module'],
            ['data' => 'action', 'name' => 'action', 'title' => __('admin.action.actions')],
            ['data' => 'name', 'name' => 'name', 'title' => __('admin.field.name')],
            ['data' => 'slug', 'name' => 'slug', 'title' => 'Slug'],
        ];
    }

    protected function formFields(): array
    {
        return [
            ['name' => 'module', 'type' => 'text', 'label' => 'Module', 'required' => true, 'col' => 4, 'rules' => ['required', 'string']],
            ['name' => 'action', 'type' => 'text', 'label' => 'Action', 'required' => true, 'col' => 4, 'rules' => ['required', 'string']],
            ['name' => 'name', 'type' => 'text', 'label' => __('admin.field.name'), 'required' => true, 'col' => 4, 'rules' => ['required', 'string']],
            ['name' => 'slug', 'type' => 'text', 'label' => 'Slug', 'required' => true, 'col' => 6, 'rules' => ['required', 'string', 'max:255']],
            ['name' => 'description', 'type' => 'textarea', 'col' => 12],
        ];
    }
}