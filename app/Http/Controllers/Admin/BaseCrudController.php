<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        $model = $this->modelClass::create($data);
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
        $model->update($data);
        $this->afterSave($model, $request);
        flash()->success(__('admin.alert.updated'));
        return redirect()->route("{$this->routePrefix}.index");
    }

    public function destroy(int $id): RedirectResponse
    {
        $model = $this->modelClass::findOrFail($id);
        $model->delete();
        flash()->success(__('admin.alert.deleted'));
        return redirect()->route("{$this->routePrefix}.index");
    }

    protected function applyDefaults(array &$data): void
    {
        $user = request()->user();
        if ($user && $this->modelHasCompanyId() && empty($data['company_id'])) {
            $data['company_id'] = $user->company_id;
        }
    }

    protected function afterSave(Model $model, Request $request): void
    {
        // Optional hook
    }
}
