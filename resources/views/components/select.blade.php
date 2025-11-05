@props([
    'name' => 'select',
    'label' => 'Select Option',
    'options' => [], // ['value' => 'Display Text']
    'selected' => null, // can be single value or array
    'required' => false,
    'multiple' => false,
    'col' => 'col-md-12',
])

@php
    // Handle old input for form repopulation
    $oldValue = old(str_replace('[]', '', $name));
    $selectedValues = collect($selected ?? []);

    // If it's not multiple and a single old value exists, convert it to a collection
    if (!$multiple && !is_array($selected)) {
        $selectedValues = collect([$selected ?? $oldValue]);
    }

    // If multiple, merge old values (if present)
    if ($multiple && is_array($oldValue)) {
        $selectedValues = collect($oldValue);
    }
@endphp

<div class="{{ $col }} mb-3">
    @if($label)
        <label for="{{ $name }}" class="form-label fw-bold">
            {{ $label }}
            @if($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    <select 
        id="{{ str_replace('[]', '', $name) }}" 
        name="{{ $name }}" 
        class="form-select @error(str_replace('[]', '', $name)) is-invalid @enderror"
        {{ $required ? 'required' : '' }}
        {{ $multiple ? 'multiple' : '' }}
    >
        @if(!$multiple)
            <option value="" disabled {{ $selectedValues->isEmpty() ? 'selected' : '' }}>
                -- Select {{ $label }} --
            </option>
        @endif

        @foreach($options as $value => $text)
            <option value="{{ $value }}" {{ $selectedValues->contains($value) ? 'selected' : '' }}>
                {{ $text }}
            </option>
        @endforeach
    </select>

    @error(str_replace('[]', '', $name))
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
