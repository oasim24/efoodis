@extends('admin.layouts.app')

@section('title', 'Role & Permission Management')

@section('content')

<div class="d-flex my-3 align-items-center justify-content-between">
    <nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Roles</li>
  </ol>
</nav>
    <a href="{{route('roles.create')}}" class="btn btn-primary">Create</a>

</div>


<table id="commonTable">
    <thead>
        <tr>
            <th>#</th>
            <th>Role</th>
          
            <th>Permission</th>
            <th>action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($roles as $index => $role)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $role->name }}</td>
            <td>
                    @if ($role->permissions->count())
                        <ul class="list-inline">
                            @foreach ($role->permissions as $perm)
                                <li class="list-inline-item badge bg-success">{{ $perm->name }}</li>
                            @endforeach
                        </ul>
                    @endif
            </td>       
            <td>
   
    <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-primary">
        Edit
    </a>

  
    <form action="{{ route('roles.delete', $role->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this product?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger">
            Delete
        </button>
    </form>
    </td>

        </tr>
        @endforeach
      
    </tbody>
</table>


@endsection
