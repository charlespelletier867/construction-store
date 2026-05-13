{{--
    Generic Yajra DataTable wrapper.
    Props:
      $columns        array of ['data', 'name', 'title']
      $routePrefix    string  (e.g., 'admin.products')
      $pluralLabel    string  (used for h5 title)
      $extraButtons   optional html
--}}
<div class="card">
    <div class="card-header d-flex align-items-center">
        <h5 class="mb-0">{{ $pluralLabel ?? '' }}</h5>
        <div class="ms-auto d-flex gap-2">
            @if(isset($routePrefix) && \Route::has("$routePrefix.create"))
                <a href="{{ route("$routePrefix.create") }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg me-1"></i><span data-i18n="action.add_new">{{ __('admin.action.add_new') }}</span>
                </a>
            @endif
            @isset($extraButtons)
                {!! $extraButtons !!}
            @endisset
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="datatable-{{ Str::slug($routePrefix ?? 'gen') }}" data-route="{{ route("$routePrefix.index") }}">
                <thead>
                    <tr>
                        @foreach($columns as $c)
                            <th>{{ $c['title'] }}</th>
                        @endforeach
                        <th class="text-end" data-i18n="action.actions">{{ __('admin.action.actions') }}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function () {
    document.addEventListener('DOMContentLoaded', function () {
        const tableId = @json("datatable-" . Str::slug($routePrefix ?? 'gen'));
        const url = @json(route("$routePrefix.index"));
        const cols = @json($columns);
        const dtColumns = cols.map(c => ({ data: c.data, name: c.name, orderable: c.orderable !== false, searchable: c.searchable !== false }));
        dtColumns.push({ data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-end' });

        if (window.jQuery && window.jQuery.fn.dataTable) {
            window.jQuery('#' + tableId).DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pagingType: 'full_numbers',
                pageLength: 15,
                lengthMenu: [10, 15, 25, 50, 100],
                ajax: { url, type: 'GET' },
                columns: dtColumns,
                language: {
                    search: '',
                    searchPlaceholder: window.i18n?.global?.t('action.search', 'Search...') || 'Search...',
                    paginate: { first: '&laquo;', previous: '&lsaquo;', next: '&rsaquo;', last: '&raquo;' },
                },
                dom: '<"row align-items-center mb-2"<"col-md-6"l><"col-md-6 text-end"f>>' +
                     'rt' +
                     '<"row align-items-center mt-2"<"col-md-6"i><"col-md-6"p>>',
            });
        }
    });
})();
</script>
@endpush
