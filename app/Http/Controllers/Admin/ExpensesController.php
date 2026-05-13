<?php

namespace App\Http\Controllers\Admin;

use App\Models\Expense;

class ExpensesController extends BaseCrudController
{
    protected string $modelClass = Expense::class;
    protected string $viewPrefix = 'admin.expenses';
    protected string $routePrefix = 'admin.expenses';

    public function __construct()
    {
        $this->singular = __('admin.menu.expenses');
        $this->pluralLabel = __('admin.menu.expenses');
    }

    protected function tableColumns(): array
    {
        return [
            ['data' => 'expense_no', 'name' => 'expense_no', 'title' => '#'],
            ['data' => 'expense_date', 'name' => 'expense_date', 'title' => __('admin.field.date')],
            ['data' => 'amount', 'name' => 'amount', 'title' => __('admin.field.amount')],
            ['data' => 'note', 'name' => 'note', 'title' => __('admin.field.note')],
        ];
    }

    protected function formFields(): array
    {
        return [
            ['name' => 'expense_no', 'type' => 'text', 'label' => 'Expense #', 'col' => 4],
            ['name' => 'expense_date', 'type' => 'date', 'label' => __('admin.field.date'), 'required' => true, 'col' => 4, 'rules' => ['required', 'date']],
            ['name' => 'expense_category_id', 'type' => 'select', 'label' => 'Category', 'options' => \App\Models\ExpenseCategory::query()->orderBy('name')->pluck('name', 'id')->toArray(), 'col' => 4],
            ['name' => 'branch_id', 'type' => 'select', 'label' => __('admin.field.branch'), 'options' => \App\Models\Branch::query()->orderBy('name')->pluck('name', 'id')->toArray(), 'required' => true, 'col' => 6, 'rules' => ['required', 'integer', 'exists:branches,id']],
            ['name' => 'amount', 'type' => 'number', 'label' => __('admin.field.amount'), 'required' => true, 'col' => 6, 'rules' => ['required', 'numeric', 'min:0']],
            ['name' => 'receipt_path', 'type' => 'text', 'label' => 'Receipt Path', 'col' => 6],
            ['name' => 'note', 'type' => 'textarea', 'label' => __('admin.field.note'), 'col' => 12],
        ];
    }
}
