{{--
    Props:
      $fields    array of formField definitions
      $instance  Model instance (with .name accessor or attributes)
--}}
<div class="row g-3">
@foreach($fields as $field)
    @php
        $name = $field['name'];
        $type = $field['type'] ?? 'text';
        $label = $field['label'] ?? Str::title(str_replace('_', ' ', $name));
        $col = $field['col'] ?? 6;
        $required = ! empty($field['required']);
        $help = $field['help'] ?? null;
        $value = old($name, $instance->{$name} ?? ($field['default'] ?? ''));
    @endphp

    <div class="col-md-{{ $col }}">
        @if($type !== 'checkbox')
            <label class="form-label" for="field-{{ $name }}">
                {{ $label }} @if($required)<span class="text-danger">*</span>@endif
            </label>
        @endif

        @if(in_array($type, ['text', 'email', 'number', 'tel', 'url', 'password']))
            <input
                type="{{ $type }}"
                class="form-control @error($name) is-invalid @enderror"
                id="field-{{ $name }}"
                name="{{ $name }}"
                value="{{ $value }}"
                @if($required) required @endif
                @if($type === 'number') step="any" @endif
            >
        @elseif($type === 'textarea')
            <textarea
                class="form-control @error($name) is-invalid @enderror"
                id="field-{{ $name }}"
                name="{{ $name }}"
                rows="3"
                @if($required) required @endif
            >{{ $value }}</textarea>
        @elseif($type === 'date')
            <input
                type="text"
                class="form-control flatpickr @error($name) is-invalid @enderror"
                id="field-{{ $name }}"
                name="{{ $name }}"
                value="{{ $value }}"
                data-time="false"
                @if($required) required @endif
            >
        @elseif($type === 'datetime')
            <input
                type="text"
                class="form-control flatpickr @error($name) is-invalid @enderror"
                id="field-{{ $name }}"
                name="{{ $name }}"
                value="{{ $value }}"
                data-time="true"
                @if($required) required @endif
            >
        @elseif($type === 'select')
            <select
                class="form-select tom-select @error($name) is-invalid @enderror"
                id="field-{{ $name }}"
                name="{{ $name }}"
                @if($required) required @endif
            >
                <option value="">{{ __('admin.action.choose') }}</option>
                @foreach(($field['options'] ?? []) as $optValue => $optLabel)
                    <option value="{{ $optValue }}" @selected((string) $value === (string) $optValue)>{{ $optLabel }}</option>
                @endforeach
            </select>
        @elseif($type === 'checkbox')
            <div class="form-check mt-md-4 pt-md-2">
                <input
                    type="hidden"
                    name="{{ $name }}"
                    value="0"
                >
                <input
                    type="checkbox"
                    class="form-check-input"
                    id="field-{{ $name }}"
                    name="{{ $name }}"
                    value="1"
                    @checked((bool) $value)
                >
                <label class="form-check-label" for="field-{{ $name }}">
                    {{ $label }}
                </label>
            </div>
        @endif

        @if($help)
            <div class="form-text">{{ $help }}</div>
        @endif

        @error($name)
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
@endforeach
</div>
