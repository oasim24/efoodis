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
            <th>Stock</th>
            <th>Status</th>
            <th>Other</th>
            <th>Image</th>
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
            <td>{{ $product->stock }}</td>
            <td>
    <form action="{{ route('products.status', $product->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('PUT')

        <button type="submit" 
                class="btn btn-sm {{ $product->status ? 'btn-success' : 'btn-danger' }}">
            {{ $product->status ? 'Active' : 'Inactive' }}
        </button>
    </form>
</td>

<td>
    <form action="{{ route('products.hots', $product->id) }}" method="POST" style="display:inline;" >
        @csrf
        @method('PUT')
        <p>   Hot Product:
        <button type="submit" 
                class="btn btn-sm {{ $product->hot ? 'btn-success' : 'btn-danger' }}">
            {{ $product->hot ? 'Yes' : 'No' }}
        </button> </p>
    </form> 

   <form action="{{ route('products.features', $product->id) }}" method="POST" style="display:inline;" >
        @csrf
        @method('PUT')
        <p>  Feature Product:
        <button type="submit" 
                class="btn btn-sm {{ $product->feature ? 'btn-success' : 'btn-danger' }}">
            {{ $product->feature ? 'Yes' : 'No' }}
        </button> </p>
    </form> 
  <form action="{{ route('products.tops', $product->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('PUT')
          Top Selling Product:
        <button type="submit" 
                class="btn btn-sm {{ $product->top_sell ? 'btn-success' : 'btn-danger' }}">
            {{ $product->top_sell ? 'Yes' : 'No' }}
        </button>
    </form>

</td>


            <td> <img src="{{asset($product->thumbnail_image)}}" width="100" height="100" > </td>
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