@extends('frontend.layouts.master')

@section('content')
<div class="container_xxl  ">
        <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-light p-3 rounded-3">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#">Categories</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ $cats->name }}
            </li>
        </ol>
    </nav>
<div class="row ">
    <div class="col-md-3">
        <h5 class="mb-3">Categories</h5>
                <ul class="list-group mb-4">
                    @foreach($categories as $cat)
                        <li class="list-group-item {{ $id == $cat->id ? 'active' : '' }}">
                            <a href="{{ route('categories', $cat->id) }}" 
                               class="{{ $id == $cat->id ? 'text-white' : 'text-dark' }}"
                               style="text-decoration: none;">
                                {{ $cat->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
    {{-- 💰 Price Range Filter --}}
<form action="{{ route('categories', $id) }}" method="GET" class="mb-4">
    <div class="mb-3">
        <label for="priceRange" class="form-label">
            Price Range: <strong>৳<span id="rangeValue">{{ request('max_price', $maxPrice) }}</span></strong>
        </label>

        <input 
            type="range" 
            name="max_price" 
            id="priceRange"
            class="form-range"
            min="{{ $minPrice }}" 
            max="{{ $maxPrice }}" 
            value="{{ request('max_price', $maxPrice) }}"
            step="1">
    </div>

    {{-- Hidden input for min price --}}
    <input type="hidden" name="min_price" value="{{ $minPrice }}">

    <button type="submit" class="btn btn-sm btn-primary w-100">Apply</button>
</form>

<p class="text-muted small text-center">
    Showing products between 
    <strong>৳{{ $minPrice }}</strong> and 
    <strong>৳<span id="showValue">{{ request('max_price', $maxPrice) }}</span></strong>
</p>

{{-- JS অংশ --}}
<script>
    const priceRange = document.getElementById('priceRange');
    const rangeValue = document.getElementById('rangeValue');
    const showValue = document.getElementById('showValue');

    priceRange.addEventListener('input', function() {
        rangeValue.textContent = this.value;
        showValue.textContent = this.value;
    });
</script>


        <span>Rating Filter</span>

    </div>


<div class="col-md-9">
    @if($cats->products->count() > 0)
        <div class="row">
         @include('frontend.component.product_cart2', ['products' => $cats->products])
        </div>
    @else
        <p class="text-muted text-center">এই ক্যাটাগরিতে কোনো প্রোডাক্ট নেই।</p>
    @endif
</div>

</div>
</div>
@endsection
