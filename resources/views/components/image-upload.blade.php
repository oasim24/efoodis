@props([
    'name' => 'image',
    'label' => 'Upload Image',
    'preview' => null, // previous image URL (optional)
    'col' => 'col-md-6',
])

<div class="{{ $col }} mb-3">
    @if($label)
        <label class="form-label fw-bold">{{ $label }}</label>
    @endif

    <div 
        id="{{ $name }}-dropzone"
        class="border rounded d-flex align-items-center justify-content-center bg-light position-relative"
        style="width: 150px; height: 150px; cursor: pointer; overflow: hidden;"
        onclick="document.getElementById('{{ $name }}').click()"
        ondragover="handleDragOver(event)"
        ondragleave="handleDragLeave(event)"
        ondrop="handleDrop(event, '{{ $name }}', '{{ $name }}-preview')"
    >
        <!-- Image Preview -->
        <img 
            id="{{ $name }}-preview"
            src="{{ $preview ? asset($preview) : '' }}"
            alt="Preview"
            class="img-fluid w-100 h-100 object-fit-cover"
        >

        <!-- Remove Button -->
        <button 
            type="button"
            id="{{ $name }}-remove-btn"
            class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 rounded-circle {{ $preview ? 'd-block' : 'd-none' }}"
            onclick="removeImage('{{ $name }}', '{{ $name }}-preview', '{{ $name }}-remove-btn')"
        >
            &times;
        </button>
    </div>

    <!-- Hidden File Input -->
    <input 
        type="file"
        name="{{ $name }}"
        id="{{ $name }}"
        accept="image/*"
        class="d-none"
        onchange="previewImage(event, '{{ $name }}-preview', '{{ $name }}-remove-btn')"
    >

    @error($name)
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

@pushOnce('scripts')
<script>
function previewImage(event, previewId, removeBtnId) {
    const file = event.target.files[0];
    const preview = document.getElementById(previewId);
    const removeBtn = document.getElementById(removeBtnId);

    if (file) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            removeBtn.classList.remove('d-none');
        };
        reader.readAsDataURL(file);
    }
}

function removeImage(inputId, previewId, removeBtnId) {
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    const removeBtn = document.getElementById(removeBtnId);

    input.value = '';
    preview.src = 'https://via.placeholder.com/150x150?text=Upload+Image';
    removeBtn.classList.add('d-none');
}

function handleDragOver(event) {
    event.preventDefault();
    event.currentTarget.classList.add('border-primary');
    event.currentTarget.classList.add('bg-white');
}

function handleDragLeave(event) {
    event.currentTarget.classList.remove('border-primary');
    event.currentTarget.classList.remove('bg-white');
}

function handleDrop(event, inputId, previewId) {
    event.preventDefault();
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    const removeBtn = document.getElementById(`${inputId}-remove-btn`);

    const file = event.dataTransfer.files[0];
    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            removeBtn.classList.remove('d-none');
        };
        reader.readAsDataURL(file);
        input.files = event.dataTransfer.files;
    }

    event.currentTarget.classList.remove('border-primary');
    event.currentTarget.classList.remove('bg-white');
}
</script>
@endpushOnce
