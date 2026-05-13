<?php

namespace App\Http\Controllers\Admin;

use App\Models\Vehicle;

class VehiclesController extends BaseCrudController
{
    protected string $modelClass = Vehicle::class;
    protected string $viewPrefix = 'admin.vehicles';
    protected string $routePrefix = 'admin.vehicles';

    public function __construct()
    {
        $this->singular = __('admin.menu.vehicles');
        $this->pluralLabel = __('admin.menu.vehicles');
    }

    protected function tableColumns(): array
    {
        return [
            ['data' => 'vehicle_code', 'name' => 'vehicle_code', 'title' => __('admin.field.code')],
            ['data' => 'plate_number', 'name' => 'plate_number', 'title' => 'Plate'],
            ['data' => 'vehicle_type', 'name' => 'vehicle_type', 'title' => 'Type'],
            ['data' => 'status', 'name' => 'status', 'title' => __('admin.field.status')],
        ];
    }

    protected function formFields(): array
    {
        return [
            ['name' => 'vehicle_code', 'type' => 'text', 'required' => true, 'col' => 4, 'rules' => ['required', 'string', 'max:255']],
            ['name' => 'plate_number', 'type' => 'text', 'label' => 'Plate Number', 'required' => true, 'col' => 4, 'rules' => ['required', 'string', 'max:255']],
            ['name' => 'driver_id', 'type' => 'select', 'label' => 'Assigned Driver', 'options' => \App\Models\Driver::query()->orderBy('name')->pluck('name', 'id')->toArray(), 'col' => 4],
            ['name' => 'vehicle_type', 'type' => 'text', 'label' => 'Type', 'col' => 4],
            ['name' => 'capacity', 'type' => 'text', 'label' => 'Capacity', 'col' => 4],
            ['name' => 'status', 'type' => 'select', 'options' => ['available' => 'Available', 'assigned' => 'Assigned', 'maintenance' => 'Maintenance', 'inactive' => 'Inactive'], 'col' => 4, 'default' => 'available'],
            ['name' => 'note', 'type' => 'textarea', 'col' => 12],
        ];
    }
}