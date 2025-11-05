@extends('admin.layouts.app')

@section('title', 'Role & Permission Management')

@section('content')
<div class="py-5">

    <h2 class="mb-4 text-center">🔐 Role & Permission Management</h2>

    {{-- Flash Messages --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Create Role Form --}}
    <div class="card mb-5 shadow-sm">
        <div class="card-header bg-dark text-white">
            <strong>Create New Role with Permissions</strong>
        </div>
        <div class="card-body">
            <form action="{{ route('roles.store') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-5">
                        <label for="name" class="form-label">Role Name</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Editor" required>
                    </div>
                    <div class="col-md-5">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" name="slug" class="form-control" placeholder="e.g. editor" required>
                    </div>
                </div>

                <hr>

                <h5 class="mb-3">Assign Permissions</h5>
                <div class="row">
                    @foreach ($permissions as $permission)
                        <div class="col-md-3 mb-2">
                            <div class="form-check">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="perm_{{ $permission->id }}" class="form-check-input">
                                <label for="perm_{{ $permission->id }}" class="form-check-label">
                                    {{ $permission->name }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Create Role with Permissions
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Existing Roles --}}
    <div class="card">
        <div class="card-header bg-secondary text-white">
            <strong>Existing Roles & Permissions</strong>
        </div>
        <div class="card-body">
            @forelse ($roles as $role)
                <div class="mb-4 border p-3 rounded">
                    <h5 class="mb-2">
                        <strong>{{ ucfirst($role->name) }}</strong>
                        <span class="text-muted">({{ $role->slug }})</span>
                    </h5>

                    @if ($role->permissions->count())
                        <ul class="list-inline">
                            @foreach ($role->permissions as $perm)
                                <li class="list-inline-item badge bg-success">{{ $perm->name }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">No permissions assigned.</p>
                    @endif
                </div>
            @empty
                <p>No roles found.</p>
            @endforelse
        </div>
    </div>

</div>
@endsection
