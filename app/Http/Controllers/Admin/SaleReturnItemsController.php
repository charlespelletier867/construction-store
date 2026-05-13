<?php

namespace App\Http\Controllers\Admin;

use App\Models\SaleReturnItem;

class SaleReturnItemsController extends SchemaResourceController
{
    protected string $modelClass = SaleReturnItem::class;
    protected string $viewPrefix = 'admin.sale_return_items';
    protected string $routePrefix = 'admin.sale_return_items';
    protected array $indexColumns = ['id', 'sale_return_id', 'sale_item_id', 'product_id', 'quantity', 'line_total'];

    public function __construct()
    {
        $this->singular = 'Sale Return Item';
        $this->pluralLabel = 'Sale Return Items';
    }
}
