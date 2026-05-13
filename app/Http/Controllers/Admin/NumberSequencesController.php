<?php

namespace App\Http\Controllers\Admin;

use App\Models\NumberSequence;

class NumberSequencesController extends BaseCrudController
{
    protected string $modelClass = NumberSequence::class;
    protected string $viewPrefix = 'admin.number_sequences';
    protected string $routePrefix = 'admin.number_sequences';

    public function __construct()
    {
        $this->singular = __('admin.menu.number_sequences');
        $this->pluralLabel = __('admin.menu.number_sequences');
    }

    protected function tableColumns(): array
    {
        return [
            ['data' => 'document_type', 'name' => 'document_type', 'title' => 'Document Type'],
            ['data' => 'prefix', 'name' => 'prefix', 'title' => 'Prefix'],
            ['data' => 'next_number', 'name' => 'next_number', 'title' => 'Next #'],
        ];
    }

    protected function formFields(): array
    {
        return [
            ['name' => 'document_type', 'type' => 'text', 'label' => 'Document Type', 'required' => true, 'col' => 4, 'rules' => ['required', 'string']],
            ['name' => 'prefix', 'type' => 'text', 'label' => 'Prefix', 'col' => 4],
            ['name' => 'date_format', 'type' => 'text', 'label' => 'Date Format', 'col' => 4],
            ['name' => 'padding', 'type' => 'number', 'label' => 'Padding', 'col' => 4, 'default' => 4],
            ['name' => 'next_number', 'type' => 'number', 'label' => 'Next Number', 'col' => 4, 'default' => 1],
            ['name' => 'suffix', 'type' => 'text', 'label' => 'Suffix', 'col' => 4],
        ];
    }
}
