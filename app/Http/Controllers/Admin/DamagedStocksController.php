<?php

namespace App\Http\Controllers\Admin;

use App\Models\DamagedStock;

class DamagedStocksController extends SchemaResourceController
{
    protected string $modelClass = DamagedStock::class;
    protected string $viewPrefix = 'admin.damaged_stocks';
    protected string $routePrefix = 'admin.damaged_stocks';

    public function __construct()
    {
        $this->singular = __('admin.menu.damaged_stocks');
        $this->pluralLabel = __('admin.menu.damaged_stocks');
    }

    protected function tableColumns(): array
    {
        return [
            ['data' => 'damage_no', 'name' => 'damage_no', 'title' => '#'],
            ['data' => 'damage_date', 'name' => 'damage_date', 'title' => __('admin.field.date')],
            ['data' => 'quantity', 'name' => 'quantity', 'title' => __('admin.field.quantity')],
        ];
    }
}
