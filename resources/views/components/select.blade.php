@props([
    'name' => 'select',
    'label' => 'Select Option',
    'options' => [], // ['value' => 'Display Text']
    'selected' => null, // value to be selected by default
    'required' => false,
    'col' => 'col-md-12',
])

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
        id="{{ $name }}" 
        name="{{ $name }}" 
        class="form-select @error($name) is-invalid @enderror"
        {{ $required ? 'required' : '' }}
    >
        <option value="" disabled {{ old($name, $selected) === null ? 'selected' : '' }}>-- Select {{ $label }} --</option>

        @foreach($options as $value => $text)
            <option value="{{ $value }}" {{ old($name, $selected) == $value ? 'selected' : '' }}>
                {{ $text }}
            </option>
        @endforeach
    </select>

    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
