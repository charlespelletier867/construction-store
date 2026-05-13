<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;

class ProductsController extends BaseCrudController
{
    protected string $modelClass = Product::class;
    protected string $viewPrefix = 'admin.products';
    protected string $routePrefix = 'admin.products';

    public function __construct()
    {
        $this->singular = __('admin.menu.products');
        $this->pluralLabel = __('admin.menu.products');
    }

    protected function tableColumns(): array
    {
        return [
            ['data' => 'product_code', 'name' => 'product_code', 'title' => __('admin.field.code')],
            ['data' => 'name', 'name' => 'name', 'title' => __('admin.field.name')],
            ['data' => 'retail_price', 'name' => 'retail_price', 'title' => 'Retail'],
            ['data' => 'purchase_price', 'name' => 'purchase_price', 'title' => 'Purchase'],
            ['data' => 'is_active', 'name' => 'is_active', 'title' => __('admin.field.status'), 'render' => 'status_badge'],
        ];
    }

    protected function formFields(): array
    {
        return [
            ['name' => 'product_code', 'type' => 'text', 'label' => __('admin.field.code'), 'required' => true, 'col' => 4, 'rules' => ['required', 'string', 'max:255']],
            ['name' => 'sku', 'type' => 'text', 'label' => 'SKU', 'col' => 4],
            ['name' => 'barcode', 'type' => 'text', 'label' => 'Barcode', 'col' => 4],
            ['name' => 'name', 'type' => 'text', 'label' => __('admin.field.name'), 'required' => true, 'col' => 12, 'rules' => ['required', 'string', 'max:255']],
            ['name' => 'category_id', 'type' => 'select', 'label' => __('admin.field.category'), 'options' => \App\Models\Category::query()->orderBy('name')->pluck('name', 'id')->toArray(), 'col' => 4],
            ['name' => 'brand_id', 'type' => 'select', 'label' => __('admin.field.brand'), 'options' => \App\Models\Brand::query()->orderBy('name')->pluck('name', 'id')->toArray(), 'col' => 4],
            ['name' => 'unit_id', 'type' => 'select', 'label' => __('admin.field.unit'), 'options' => \App\Models\Unit::query()->orderBy('name')->pluck('name', 'id')->toArray(), 'col' => 4],
            ['name' => 'purchase_price', 'type' => 'number', 'label' => 'Purchase Price', 'col' => 3, 'default' => 0],
            ['name' => 'retail_price', 'type' => 'number', 'label' => 'Retail Price', 'col' => 3, 'default' => 0],
            ['name' => 'wholesale_price', 'type' => 'number', 'label' => 'Wholesale Price', 'col' => 3, 'default' => 0],
            ['name' => 'project_price', 'type' => 'number', 'label' => 'Project Price', 'col' => 3],
            ['name' => 'minimum_stock', 'type' => 'number', 'label' => 'Min Stock', 'col' => 4, 'default' => 0],
            ['name' => 'size', 'type' => 'text', 'label' => 'Size', 'col' => 4],
            ['name' => 'dimension', 'type' => 'text', 'label' => 'Dimension', 'col' => 4],
            ['name' => 'weight', 'type' => 'number', 'label' => 'Weight', 'col' => 4],
            ['name' => 'color', 'type' => 'text', 'label' => 'Color', 'col' => 4],
            ['name' => 'model', 'type' => 'text', 'label' => 'Model', 'col' => 4],
            ['name' => 'description', 'type' => 'textarea', 'label' => __('admin.field.description'), 'col' => 12],
            ['name' => 'track_stock', 'type' => 'checkbox', 'label' => 'Track Stock', 'col' => 4, 'default' => 1],
            ['name' => 'allow_negative_stock', 'type' => 'checkbox', 'label' => 'Allow Negative Stock', 'col' => 4],
            ['name' => 'is_active', 'type' => 'checkbox', 'label' => __('admin.field.active'), 'col' => 4, 'default' => 1],
        ];
    }
}