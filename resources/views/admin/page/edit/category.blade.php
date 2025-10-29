@extends('admin.layouts.app')

@section('title', isset($cat) ? 'Edit Categories' : 'Add Categories')

@section('content')

<form 
    action="{{ isset($cat) ? route('categories.update', $cat->id) : route('categories.store') }}" 
    method="POST" 
    enctype="multipart/form-data"
>
    @csrf
    @if(isset($cat))
        @method('PUT')
    @endif

    <div class="row">

     <x-select 
        name="parent_id" 
        label="Parent Categories" 
          :options="$categories" 
        :selected="$cat->parent_id ?? null" 
        :required="false" 
        col="col-md-4"
    />
        <x-input 
            name="name" 
            label="Categories Name" 
            placeholder="Enter categories name" 
            required="true" 
            col="col-md-4"
            :value="$cat->name ?? ''"
        />
        

        <x-image-upload 
            name="image"
            label="Categories Image"
            :preview="$cat->image ?? null"
            col="col-md-4"
        />
       
    </div>

  

    <div class="mt-3">
        <button type="submit" class="btn btn-success">
            {{ isset($cat) ? 'Update Categories' : 'Create Categories' }}
        </button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>
@endsection
