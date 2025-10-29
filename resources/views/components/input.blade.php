<div class="{{ $col }} mb-3">
    <label for="{{ $name }}" class="form-label">{{ $label }}  @if($required)
                <span class="text-danger">*</span>
            @endif</label>
    <input 
        type="{{ $type }}" 
        name="{{ $name }}" 
        id="{{ $name }}"
        placeholder="{{ $placeholder }}" 
        class="form-control @error($name) is-invalid @enderror"
        @if($required) required @endif
        value="{{ old($name, $value) }}"
    >
    @error($name)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
