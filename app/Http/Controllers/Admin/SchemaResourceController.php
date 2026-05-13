<?php

namespace App\Http\Controllers\Admin;

use App\Models\Branch;
use App\Models\Customer;
use App\Models\Delivery;
use App\Models\Driver;
use App\Models\ExpenseCategory;
use App\Models\Permission;
use App\Models\Product;
use App\Models\PurchaseInvoice;
use App\Models\PurchaseItem;
use App\Models\PurchaseReturn;
use App\Models\Quotation;
use App\Models\Role;
use App\Models\SaleInvoice;
use App\Models\SaleItem;
use App\Models\SaleReturn;
use App\Models\StockAdjustment;
use App\Models\StockTransfer;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\View\View;

abstract class SchemaResourceController extends BaseCrudController
{
    protected array $indexColumns = [];
    protected array $fieldOverrides = [];

    protected array $selectSources = [
        'role_id' => [Role::class, 'name'],
        'permission_id' => [Permission::class, 'name'],
        'user_id' => [User::class, 'name'],
        'created_by' => [User::class, 'name'],
        'uploaded_by' => [User::class, 'name'],
        'requested_by' => [User::class, 'name'],
        'approved_by' => [User::class, 'name'],
        'sent_by' => [User::class, 'name'],
        'received_by' => [User::class, 'name'],
        'branch_id' => [Branch::class, 'name'],
        'from_branch_id' => [Branch::class, 'name'],
        'to_branch_id' => [Branch::class, 'name'],
        'warehouse_id' => [Warehouse::class, 'name'],
        'from_warehouse_id' => [Warehouse::class, 'name'],
        'to_warehouse_id' => [Warehouse::class, 'name'],
        'product_id' => [Product::class, 'name'],
        'unit_id' => [Unit::class, 'name'],
        'customer_id' => [Customer::class, 'name'],
        'supplier_id' => [Supplier::class, 'name'],
        'driver_id' => [Driver::class, 'name'],
        'vehicle_id' => [Vehicle::class, 'plate_number'],
        'expense_category_id' => [ExpenseCategory::class, 'name'],
        'stock_adjustment_id' => [StockAdjustment::class, 'adjustment_no'],
        'purchase_invoice_id' => [PurchaseInvoice::class, 'purchase_no'],
        'purchase_item_id' => [PurchaseItem::class, 'id'],
        'purchase_return_id' => [PurchaseReturn::class, 'return_no'],
        'sale_invoice_id' => [SaleInvoice::class, 'sale_no'],
        'converted_sale_invoice_id' => [SaleInvoice::class, 'sale_no'],
        'sale_item_id' => [SaleItem::class, 'id'],
        'sale_return_id' => [SaleReturn::class, 'return_no'],
        'quotation_id' => [Quotation::class, 'quotation_no'],
        'delivery_id' => [Delivery::class, 'delivery_no'],
        'stock_transfer_id' => [StockTransfer::class, 'transfer_no'],
    ];

    protected function tableColumns(): array
    {
        $columns = $this->indexColumns ?: $this->defaultIndexColumns();

        return collect($columns)
            ->map(fn (string $column) => [
                'data' => $column,
                'name' => $column,
                'title' => $this->fieldLabel($column),
            ])
            ->values()
            ->all();
    }

    protected function formFields(): array
    {
        return collect($this->schemaColumns())
            ->reject(fn (string $column) => $this->isSystemColumn($column))
            ->map(fn (string $column) => array_merge($this->defaultFieldFor($column), $this->fieldOverrides[$column] ?? []))
            ->values()
            ->all();
    }

    public function index(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $query = $this->applyIndexQuery($this->modelClass::query());
            return $this->dataTableResponse($query);
        }

        return view('admin._partials.generic_index', [
            'columns' => $this->tableColumns(),
            'pluralLabel' => $this->pluralLabel,
            'routePrefix' => $this->routePrefix,
        ]);
    }

    public function create(): View
    {
        $instance = new ($this->modelClass);

        return view('admin._partials.generic_form', [
            'fields' => $this->formFields(),
            'instance' => $instance,
            'routePrefix' => $this->routePrefix,
            'singular' => $this->singular,
        ]);
    }

    public function edit(int $id): View
    {
        $instance = $this->modelClass::findOrFail($id);

        return view('admin._partials.generic_form', [
            'fields' => $this->formFields(),
            'instance' => $instance,
            'routePrefix' => $this->routePrefix,
            'singular' => $this->singular,
        ]);
    }

    public function show(int $id): View
    {
        $instance = $this->modelClass::findOrFail($id);

        return view('admin._partials.generic_show', [
            'fields' => $this->formFields(),
            'instance' => $instance,
            'routePrefix' => $this->routePrefix,
            'singular' => $this->singular,
        ]);
    }

    protected function applyDefaults(array &$data): void
    {
        parent::applyDefaults($data);

        $user = request()->user();
        if (! $user) {
            return;
        }

        $table = (new $this->modelClass)->getTable();
        if (Schema::hasColumn($table, 'branch_id') && empty($data['branch_id'])) {
            $data['branch_id'] = request()->session()->get('current_branch_id');
        }

        foreach (['created_by', 'uploaded_by', 'requested_by'] as $column) {
            if (Schema::hasColumn($table, $column) && empty($data[$column])) {
                $data[$column] = $user->id;
            }
        }
    }

    protected function defaultIndexColumns(): array
    {
        $preferred = ['id', 'entry_no', 'movement_no', 'title', 'file_name', 'product_id', 'quantity', 'line_total', 'status', 'is_read'];
        $columns = $this->schemaColumns();
        $selected = array_values(array_intersect($preferred, $columns));

        foreach ($columns as $column) {
            if (count($selected) >= 6) {
                break;
            }

            if (! in_array($column, $selected, true) && ! $this->isSystemColumn($column) && ! Str::contains($column, ['note', 'message', 'data'])) {
                $selected[] = $column;
            }
        }

        return $selected ?: ['id'];
    }

    protected function defaultFieldFor(string $column): array
    {
        if (isset($this->selectSources[$column])) {
            return [
                'name' => $column,
                'type' => 'select',
                'label' => $this->fieldLabel($column),
                'options' => $this->optionsFor($column),
                'col' => 6,
                'required' => $this->columnIsRequired($column),
            ];
        }

        return [
            'name' => $column,
            'type' => $this->inputTypeFor($column),
            'label' => $this->fieldLabel($column),
            'col' => $this->columnWidthFor($column),
            'required' => $this->columnIsRequired($column),
        ];
    }

    protected function schemaColumns(): array
    {
        $table = (new $this->modelClass)->getTable();

        return Schema::hasTable($table) ? Schema::getColumnListing($table) : [];
    }

    protected function isSystemColumn(string $column): bool
    {
        return in_array($column, ['id', 'company_id', 'created_at', 'updated_at', 'deleted_at', 'remember_token'], true);
    }

    protected function columnIsRequired(string $column): bool
    {
        $table = (new $this->modelClass)->getTable();
        $metadata = collect(Schema::getColumns($table))->firstWhere('name', $column);

        if (! is_array($metadata)) {
            return false;
        }

        $nullable = $metadata['nullable'] ?? true;
        $default = $metadata['default'] ?? null;
        $autoIncrement = $metadata['auto_increment'] ?? false;

        return ! $nullable && $default === null && ! $autoIncrement && ! Str::endsWith($column, '_at');
    }

    protected function inputTypeFor(string $column): string
    {
        if (Str::startsWith($column, ['is_', 'can_']) || in_array($column, ['track_stock', 'allow_negative_stock'], true)) {
            return 'checkbox';
        }

        if (Str::endsWith($column, '_at') || Str::contains($column, ['datetime', 'captured_at', 'sent_at', 'read_at'])) {
            return 'datetime';
        }

        if (Str::endsWith($column, '_date') || $column === 'date') {
            return 'date';
        }

        if (Str::contains($column, ['quantity', 'amount', 'cost', 'price', 'total', 'debit', 'credit', 'balance', 'size'])) {
            return 'number';
        }

        if (Str::contains($column, ['note', 'reason', 'message', 'description', 'terms', 'address', 'data', 'values', 'user_agent'])) {
            return 'textarea';
        }

        if (Str::contains($column, 'email')) {
            return 'email';
        }

        return 'text';
    }

    protected function columnWidthFor(string $column): int
    {
        return Str::contains($column, ['note', 'reason', 'message', 'description', 'terms', 'address', 'data', 'values'])
            ? 12
            : 6;
    }

    protected function fieldLabel(string $column): string
    {
        return Str::headline(Str::beforeLast($column, '_id') ?: $column);
    }

    protected function optionsFor(string $column): array
    {
        [$class, $labelColumn] = $this->selectSources[$column];
        /** @var class-string<Model> $class */
        $model = new $class;
        $table = $model->getTable();

        if (! Schema::hasTable($table) || ! Schema::hasColumn($table, $labelColumn)) {
            return [];
        }

        return $class::query()
            ->orderBy($labelColumn)
            ->limit(500)
            ->pluck($labelColumn, 'id')
            ->toArray();
    }
}
