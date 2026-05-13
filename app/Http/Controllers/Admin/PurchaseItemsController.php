<?php

namespace App\Http\Controllers\Admin;

use App\Models\PurchaseItem;

class PurchaseItemsController extends SchemaResourceController
{
    protected string $modelClass = PurchaseItem::class;
    protected string $viewPrefix = 'admin.purchase_items';
    protected string $routePrefix = 'admin.purchase_items';
    protected array $indexColumns = ['id', 'purchase_invoice_id', 'product_id', 'quantity', 'unit_cost', 'line_total'];

    public function __construct()
    {
        $this->singular = 'Purchase Item';
        $this->pluralLabel = 'Purchase Items';
    }
}
