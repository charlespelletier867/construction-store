<?php

namespace App\Http\Controllers\Admin;

use App\Models\Delivery;

class DeliveriesController extends BaseCrudController
{
    protected string $modelClass = Delivery::class;
    protected string $viewPrefix = 'admin.deliveries';
    protected string $routePrefix = 'admin.deliveries';

    public function __construct()
    {
        $this->singular = __('admin.menu.deliveries');
        $this->pluralLabel = __('admin.menu.deliveries');
    }

    protected function tableColumns(): array
    {
        return [
            ['data' => 'delivery_no', 'name' => 'delivery_no', 'title' => '#'],
            ['data' => 'delivery_date', 'name' => 'delivery_date', 'title' => __('admin.field.date')],
            ['data' => 'status', 'name' => 'status', 'title' => __('admin.field.status')],
        ];
    }

    protected function formFields(): array
    {
        // Transactional forms are managed through dedicated UIs; this is a fallback.
        return [
            ['name' => 'note', 'type' => 'textarea', 'label' => __('admin.field.note'), 'col' => 12],
        ];
    }

}