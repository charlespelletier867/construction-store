<?php

namespace App\Http\Controllers\Admin;

use App\Models\UserBranchRole;

class UserBranchRolesController extends SchemaResourceController
{
    protected string $modelClass = UserBranchRole::class;
    protected string $viewPrefix = 'admin.user_branch_roles';
    protected string $routePrefix = 'admin.user_branch_roles';
    protected array $indexColumns = ['id', 'user_id', 'branch_id', 'role_id', 'is_default', 'is_active'];

    public function __construct()
    {
        $this->singular = 'User Branch Role';
        $this->pluralLabel = 'User Branch Roles';
    }
}
