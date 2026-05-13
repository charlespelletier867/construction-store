<?php

namespace App\Http\Controllers\Admin;

use App\Models\StockTransfer;

class StockTransfersController extends BaseCrudController
{
    protected string $modelClass = StockTransfer::class;
    protected string $viewPrefix = 'admin.stock_transfers';
    protected string $routePrefix = 'admin.stock_transfers';

    public function __construct()
    {
        $this->singular = __('admin.menu.stock_transfers');
        $this->pluralLabel = __('admin.menu.stock_transfers');
    }

    protected function tableColumns(): array
    {
        return [
            ['data' => 'transfer_no', 'name' => 'transfer_no', 'title' => '#'],
            ['data' => 'transfer_date', 'name' => 'transfer_date', 'title' => __('admin.field.date')],
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