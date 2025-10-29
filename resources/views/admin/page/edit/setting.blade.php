@extends('admin.layouts.app')

@section('title', isset($setting) ? 'Edit Settings' : 'Add Settings')

@section('content')

<form 
    action="{{ isset($setting) ? route('settings.update', $setting->id) : route('settings.store') }}" 
    method="POST" 
    enctype="multipart/form-data"
>
    @csrf
    @if(isset($setting))
        @method('PUT')
    @endif

    <div class="row">

    
        <x-input 
            name="name" 
            label="company  Name" 
            placeholder="Enter  name" 
            required="true" 
            col="col-md-4"
            :value="$setting->name ?? ''"
        />
        <x-input 
            name="phone" 
            label="company Phone" 
            placeholder="Enter Phone" 
            required="true" 
            col="col-md-4"
            :value="$setting->phone ?? ''"
        />
        <x-input 
            name="email" 
            label="company email" 
            placeholder="Enter email" 
            required="true" 
            col="col-md-4"
            :value="$setting->email ?? ''"
        />
        <x-input 
            name="address" 
            label="company address" 
            placeholder="Enter address" 
            required="true" 
            col="col-md-4"
            :value="$setting->address ?? ''"
        />
        

        <x-image-upload 
            name="logo"
            label="Company Logo"
            :preview="$setting->logo ?? null"
            col="col-md-4"
        />
        <x-image-upload 
            name="favicon"
            label="Company Favicon"
            :preview="$setting->favicon ?? null"
            col="col-md-4"
        />
       
    </div>

  

    <div class="mt-3">
        <button type="submit" class="btn btn-success">
            {{ isset($setting) ? 'Update Settings' : 'Create Settings' }}
        </button>
        <a href="{{ route('settings.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>
@endsection
