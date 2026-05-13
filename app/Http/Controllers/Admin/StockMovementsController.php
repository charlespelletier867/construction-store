<?php

namespace App\Http\Controllers\Admin;

use App\Models\StockMovement;

class StockMovementsController extends SchemaResourceController
{
    protected string $modelClass = StockMovement::class;
    protected string $viewPrefix = 'admin.stock_movements';
    protected string $routePrefix = 'admin.stock_movements';
    protected array $indexColumns = ['id', 'movement_no', 'movement_type', 'warehouse_id', 'product_id', 'balance_after'];

    public function __construct()
    {
        $this->singular = 'Stock Movement';
        $this->pluralLabel = 'Stock Movements';
    }
}
