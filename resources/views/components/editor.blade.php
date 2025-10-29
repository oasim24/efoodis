@props([
    'name' => 'content',
    'label' => 'Description',
    'placeholder' => 'Enter text here...',
    'required' => false,
    'col' => 'col-md-12',
    'value' => '', // default value for editing
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

    <textarea 
        id="{{ $name }}"
        name="{{ $name }}"
        class="form-control summernote-editor @error($name) is-invalid @enderror"
        placeholder="{{ $placeholder }}"
        rows="6"
        {{ $required ? 'required' : '' }}
    >{!! old($name, $value) !!}</textarea>

    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

@pushOnce('styles')
<!-- Summernote CSS (Bootstrap 5 Compatible) -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
@endpushOnce

@pushOnce('scripts')
<!-- jQuery (required by Summernote) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Summernote JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
@endpushOnce

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    $('.summernote-editor').summernote({
        placeholder: function() {
            return $(this).attr('placeholder');
        },
        tabsize: 2,
        height: 300,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ],
        styleTags: ['p', 'h4', 'h5', 'blockquote'],
        disableDragAndDrop: false,
    });
});
</script>
@endpush
