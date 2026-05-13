<?php

namespace App\Http\Controllers\Admin;

use App\Models\SaleItem;

class SaleItemsController extends SchemaResourceController
{
    protected string $modelClass = SaleItem::class;
    protected string $viewPrefix = 'admin.sale_items';
    protected string $routePrefix = 'admin.sale_items';
    protected array $indexColumns = ['id', 'sale_invoice_id', 'product_id', 'quantity', 'unit_price', 'line_total'];

    public function __construct()
    {
        $this->singular = 'Sale Item';
        $this->pluralLabel = 'Sale Items';
    }
}
