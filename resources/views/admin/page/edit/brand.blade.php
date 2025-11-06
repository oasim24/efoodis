@extends('admin.layouts.app')

@section('title', isset($brand) ? 'Edit Brands' : 'Add Brands')

@section('content')

<form 
    action="{{ isset($brand) ? route('brands.update', $brand->id) : route('brands.store') }}" 
    method="POST" 
    enctype="multipart/form-data"
>
    @csrf
    @if(isset($brand))
        @method('PUT')
    @endif

    <div class="row p-0 m-0">

    
        <x-input 
            name="name" 
            label="Brands Name" 
            placeholder="Enter Brands name" 
            required="true" 
            col="col-md-4"
            :value="$brand->name ?? ''"
        />
        

        <x-image-upload 
            name="image"
            label="Brands Image"
            :preview="$brand->image ?? null"
            col="col-md-4"
        />
       
    </div>

  

    <div class="mt-3">
        <button type="submit" class="btn btn-success">
            {{ isset($brand) ? 'Update Brands' : 'Create Brands' }}
        </button>
        <a href="{{ route('brands.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>
@endsection
