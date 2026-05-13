<?php

namespace App\Http\Controllers\Admin;

use App\Models\RolePermission;

class RolePermissionsController extends SchemaResourceController
{
    protected string $modelClass = RolePermission::class;
    protected string $viewPrefix = 'admin.role_permissions';
    protected string $routePrefix = 'admin.role_permissions';
    protected array $indexColumns = ['id', 'role_id', 'permission_id'];

    public function __construct()
    {
        $this->singular = 'Role Permission';
        $this->pluralLabel = 'Role Permissions';
    }
}
