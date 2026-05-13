<?php

namespace App\Http\Controllers\Admin;

use App\Models\StockBalance;

class StockBalancesController extends SchemaResourceController
{
    protected string $modelClass = StockBalance::class;
    protected string $viewPrefix = 'admin.stock_balances';
    protected string $routePrefix = 'admin.stock_balances';
    protected array $indexColumns = ['id', 'branch_id', 'warehouse_id', 'product_id', 'quantity', 'available_quantity'];

    public function __construct()
    {
        $this->singular = 'Stock Balance';
        $this->pluralLabel = 'Stock Balances';
    }
}
