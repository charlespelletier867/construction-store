@extends('admin.layouts.admin_layout')

@section('pageTitle', __('admin.action.view') . ' ' . $singular)

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center">
        <h5 class="mb-0">{{ __('admin.action.view') }} {{ $singular }}</h5>
        <div class="ms-auto d-flex gap-2">
            @if(\Route::has("$routePrefix.edit"))
                <a href="{{ route("$routePrefix.edit", $instance->id) }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-pencil me-1"></i>{{ __('admin.action.edit') }}
                </a>
            @endif
            <a href="{{ route("$routePrefix.index") }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>{{ __('admin.action.back') }}
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-3">
            @foreach($fields as $field)
                @php
                    $name = $field['name'];
                    $label = $field['label'] ?? Str::title(str_replace('_', ' ', $name));
                    $value = $instance->{$name} ?? null;
                    if (is_bool($value)) {
                        $value = $value ? __('admin.field.active') : __('admin.field.inactive');
                    }
                    if ($value instanceof \Carbon\CarbonInterface) {
                        $value = $value->format('Y-m-d H:i');
                    }
                    if (is_array($value)) {
                        $value = json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                    }
                @endphp
                <div class="col-md-6">
                    <div class="border rounded p-3 h-100">
                        <div class="text-muted small mb-1">{{ $label }}</div>
                        <div class="fw-semibold text-break">{{ filled($value) ? $value : '-' }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
