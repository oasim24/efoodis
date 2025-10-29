@extends('admin.layouts.app')

@section('title', isset($product) ? 'Edit Product' : 'Add Product')

@section('content')

<form 
    action="{{ isset($product) ? route('products.update', $product->id) : route('products.store') }}" 
    method="POST" 
    enctype="multipart/form-data"
>
    @csrf
    @if(isset($product))
        @method('PUT')
    @endif

    <div class="row">
        <x-input 
            name="name" 
            label="Product Name" 
            placeholder="Enter product name" 
            required="true" 
            col="col-md-4"
            :value="$product->name ?? ''"
        />

        <x-select 
        name="category_id" 
        label="Categories" 
          :options="$categories" 
        :selected="$product->category_id ?? null" 
        :required="true" 
        col="col-md-4"
    />
        <x-select 
        name="brand_id" 
        label="Brands" 
          :options="$brands" 
        :selected="$product->brand_id ?? null" 
        :required="true" 
        col="col-md-4"
    />
        <x-input 
            name="old_price" 
            label="Old Price" 
            type="number" 
            placeholder="Enter old price"
            col="col-md-4"
            :value="$product->old_price ?? ''"
        />
        <x-input 
            name="new_price" 
            label="New Price" 
            type="number" 
            placeholder="Enter new price"
            required="true"
            col="col-md-4"
            :value="$product->new_price ?? ''"
        />
        <x-input 
            name="stock" 
            label="Stock" 
            type="number" 
            placeholder="Enter stock"
            required="true"
            col="col-md-4"
            :value="$product->stock ?? ''"
        />
      <x-editor 
        name="description"
        label="Product Description"
        placeholder="Write the full product details..."
        :required="false"
        col="col-md-12"
        :value=" $product->description  ?? ''"
    />
    </div>

    <div class="row">
        <x-image-upload 
            name="thumbnail_image"
            label="Thumbnail Image"
            :preview="$product->thumbnail_image ?? null"
            col="col-md-4"
        />

        <x-multi-image-upload 
            name="feature_image"
            label="Product Gallery"
            :existing="isset($product) && $product->feature_image ? json_decode($product->feature_image, true) : []"
            col="col-md-8"
            max="4"
        />
    </div>

    <div class="mt-3">
        <button type="submit" class="btn btn-success">
            {{ isset($product) ? 'Update Product' : 'Create Product' }}
        </button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>
@endsection
