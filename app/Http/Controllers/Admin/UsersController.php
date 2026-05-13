<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UsersController extends BaseCrudController
{
    protected string $modelClass = User::class;
    protected string $viewPrefix = 'admin.users';
    protected string $routePrefix = 'admin.users';

    public function __construct()
    {
        $this->singular = __('admin.menu.users');
        $this->pluralLabel = __('admin.menu.users');
    }

    protected function tableColumns(): array
    {
        return [
            ['data' => 'user_code', 'name' => 'user_code', 'title' => __('admin.field.code')],
            ['data' => 'name', 'name' => 'name', 'title' => __('admin.field.name')],
            ['data' => 'email', 'name' => 'email', 'title' => __('admin.field.email')],
            ['data' => 'is_active', 'name' => 'is_active', 'title' => __('admin.field.status'), 'render' => 'status_badge'],
        ];
    }

    protected function formFields(): array
    {
        return [
            ['name' => 'user_code', 'type' => 'text', 'col' => 4],
            ['name' => 'name', 'type' => 'text', 'label' => __('admin.field.name'), 'required' => true, 'col' => 4, 'rules' => ['required', 'string', 'max:255']],
            ['name' => 'email', 'type' => 'email', 'label' => __('admin.field.email'), 'required' => true, 'col' => 4, 'rules' => ['required', 'email', 'max:255']],
            ['name' => 'phone', 'type' => 'tel', 'col' => 4],
            ['name' => 'role_id', 'type' => 'select', 'label' => 'Role', 'options' => \App\Models\Role::query()->orderBy('name')->pluck('name', 'id')->toArray(), 'col' => 4],
            ['name' => 'default_branch_id', 'type' => 'select', 'label' => 'Default Branch', 'options' => \App\Models\Branch::query()->orderBy('name')->pluck('name', 'id')->toArray(), 'col' => 4],
            ['name' => 'password', 'type' => 'password', 'label' => __('admin.field.password'), 'col' => 6, 'rules' => ['nullable', 'string', 'min:6']],
            ['name' => 'is_active', 'type' => 'checkbox', 'label' => __('admin.field.active'), 'col' => 3, 'default' => 1],
            ['name' => 'can_view_money', 'type' => 'checkbox', 'label' => 'Can View Money', 'col' => 3],
        ];
    }

    protected function validationRules(?Model $instance = null): array
    {
        $rules = parent::validationRules($instance);
        $rules['password'] = $instance?->exists
            ? ['nullable', 'string', 'min:6']
            : ['required', 'string', 'min:6'];

        return $rules;
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $model = $this->modelClass::findOrFail($id);
        $data = $request->validate($this->validationRules($model));

        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        }

        $model->update($data);
        $this->afterSave($model, $request);
        flash()->success(__('admin.alert.updated'));

        return redirect()->route("{$this->routePrefix}.index");
    }
}
