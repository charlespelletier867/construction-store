<?php

namespace App\Http\Controllers\Admin;

use App\Models\PurchaseReturnItem;

class PurchaseReturnItemsController extends SchemaResourceController
{
    protected string $modelClass = PurchaseReturnItem::class;
    protected string $viewPrefix = 'admin.purchase_return_items';
    protected string $routePrefix = 'admin.purchase_return_items';
    protected array $indexColumns = ['id', 'purchase_return_id', 'purchase_item_id', 'product_id', 'quantity', 'line_total'];

    public function __construct()
    {
        $this->singular = 'Purchase Return Item';
        $this->pluralLabel = 'Purchase Return Items';
    }
}
