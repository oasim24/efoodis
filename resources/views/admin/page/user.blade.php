@extends('admin.layouts.app')

@section('title', 'Home Page')

@section('content')
<div class="d-flex my-3 align-items-center justify-content-between">
    <nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Users</li>
  </ol>
</nav>
    <a href="{{route('users.create')}}" class="btn btn-primary">Create</a>

</div>

<table id="commonTable">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
           
            <th>action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $index => $user)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>@foreach ($user->roles as $role)
        <span class="badge bg-primary">{{ $role->name }}</span>
    @endforeach</td>
               
               
                
                <td>

                    <a href="{{ route('users.edit', $user->id) }}"
                        class="btn btn-sm btn-primary">
                        Edit
                    </a>

<form action="{{ route('users.delete', $user->id) }}" method="POST" class="d-inline"
          onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
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