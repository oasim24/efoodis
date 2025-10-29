@extends('admin.layouts.app')

@section('title', 'Home Page')

@section('content')
    <div class="d-flex my-3 align-items-center justify-content-between">
    <nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Categories</li>
  </ol>
</nav>
    <a href="{{route('categories.create')}}" class="btn btn-primary">Create</a>

</div>
<table id="commonTable">
    <thead class="table-dark">
        <tr>
            <th style="width: 50px;">#</th>
            <th>Main Category</th>
            <th>Sub Categories</th>
        </tr>
    </thead>
    <tbody>
        @forelse($category as $index => $cat)
            <tr>
                
                <td>{{ $index + 1 }}</td>

             
                <td style="width: 200px;">
                    <div class="d-flex align-items-center">
                        <div>
                            @if($cat->image)
                                <img src="{{ asset($cat->image) }}" alt="{{ $cat->name }}" width="70" height="70" class="rounded border me-2">
                            @else
                                <span class="text-muted">No image</span>
                            @endif
                        </div>
                        <div>
                            <strong>{{ $cat->name }}</strong><br>
                            <a href="{{ route('categories.edit', $cat->id) }}" class="btn btn-sm btn-primary mt-1">Edit</a>
                            <form action="{{ route('categories.delete', $cat->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this main category?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger mt-1">Delete</button>
                            </form>
                        </div>
                    </div>
                </td>

              
                <td>
                    @if($cat->children->isNotEmpty())
                        <div class="d-flex flex-wrap">
                            @foreach($cat->children as $child)
                                <div class="border rounded p-2 me-2 mb-2" style="width:180px;">
                                    <div class="text-center mb-1">
                                        @if($child->image)
                                            <img src="{{ asset($child->image) }}" alt="{{ $child->name }}" width="60" height="60" class="rounded border">
                                        @else
                                            <span class="text-muted small">No image</span>
                                        @endif
                                    </div>
                                    <div class="text-center">
                                        <strong>{{ $child->name }}</strong><br>
                                        <a href="{{ route('categories.edit', $child->id) }}" class="btn btn-sm btn-outline-primary mt-1">Edit</a>
                                        <form action="{{ route('categories.delete', $child->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this subcategory?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger mt-1">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <span class="text-muted">No subcategories</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="text-center text-muted">No categories found.</td>
            </tr>
        @endforelse
    </tbody>
</table>









@endsection