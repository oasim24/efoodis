@extends('admin.layouts.app')

@section('title', 'Home Page')

@section('content')
<div class="d-flex my-3 align-items-center justify-content-between">
    <nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Products</li>
  </ol>
</nav>
    <a href="{{route('products.create')}}" class="btn btn-primary">Create</a>

</div>

<table id="commonTable">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Product Code</th>
            <th>Price</th>
            <th>action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $index => $product)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->code }}</td>
            <td>${{ number_format($product->old_price, 2) }}</td>
            <td>
   
    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-primary">
        Edit
    </a>

  
    <form action="{{ route('products.delete', $product->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this product?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger">
            Delete
        </button>
    </form>
</td>

        </tr>
        @endforeach
        @if($products->isEmpty())
        <tr>
            <td colspan="4" class="text-center text-muted">No products found.</td>
        </tr>
        @endif
    </tbody>
</table>

    
@endsection