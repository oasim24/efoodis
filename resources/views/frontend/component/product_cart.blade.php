<style>
.cart {
    border: 1px solid green;
    padding: 5px;
    position: relative;
}
.product_img{
    width: 100%;
    height: 150px;
    overflow: hidden;
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
</style>
<div class="d-flex align-items-center justify-content-center gap-3">
    @foreach($products as $product)
    <div class="d-flex align-items-center justify-content-center flex-column cart">
        <span class="dis bg-primary" > 10% </span>
        <div class="product_img">

            <img src="{{asset($product->thumbnail_image)}}">
        </div>
        <p class="m-0 my-1 ">{{$product->name}}</p>
        <span> <del>৳{{$product->old_price}}</del> ৳{{$product->new_price}}</span>
        <button class="btn btn-primary py-1 w-100 mt-2">Add To Cart</button>
    </div>
    @endforeach
</div>