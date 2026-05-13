@extends('admin.layouts.admin_layout')

@section('pageTitle', ($instance->exists ?? false) ? __('admin.action.edit') . ' ' . $singular : __('admin.action.add_new') . ' ' . $singular)

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center">
        <h5 class="mb-0">{{ $instance->exists ? __('admin.action.edit') . ' ' . $singular : __('admin.action.add_new') . ' ' . $singular }}</h5>
        <a href="{{ route("$routePrefix.index") }}" class="btn btn-outline-secondary btn-sm ms-auto">
            <i class="bi bi-arrow-left me-1"></i>{{ __('admin.action.back') }}
        </a>
    </div>
    <div class="card-body">
        <form
            method="POST"
            action="{{ $instance->exists ? route("$routePrefix.update", $instance->id) : route("$routePrefix.store") }}"
            enctype="multipart/form-data"
        >
            @csrf
            @if($instance->exists) @method('PUT') @endif

            @include('admin._partials.form_fields', ['fields' => $fields, 'instance' => $instance])

            <div class="d-flex justify-content-end gap-2 mt-3">
                <a href="{{ route("$routePrefix.index") }}" class="btn btn-secondary">
                    {{ __('admin.action.cancel') }}
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i>{{ __('admin.action.save') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
