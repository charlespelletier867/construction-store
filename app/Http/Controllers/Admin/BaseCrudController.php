<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

/**
 * Generic CRUD controller. Subclasses override:
 *
 * - $modelClass, $viewPrefix, $routePrefix, $singular, $pluralLabel
 * - tableColumns(): array of ['data', 'name', 'title', 'render?']
 * - formFields(): array of ['name', 'type', 'label', 'options?', 'rules?', 'required?']
 * - validationRules() (optional override of formFields()-derived rules)
 * - applyIndexQuery(Builder $q): scope the index list (company, branch, etc.)
 * - beforeStore/Update($model, array $data): optional hooks
 */
abstract class BaseCrudController extends Controller
{
    /** @var class-string<Model> */
    protected string $modelClass;

    protected string $viewPrefix;

    protected string $routePrefix;

    protected string $singular;

    protected string $pluralLabel;

    /** @return array<int, array{data:string,name:string,title:string,render?:string,searchable?:bool,orderable?:bool}> */
    abstract protected function tableColumns(): array;

    /** @return array<int, array{name:string,type:string,label:string,options?:array,required?:bool,col?:int,rules?:array,default?:mixed,help?:string}> */
    abstract protected function formFields(): array;

    protected function applyIndexQuery(Builder $q): Builder
    {
        $user = request()->user();
        if ($user && $this->modelHasCompanyId() && $user->company_id) {
            $q->where('company_id', $user->company_id);
        }

        return $q;
    }

    protected function modelHasCompanyId(): bool
    {
        $model = $this->modelClass;
        $instance = new $model;

        return $instance->getConnection()->getSchemaBuilder()->hasColumn($instance->getTable(), 'company_id');
    }

    protected function validationRules(?Model $instance = null): array
    {
        $rules = [];
        foreach ($this->formFields() as $field) {
            if (! empty($field['rules'])) {
                $rules[$field['name']] = $field['rules'];
            } elseif (! empty($field['required'])) {
                $rules[$field['name']] = $this->requiredValidationRulesFor($field);
            } else {
                $rules[$field['name']] = $this->defaultValidationRulesFor($field);
            }
        }

        return $rules;
    }

    protected function requiredValidationRulesFor(array $field): array
    {
        return array_values(array_unique(array_map(
            fn (string $rule) => $rule === 'nullable' ? 'required' : $rule,
            $this->defaultValidationRulesFor($field),
        )));
    }

    protected function defaultValidationRulesFor(array $field): array
    {
        return match ($field['type'] ?? 'text') {
            'email' => ['nullable', 'email'],
            'number' => ['nullable', 'numeric'],
            'date', 'datetime' => ['nullable', 'date'],
            'checkbox' => ['nullable', 'boolean'],
            default => ['nullable'],
        };
    }

    public function index(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $query = $this->applyIndexQuery($this->modelClass::query());

            return $this->dataTableResponse($query);
        }

        return view("{$this->viewPrefix}.index", [
            'columns' => $this->tableColumns(),
            'pluralLabel' => $this->pluralLabel,
            'routePrefix' => $this->routePrefix,
        ]);
    }

    protected function dataTableResponse(Builder $query): JsonResponse
    {
        $dt = DataTables::eloquent($query);
        $rawCols = ['action'];

        foreach ($this->tableColumns() as $col) {
            if (! empty($col['render']) && $col['render'] === 'status_badge') {
                $field = $col['data'];
                $dt->editColumn($field, fn ($row) => view('admin._partials.status_badge', ['active' => (bool) $row->{$field}])->render());
                $rawCols[] = $field;
            }
        }

        $dt->addColumn('action', fn ($row) => view('admin._partials.actions', [
            'routePrefix' => $this->routePrefix,
            'id' => $row->id,
        ])->render());

        $dt->rawColumns($rawCols);

        return $dt->toJson();
    }

    public function create(): View
    {
        $instance = new ($this->modelClass);

        return view("{$this->viewPrefix}.create", [
            'fields' => $this->formFields(),
            'instance' => $instance,
            'routePrefix' => $this->routePrefix,
            'singular' => $this->singular,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->validationRules());
        $this->applyDefaults($data);
        $this->coerceNullToColumnDefaults($data);
        try {
            $model = $this->modelClass::create($data);
        } catch (QueryException $e) {
            return $this->redirectBackWithDatabaseError($e, $request);
        }
        $this->afterSave($model, $request);
        flash()->success(__('admin.alert.created'));

        return redirect()->route("{$this->routePrefix}.index");
    }

    public function show(int $id): View
    {
        $instance = $this->modelClass::findOrFail($id);
        $view = view()->exists("{$this->viewPrefix}.show")
            ? "{$this->viewPrefix}.show"
            : 'admin._partials.generic_show';

        return view($view, [
            'instance' => $instance,
            'fields' => $this->formFields(),
            'routePrefix' => $this->routePrefix,
            'singular' => $this->singular,
        ]);
    }

    public function edit(int $id): View
    {
        $instance = $this->modelClass::findOrFail($id);

        return view("{$this->viewPrefix}.edit", [
            'fields' => $this->formFields(),
            'instance' => $instance,
            'routePrefix' => $this->routePrefix,
            'singular' => $this->singular,
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $model = $this->modelClass::findOrFail($id);
        $data = $request->validate($this->validationRules($model));
        $this->coerceNullToColumnDefaults($data);
        try {
            $model->update($data);
        } catch (QueryException $e) {
            return $this->redirectBackWithDatabaseError($e, $request);
        }
        $this->afterSave($model, $request);
        flash()->success(__('admin.alert.updated'));

        return redirect()->route("{$this->routePrefix}.index");
    }

    public function destroy(int $id): RedirectResponse
    {
        $model = $this->modelClass::findOrFail($id);
        try {
            $model->delete();
        } catch (QueryException $e) {
            return $this->redirectBackWithDatabaseError($e, request());
        }
        flash()->success(__('admin.alert.deleted'));

        return redirect()->route("{$this->routePrefix}.index");
    }

    /**
     * Translate a database constraint violation (FK, UNIQUE, NOT NULL) into a
     * friendly flash error + redirect back, instead of a raw HTTP 500.
     * Re-thrown in non-production env so debugging still surfaces the underlying SQL.
     */
    protected function redirectBackWithDatabaseError(QueryException $e, Request $request): RedirectResponse
    {
        $sqlState = $e->errorInfo[0] ?? null;
        $driverCode = $e->errorInfo[1] ?? null;
        $raw = $e->getMessage();
        $message = match (true) {
            str_contains($raw, 'FOREIGN KEY constraint') || str_contains($raw, 'foreign key constraint') => __('admin.alert.fk_violation'),
            str_contains($raw, 'UNIQUE constraint') || str_contains($raw, 'Duplicate entry') => __('admin.alert.unique_violation'),
            str_contains($raw, 'NOT NULL constraint') || str_contains($raw, 'cannot be null') => __('admin.alert.not_null_violation'),
            default => __('admin.alert.database_error'),
        };

        if (function_exists('logger')) {
            logger()->warning('DB constraint violation handled in CRUD controller', [
                'controller' => static::class,
                'sqlstate' => $sqlState,
                'driver_code' => $driverCode,
                'message' => $raw,
            ]);
        }

        flash()->error($message);

        return back()->withInput($request->except(['_token', '_method', 'password', 'password_confirmation']));
    }

    protected function applyDefaults(array &$data): void
    {
        $user = request()->user();
        if ($user && $this->modelHasCompanyId() && empty($data['company_id'])) {
            $data['company_id'] = $user->company_id;
        }
    }

    /**
     * For NOT NULL columns that have a non-null default in the schema, replace
     * incoming null/empty values with the column's default. This prevents
     * SQLSTATE[23000] NOT NULL constraint violations when a form submits an
     * empty <input type="number"> for a decimal field declared as
     * `->default(0)` (no `->nullable()`).
     */
    protected function coerceNullToColumnDefaults(array &$data): void
    {
        $instance = new ($this->modelClass);
        $table = $instance->getTable();

        foreach (Schema::getColumns($table) as $col) {
            $name = $col['name'] ?? null;
            if (! $name || ! array_key_exists($name, $data)) {
                continue;
            }
            $value = $data[$name];
            if ($value !== null && $value !== '') {
                continue;
            }
            $nullable = (bool) ($col['nullable'] ?? true);
            $default = $col['default'] ?? null;
            if ($nullable || $default === null) {
                continue;
            }

            $type = strtolower($col['type_name'] ?? $col['type'] ?? '');
            if (in_array($type, ['decimal', 'numeric', 'real', 'double', 'float'], true)) {
                $data[$name] = (float) trim((string) $default, "'\"");
            } elseif (in_array($type, ['integer', 'bigint', 'smallint', 'tinyint'], true)) {
                $data[$name] = (int) trim((string) $default, "'\"");
            } else {
                $data[$name] = trim((string) $default, "'\"");
            }
        }
    }

    protected function afterSave(Model $model, Request $request): void
    {
        // Optional hook
    }
}
