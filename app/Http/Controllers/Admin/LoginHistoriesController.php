<?php

namespace App\Http\Controllers\Admin;

use App\Models\LoginHistory;

class LoginHistoriesController extends BaseCrudController
{
    protected string $modelClass = LoginHistory::class;
    protected string $viewPrefix = 'admin.login_histories';
    protected string $routePrefix = 'admin.login_histories';

    public function __construct()
    {
        $this->singular = __('admin.menu.login_histories');
        $this->pluralLabel = __('admin.menu.login_histories');
    }

    protected function tableColumns(): array
    {
        return [
            ['data' => 'login_at', 'name' => 'login_at', 'title' => 'Login At'],
            ['data' => 'ip_address', 'name' => 'ip_address', 'title' => 'IP'],
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