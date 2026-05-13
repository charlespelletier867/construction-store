<?php

namespace App\Http\Controllers\Admin;

use App\Models\VehicleExpense;

class VehicleExpensesController extends BaseCrudController
{
    protected string $modelClass = VehicleExpense::class;
    protected string $viewPrefix = 'admin.vehicle_expenses';
    protected string $routePrefix = 'admin.vehicle_expenses';

    public function __construct()
    {
        $this->singular = __('admin.menu.vehicle_expenses');
        $this->pluralLabel = __('admin.menu.vehicle_expenses');
    }

    protected function tableColumns(): array
    {
        return [
            ['data' => 'expense_date', 'name' => 'expense_date', 'title' => __('admin.field.date')],
            ['data' => 'expense_type', 'name' => 'expense_type', 'title' => 'Type'],
            ['data' => 'amount', 'name' => 'amount', 'title' => __('admin.field.amount')],
        ];
    }

    protected function formFields(): array
    {
        return [
            ['name' => 'vehicle_id', 'type' => 'select', 'label' => 'Vehicle', 'options' => \App\Models\Vehicle::query()->orderBy('name')->pluck('name', 'id')->toArray(), 'required' => true, 'col' => 6, 'rules' => ['required', 'integer', 'exists:vehicles,id']],
            ['name' => 'expense_type', 'type' => 'select', 'label' => 'Type', 'options' => ['fuel' => 'Fuel', 'repair' => 'Repair', 'maintenance' => 'Maintenance', 'other' => 'Other'], 'required' => true, 'col' => 6, 'rules' => ['required', 'string']],
            ['name' => 'expense_date', 'type' => 'date', 'label' => __('admin.field.date'), 'required' => true, 'col' => 6, 'rules' => ['required', 'date']],
            ['name' => 'amount', 'type' => 'number', 'label' => __('admin.field.amount'), 'required' => true, 'col' => 6, 'rules' => ['required', 'numeric', 'min:0']],
            ['name' => 'note', 'type' => 'textarea', 'col' => 12],
        ];
    }
}