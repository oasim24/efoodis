<style>
.cart {
    border: 1px solid green;
    padding: 5px;
    position: relative;
    background-color: white;
    
}
.product_img{
    width: 100%;
    height: max-content;
    overflow: hidden;
}

.product_img img {
   width: 100%;
   height: 100%;

}
.product_img img:hover {
    transform: scale(1.2);
    transition: all 0.5s ease-in-out;

}
.dis{
    width: 50px;
    height: 50px;
    position: absolute;
    right: 0;
    top: 0;
    border-bottom-left-radius: 100%;
    display: flex;
    align-items: center;
    justify-content: end;
    z-index: 11111;
    padding: 5px;
    
}

del{
    font-size: 15px;
    color: red;
}
.price{
    font-size: 20px;
    font-weight: 500;
}

a{
    text-decoration: none;
    color: black;
}
a:hover{
    color: black;
}
</style>

<div class=" row m-0 p-0">
    @foreach($products as $product)
<a href="{{route('product.details', $product->slug)}}" class="col-md-3" >
    <div class="d-flex align-items-start justify-content-start flex-column cart">
        @php
    $discount = 0;
    if ($product->old_price > 0) {
        $discount = round((($product->old_price - $product->new_price) / $product->old_price) * 100);
    }
@endphp
    
    <span class="dis bg-primary">{{$discount}}%</span>
        <div class="product_img">
            <img src="{{ asset($product->thumbnail_image ?? 'assets/image/products/product.png') }}" alt="{{ $product->name }}">
        </div>
         <p class="m-0 my-1 text-start">{{ $product->name }}</p>
        <span>
            <del>৳{{ $product->old_price }}</del> <span class="price"> ৳{{ $product->new_price }}</span>
        </span>
        <button 
            class="btn btn-sm btn-primary py-1 w-100 mt-2 addToCartBtn"
            data-id="{{ $product->id }}"
            data-name="{{ $product->name }}"
            data-price="{{ $product->new_price }}"
            data-image="{{ asset($product->thumbnail_image) }}"
            data-quantity="1">
            Add To Cart
        </button>
    </div>
    </a>
    @endforeach
</div>


