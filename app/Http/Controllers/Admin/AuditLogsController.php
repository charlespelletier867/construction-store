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
        // Transactional forms are managed through dedicated UIs; this is a fallback.
        return [
            ['name' => 'note', 'type' => 'textarea', 'label' => __('admin.field.note'), 'col' => 12],
        ];
    }

}