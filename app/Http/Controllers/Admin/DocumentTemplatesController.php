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
            ['data' => 'document_type', 'name' => 'document_type', 'title' => 'Type'],
        ];
    }

    protected function formFields(): array
    {
        return [
            ['name' => 'name', 'type' => 'text', 'label' => __('admin.field.name'), 'required' => true, 'col' => 6, 'rules' => ['required', 'string']],
            ['name' => 'document_type', 'type' => 'text', 'label' => 'Type', 'required' => true, 'col' => 6, 'rules' => ['required', 'string']],
            ['name' => 'content', 'type' => 'textarea', 'label' => 'Content (HTML)', 'col' => 12],
        ];
    }
}