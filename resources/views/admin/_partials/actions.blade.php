{{--
    Props: $routePrefix (e.g. admin.products), $id
--}}
<div class="btn-group" role="group">
    @if(\Route::has("$routePrefix.edit"))
        <a href="{{ route("$routePrefix.edit", $id) }}" class="btn btn-sm btn-outline-primary" title="{{ __('admin.action.edit') }}">
            <i class="bi bi-pencil"></i>
        </a>
    @endif
    @if(\Route::has("$routePrefix.destroy"))
        <form action="{{ route("$routePrefix.destroy", $id) }}" method="POST" class="confirm-delete d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-outline-danger" title="{{ __('admin.action.delete') }}">
                <i class="bi bi-trash"></i>
            </button>
        </form>
    @endif
</div>
