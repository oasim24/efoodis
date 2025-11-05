@extends('admin.layouts.app')

@section('title', isset($user) ? 'Edit Users' : 'Add Users')

@section('content')

<form 
    action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}" 
    method="POST" 
    enctype="multipart/form-data"
>
    @csrf
    @if(isset($user))
        @method('PUT')
    @endif

    <div class="row p-0 m-0">

    
        <x-input 
            name="name" 
            label="Name" 
            placeholder="Enter  name" 
            required="true" 
            col="col-md-4"
            :value="$user->name ?? ''"
        />
       
        <x-input 
            name="email" 
            label="email" 
            placeholder="Enter email" 
            required="true" 
            col="col-md-4"
            :value="$user->email ?? ''"
        />
        <x-input 
            name="password" 
            label="Password" 
            placeholder="Enter Password" 
            required="true" 
            col="col-md-4"
            :value="''"
        />
             
   <x-select 
    name="roles[]" 
    label="Roles" 
    :options="$roles" 
    :selected="$selectedRoles ?? null" 
    :required="true" 
    :multiple="true" 
    col="col-md-4"
/>
        
       
    </div>

  

    <div class="mt-3">
        <button type="submit" class="btn btn-success">
            {{ isset($user) ? 'Update Users' : 'Create Users' }}
        </button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>
@endsection
