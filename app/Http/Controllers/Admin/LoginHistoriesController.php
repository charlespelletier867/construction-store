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
            ['data' => 'logged_in_at', 'name' => 'logged_in_at', 'title' => 'Login At'],
            ['data' => 'ip_address', 'name' => 'ip_address', 'title' => 'IP'],
            ['data' => 'is_successful', 'name' => 'is_successful', 'title' => __('admin.field.status')],
        ];
    }

    protected function formFields(): array
    {
        return [
            ['name' => 'email', 'type' => 'email', 'label' => __('admin.field.email'), 'col' => 6],
            ['name' => 'ip_address', 'type' => 'text', 'label' => 'IP', 'col' => 6],
            ['name' => 'is_successful', 'type' => 'checkbox', 'label' => __('admin.field.status'), 'col' => 6],
            ['name' => 'failure_reason', 'type' => 'textarea', 'label' => 'Failure Reason', 'col' => 12],
        ];
    }

}
