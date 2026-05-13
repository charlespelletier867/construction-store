<?php

namespace App\Http\Controllers\Admin;

use App\Models\DocumentTemplate;

class DocumentTemplatesController extends BaseCrudController
{
    protected string $modelClass = DocumentTemplate::class;
    protected string $viewPrefix = 'admin.document_templates';
    protected string $routePrefix = 'admin.document_templates';

    public function __construct()
    {
        $this->singular = __('admin.menu.document_templates');
        $this->pluralLabel = __('admin.menu.document_templates');
    }

    protected function tableColumns(): array
    {
        return [
            ['data' => 'name', 'name' => 'name', 'title' => __('admin.field.name')],
            ['data' => 'template_type', 'name' => 'template_type', 'title' => 'Type'],
        ];
    }

    protected function formFields(): array
    {
        return [
            ['name' => 'name', 'type' => 'text', 'label' => __('admin.field.name'), 'required' => true, 'col' => 6, 'rules' => ['required', 'string']],
            ['name' => 'template_type', 'type' => 'text', 'label' => 'Type', 'required' => true, 'col' => 6, 'rules' => ['required', 'string']],
            ['name' => 'paper_size', 'type' => 'text', 'label' => 'Paper Size', 'col' => 4, 'default' => 'A4'],
            ['name' => 'header', 'type' => 'textarea', 'label' => 'Header', 'col' => 12],
            ['name' => 'footer', 'type' => 'textarea', 'label' => 'Footer', 'col' => 12],
            ['name' => 'is_default', 'type' => 'checkbox', 'label' => 'Default', 'col' => 4],
            ['name' => 'is_active', 'type' => 'checkbox', 'label' => __('admin.field.active'), 'col' => 4, 'default' => 1],
        ];
    }
}
