<?php

namespace App\Http\Controllers\Admin;

use App\Models\StockAdjustment;

class StockAdjustmentsController extends BaseCrudController
{
    protected string $modelClass = StockAdjustment::class;
    protected string $viewPrefix = 'admin.stock_adjustments';
    protected string $routePrefix = 'admin.stock_adjustments';

    public function __construct()
    {
        $this->singular = __('admin.menu.stock_adjustments');
        $this->pluralLabel = __('admin.menu.stock_adjustments');
    }

    protected function tableColumns(): array
    {
        return [
            ['data' => 'adjustment_no', 'name' => 'adjustment_no', 'title' => '#'],
            ['data' => 'adjustment_date', 'name' => 'adjustment_date', 'title' => __('admin.field.date')],
            ['data' => 'reason', 'name' => 'reason', 'title' => 'Reason'],
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