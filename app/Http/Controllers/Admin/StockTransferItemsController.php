<?php

namespace App\Http\Controllers\Admin;

use App\Models\StockTransferItem;

class StockTransferItemsController extends SchemaResourceController
{
    protected string $modelClass = StockTransferItem::class;
    protected string $viewPrefix = 'admin.stock_transfer_items';
    protected string $routePrefix = 'admin.stock_transfer_items';
    protected array $indexColumns = ['id', 'stock_transfer_id', 'product_id', 'requested_quantity', 'sent_quantity', 'received_quantity'];

    public function __construct()
    {
        $this->singular = 'Stock Transfer Item';
        $this->pluralLabel = 'Stock Transfer Items';
    }
}
