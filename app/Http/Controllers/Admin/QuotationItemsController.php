<?php

namespace App\Http\Controllers\Admin;

use App\Models\QuotationItem;

class QuotationItemsController extends SchemaResourceController
{
    protected string $modelClass = QuotationItem::class;
    protected string $viewPrefix = 'admin.quotation_items';
    protected string $routePrefix = 'admin.quotation_items';
    protected array $indexColumns = ['id', 'quotation_id', 'product_id', 'quantity', 'unit_price', 'line_total'];

    public function __construct()
    {
        $this->singular = 'Quotation Item';
        $this->pluralLabel = 'Quotation Items';
    }
}
