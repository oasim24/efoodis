@extends('admin.layouts.app')

@section('title', isset($osinfo) ? 'Edit Brands' : 'Add Brands')

@section('content')

<form 
    action="{{ isset($osinfo) ? route('osinfos.update', $osinfo->id) : route('osinfos.store') }}" 
    method="POST" 
    enctype="multipart/form-data"
>
    @csrf
    @if(isset($osinfo))
        @method('PUT')
    @endif

    <div class="row">

    
        <x-input 
            name="value" 
            label="Value" 
            placeholder="Enter Value" 
            required="true" 
            col="col-md-4"
            :value="$osinfo->value ?? ''"
        />
        

       
       
    </div>

  

    <div class="mt-3">
        <button type="submit" class="btn btn-success">
            {{ isset($osinfo) ? 'Update settings' : 'Create Settings' }}
        </button>
        <a href="{{ route('settings.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>
@endsection
