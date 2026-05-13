<?php

namespace App\Http\Controllers\Admin;

use App\Models\StockAdjustmentItem;

class StockAdjustmentItemsController extends SchemaResourceController
{
    protected string $modelClass = StockAdjustmentItem::class;
    protected string $viewPrefix = 'admin.stock_adjustment_items';
    protected string $routePrefix = 'admin.stock_adjustment_items';
    protected array $indexColumns = ['id', 'stock_adjustment_id', 'product_id', 'system_quantity', 'actual_quantity', 'difference_quantity'];

    public function __construct()
    {
        $this->singular = 'Stock Adjustment Item';
        $this->pluralLabel = 'Stock Adjustment Items';
    }
}
