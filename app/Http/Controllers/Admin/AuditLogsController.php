<?php

namespace App\Http\Controllers\Admin;

use App\Models\AuditLog;

class AuditLogsController extends BaseCrudController
{
    protected string $modelClass = AuditLog::class;
    protected string $viewPrefix = 'admin.audit_logs';
    protected string $routePrefix = 'admin.audit_logs';

    public function __construct()
    {
        $this->singular = __('admin.menu.audit_logs');
        $this->pluralLabel = __('admin.menu.audit_logs');
    }

    protected function tableColumns(): array
    {
        return [
            ['data' => 'created_at', 'name' => 'created_at', 'title' => __('admin.field.created_at')],
            ['data' => 'action', 'name' => 'action', 'title' => 'Action'],
            ['data' => 'auditable_type', 'name' => 'auditable_type', 'title' => 'Entity'],
            ['data' => 'auditable_id', 'name' => 'auditable_id', 'title' => 'Entity ID'],
        ];
    }

    protected function formFields(): array
    {
        return [
            ['name' => 'action', 'type' => 'text', 'label' => 'Action', 'col' => 6],
            ['name' => 'module', 'type' => 'text', 'label' => 'Module', 'col' => 6],
            ['name' => 'auditable_type', 'type' => 'text', 'label' => 'Entity', 'col' => 6],
            ['name' => 'auditable_id', 'type' => 'number', 'label' => 'Entity ID', 'col' => 6],
        ];
    }

}
