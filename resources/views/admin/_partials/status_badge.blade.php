@if($active)
    <span class="badge bg-success" data-i18n="field.active">{{ __('admin.field.active') }}</span>
@else
    <span class="badge bg-secondary" data-i18n="field.inactive">{{ __('admin.field.inactive') }}</span>
@endif
