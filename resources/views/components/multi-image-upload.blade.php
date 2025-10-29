@props([
    'name' => 'images',
    'label' => 'Upload Images',
    'existing' => [], // Array of existing images (URLs or paths)
    'col' => 'col-md-12',
    'max' => 5, // Maximum number of allowed images
])

<div class="{{ $col }} mb-3">
    @if($label)
        <label class="form-label fw-bold">{{ $label }}</label>
    @endif

    <!-- Upload Area -->
    <div 
        id="{{ $name }}-dropzone"
        class="border border-secondary rounded bg-light p-3 text-center position-relative flex-wrap d-flex align-items-center justify-content-center gap-2"
        style="cursor: pointer; min-height: 150px;"
        onclick="document.getElementById('{{ $name }}').click()"
        ondragover="handleDragOver(event)"
        ondragleave="handleDragLeave(event)"
        ondrop="handleMultiDrop(event, '{{ $name }}', '{{ $name }}-dropzone', {{ $max }})"
        data-max="{{ $max }}"
    >
        <p id="{{ $name }}-placeholder" class="text-muted m-0 w-100">Click or drag up to {{ $max }} images</p>

        <!-- Existing image previews -->
        @foreach($existing as $index => $image)
            <div class="position-relative image-wrapper" draggable="true" ondragstart="handleDragStart(event)" ondragend="handleDragEnd(event)">
                <img 
                    src="{{ asset($image) }}" 
                    class="rounded border object-fit-cover"
                    style="width: 120px; height: 120px;"
                >
                <button 
                    type="button" 
                    class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 rounded-circle"
                    onclick="removeImagePreview(this)"
                >&times;</button>
                <input type="hidden" name="existing_images[]" value="{{ $image }}">
            </div>
        @endforeach
    </div>

    <!-- Hidden Input -->
    <input 
        type="file" 
        name="{{ $name }}[]" 
        id="{{ $name }}" 
        accept="image/*" 
        multiple 
        class="d-none" 
        onchange="previewMultipleImages(event, '{{ $name }}-dropzone', '{{ $name }}-placeholder', {{ $max }})"
    >

    <!-- Warning Message -->
    <div id="{{ $name }}-warning" class="text-danger small mt-2 d-none"></div>

    @error($name)
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

@pushOnce('scripts')
<script>
function handleDragOver(event) {
    event.preventDefault();
    event.currentTarget.classList.add('border-primary', 'bg-white');
}

function handleDragLeave(event) {
    event.currentTarget.classList.remove('border-primary', 'bg-white');
}

function handleMultiDrop(event, inputId, dropzoneId, max) {
    event.preventDefault();
    const dropzone = document.getElementById(dropzoneId);
    const input = document.getElementById(inputId);
    const warning = document.getElementById(`${inputId}-warning`);
    const files = Array.from(event.dataTransfer.files);
    const currentCount = dropzone.querySelectorAll('.image-wrapper').length;

    if (currentCount + files.length > max) {
        warning.textContent = `You can upload up to ${max} images only.`;
        warning.classList.remove('d-none');
        event.currentTarget.classList.remove('border-primary', 'bg-white');
        return;
    } else {
        warning.classList.add('d-none');
    }

    appendPreviews(files, dropzone);
    input.files = new FileListItems([
        ...Array.from(input.files),
        ...files
    ]);

    event.currentTarget.classList.remove('border-primary', 'bg-white');
}

function previewMultipleImages(event, dropzoneId, placeholderId, max) {
    const files = Array.from(event.target.files);
    const dropzone = document.getElementById(dropzoneId);
    const placeholder = document.getElementById(placeholderId);
    const warning = document.getElementById(`${event.target.id}-warning`);
    const currentCount = dropzone.querySelectorAll('.image-wrapper').length;

    if (currentCount + files.length > max) {
        warning.textContent = `You can upload up to ${max} images only.`;
        warning.classList.remove('d-none');
        event.target.value = ''; // reset input
        return;
    } else {
        warning.classList.add('d-none');
    }

    appendPreviews(files, dropzone);
    placeholder.style.display = 'none';
}

function appendPreviews(files, dropzone) {
    const placeholder = dropzone.querySelector('p.text-muted');
    if (placeholder) placeholder.style.display = 'none';

    files.forEach(file => {
        if (!file.type.startsWith('image/')) return;

        const reader = new FileReader();
        reader.onload = e => {
            const wrapper = document.createElement('div');
            wrapper.classList.add('position-relative', 'image-wrapper');
            wrapper.draggable = true;
            wrapper.ondragstart = handleDragStart;
            wrapper.ondragend = handleDragEnd;

            wrapper.innerHTML = `
                <img src="${e.target.result}" class="rounded border object-fit-cover" style="width: 120px; height: 120px;">
                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 rounded-circle" onclick="removeImagePreview(this)">&times;</button>
            `;
            dropzone.appendChild(wrapper);
        };
        reader.readAsDataURL(file);
    });
}

function removeImagePreview(button) {
    const wrapper = button.closest('.image-wrapper');
    const dropzone = wrapper.parentElement;
    const placeholder = dropzone.querySelector('p.text-muted');
    wrapper.remove();
    const warning = document.getElementById(`${dropzone.id.replace('-dropzone', '')}-warning`);
    if (warning) warning.classList.add('d-none');
    if (dropzone.querySelectorAll('.image-wrapper').length === 0 && placeholder) {
        placeholder.style.display = 'block';
    }
}

function handleDragStart(event) {
    event.dataTransfer.setData('text/plain', null);
    event.currentTarget.classList.add('dragging');
}

function handleDragEnd(event) {
    event.currentTarget.classList.remove('dragging');
}

function FileListItems(files) {
    const b = new ClipboardEvent("").clipboardData || new DataTransfer();
    for (let i = 0; i < files.length; i++) b.items.add(files[i]);
    return b.files;
}
</script>

<style>
.image-wrapper {
    width: 120px;
    height: 120px;
}
.image-wrapper.dragging {
    opacity: 0.5;
}
#{{ $name }}-dropzone {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    justify-content: flex-start;
    align-items: center;
}
</style>
@endpushOnce
