<?php

namespace App\Http\Controllers\Admin;

use App\Models\Quotation;

class QuotationsController extends BaseCrudController
{
    protected string $modelClass = Quotation::class;
    protected string $viewPrefix = 'admin.quotations';
    protected string $routePrefix = 'admin.quotations';

    public function __construct()
    {
        $this->singular = __('admin.menu.quotations');
        $this->pluralLabel = __('admin.menu.quotations');
    }

    protected function tableColumns(): array
    {
        return [
            ['data' => 'quotation_no', 'name' => 'quotation_no', 'title' => '#'],
            ['data' => 'quotation_date', 'name' => 'quotation_date', 'title' => __('admin.field.date')],
            ['data' => 'grand_total', 'name' => 'grand_total', 'title' => __('admin.field.total')],
            ['data' => 'status', 'name' => 'status', 'title' => __('admin.field.status')],
        ];
    }

    protected function formFields(): array
    {
        // Transactional forms are managed through dedicated UIs; this is a fallback.
        return [
            ['name' => 'note', 'type' => 'textarea', 'label' => __('admin.field.note'), 'col' => 12],
        ];
    }

}