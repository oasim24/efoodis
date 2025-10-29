@extends('admin.layouts.app')

@section('title', 'Home Page')

@section('content')
<div class="d-flex my-3 align-items-center justify-content-between">
    <nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Brands</li>
  </ol>
</nav>
    <a href="{{route('brands.create')}}" class="btn btn-primary">Create</a>

</div>

<table id="commonTable">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
          
            <th>Image</th>
            <th>action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($brands as $index => $brand)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $brand->name }}</td>
            <td>
 @if($brand->image)
                                <img src="{{ asset($brand->image) }}" alt="{{ $brand->name }}" width="70" height="70" class="rounded border me-2">
                            @else
                                <span class="text-muted">No image</span>
                            @endif

            </td>
            
            <td>
   
    <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-sm btn-primary">
        Edit
    </a>

  
    <form action="{{ route('brands.delete', $brand->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this product?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger">
            Delete
        </button>
    </form>
</td>

        </tr>
        @endforeach
        @if($brands->isEmpty())
        <tr>
            <td colspan="4" class="text-center text-muted">No Brands found.</td>
        </tr>
        @endif
    </tbody>
</table>

    
@endsection