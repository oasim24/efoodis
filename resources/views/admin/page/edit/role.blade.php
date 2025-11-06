@extends('admin.layouts.app')

@section('title', isset($role) ? 'Edit Roles' : 'Add Roles')

@section('content')

<form 
    action="{{ isset($role) ? route('roles.update', $role->id) : route('roles.store') }}" 
    method="POST" 
    enctype="multipart/form-data"
>
    @csrf
    @if(isset($role))
        @method('PUT')
    @endif

    <x-input 
        name="role" 
        label="Role" 
        placeholder="Enter Role" 
        required="true" 
        col="col-md-4"
        :value="$role->name ?? ''"
    />

    <div class="row p-0 m-0 gap-2 row-cols-auto">
        @php
            
            $grouped = [];
            foreach ($permissions as $permission) {
                $parts = explode('.', $permission->name);
                $group = $parts[0];
                $action = $parts[1] ?? '';
                $grouped[$group][] = ['id' => $permission->id, 'action' => $action];
            }

           
            $rolePermissions = isset($role) ? $role->permissions->pluck('id')->toArray() : [];
        @endphp

        @foreach ($grouped as $groupName => $actions)
            <div class="col border rounded" style="height: min-content;">
                <div class="form-check mb-2">
                    <input type="checkbox" class="form-check-input group-checkbox" id="group_{{ $groupName }}">
                    <label class="form-check-label fw-bold text-primary" for="group_{{ $groupName }}">
                        {{ ucfirst($groupName) }}
                    </label>
                </div>

                <div class="row ms-1 row-cols-auto">
                    @foreach ($actions as $permission)
                        <div class="col mb-2">
                            <div class="form-check">
                                <input type="checkbox"
                                    name="permissions[]"
                                    value="{{ $permission['id'] }}"
                                    id="perm_{{ $permission['id'] }}"
                                    class="form-check-input child-checkbox group_{{ $groupName }}"
                                  
                                    {{ in_array($permission['id'], $rolePermissions) ? 'checked' : '' }}
                                >
                                <label for="perm_{{ $permission['id'] }}" class="form-check-label" style="font-size:13px">
                                    {{ $permission['action'] }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-3">
        <button type="submit" class="btn btn-success">
            {{ isset($role) ? 'Update roles' : 'Create roles' }}
        </button>
        <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

   
    document.querySelectorAll('.group-checkbox').forEach(group => {
        const groupName = group.id.replace('group_', '');
        const children = document.querySelectorAll('.child-checkbox.group_' + groupName);
        const allChecked = Array.from(children).every(c => c.checked);
        group.checked = allChecked;
    });

   
    document.querySelectorAll('.group-checkbox').forEach(group => {
        group.addEventListener('change', function() {
            const groupName = this.id.replace('group_', '');
            const children = document.querySelectorAll('.child-checkbox.group_' + groupName);
            children.forEach(child => child.checked = this.checked);
        });
    });

   
    document.querySelectorAll('.child-checkbox').forEach(child => {
        child.addEventListener('change', function() {
            const classList = this.classList;
            const groupName = Array.from(classList).find(c => c.startsWith('group_')).replace('group_', '');
            const allChildren = document.querySelectorAll('.child-checkbox.group_' + groupName);
            const groupBox = document.getElementById('group_' + groupName);
            groupBox.checked = Array.from(allChildren).every(c => c.checked);
        });
    });
});
</script>
@endpush
