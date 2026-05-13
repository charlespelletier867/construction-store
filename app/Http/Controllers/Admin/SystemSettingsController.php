<?php

namespace App\Http\Controllers\Admin;

use App\Models\SystemSetting;

class SystemSettingsController extends BaseCrudController
{
    protected string $modelClass = SystemSetting::class;
    protected string $viewPrefix = 'admin.system_settings';
    protected string $routePrefix = 'admin.system_settings';

    public function __construct()
    {
        $this->singular = __('admin.menu.system_settings');
        $this->pluralLabel = __('admin.menu.system_settings');
    }

    protected function tableColumns(): array
    {
        return [
            ['data' => 'key', 'name' => 'key', 'title' => 'Key'],
            ['data' => 'value', 'name' => 'value', 'title' => 'Value'],
            ['data' => 'group', 'name' => 'group', 'title' => 'Group'],
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