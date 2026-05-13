{{-- Translations and Ziggy are exposed via <head> @routes and the app.js bootstrapper. --}}
@php
    $__translations = [
        'en' => trans('admin', [], 'en'),
        'km' => trans('admin', [], 'km'),
    ];
    $__branch = [
        'id' => session('current_branch_id'),
        'name' => session('current_branch_name'),
    ];
@endphp
<script>
    window.__APP_LOCALE__ = @json(app()->getLocale());
    window.__APP_TRANSLATIONS__ = @json($__translations);
    window.__APP_USER__ = @json(auth()->user());
    window.__APP_BRANCH__ = @json($__branch);
</script>
@stack('scripts')
@flasher_render
