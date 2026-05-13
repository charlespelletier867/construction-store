<?php

namespace App\Http\Controllers\Admin;

use App\Models\Driver;

class DriversController extends BaseCrudController
{
    protected string $modelClass = Driver::class;
    protected string $viewPrefix = 'admin.drivers';
    protected string $routePrefix = 'admin.drivers';

    public function __construct()
    {
        $this->singular = __('admin.menu.drivers');
        $this->pluralLabel = __('admin.menu.drivers');
    }

    protected function tableColumns(): array
    {
        return [
            ['data' => 'driver_code', 'name' => 'driver_code', 'title' => __('admin.field.code')],
            ['data' => 'name', 'name' => 'name', 'title' => __('admin.field.name')],
            ['data' => 'phone', 'name' => 'phone', 'title' => __('admin.field.phone')],
            ['data' => 'is_active', 'name' => 'is_active', 'title' => __('admin.field.status'), 'render' => 'status_badge'],
        ];
    }

    protected function formFields(): array
    {
        return [
            ['name' => 'driver_code', 'type' => 'text', 'required' => true, 'col' => 4, 'rules' => ['required', 'string', 'max:255']],
            ['name' => 'name', 'type' => 'text', 'required' => true, 'col' => 8, 'rules' => ['required', 'string', 'max:255']],
            ['name' => 'phone', 'type' => 'tel', 'col' => 4],
            ['name' => 'license_no', 'type' => 'text', 'label' => 'License No', 'col' => 4],
            ['name' => 'address', 'type' => 'textarea', 'col' => 12],
            ['name' => 'is_active', 'type' => 'checkbox', 'label' => __('admin.field.active'), 'col' => 6, 'default' => 1],
        ];
    }
}
