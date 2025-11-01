@extends('frontend.layouts.master')

@section('title', 'Home Page')
@push('styles')
<style>
.product-gallery {
  position: relative;
}

#product-thumb-slider .item {
  padding: 5px;
}

#product-thumb-slider .img-thumbnail {
  border: 2px solid transparent;
  transition: 0.3s;
}

#product-thumb-slider .active-thumb img {
  border-color: #007bff;
}

.zoom-img {
  transition: transform 0.4s;
}
.zoom-img:hover {
  transform: scale(1.05);
}

.active-tab {
    background-color: #0dcaf0; /* Bootstrap info color */
    color: white !important;
}


@media (max-width: 768px) {
  .zoom-img {
    max-height: 250px;
  }
}


.ribbon {
  font-size: 15px;
  font-weight: bold;
  color: #fff;
  display: inline-block;
}
.ribbon {
  --r: .8em; 
  
  border-block: .5em solid #0000;
  padding-inline: .6em calc(var(--r) + .25em);
  line-height: 1.8;
  clip-path: polygon(100% 0,0 0,0 100%,100% 100%,100% calc(100% - .25em),calc(100% - var(--r)) 50%,100% .25em);
  background:
   radial-gradient(.2em 50% at left,#000a,#0000) border-box,
   #03a032ff padding-box; 
  width: fit-content;
}





.ribbon2 {
  --r: 0.8em; 
  
  display: inline-block;
  font-size: 15px;
  font-weight: bold;
  color: #fff;
  background: #45ada8;
  padding: 0 1em;
  padding-right: calc(var(--r) + 1em);
  line-height: 1.8;

 
  clip-path: polygon(
    0 0,
    calc(100% - var(--r)) 0,
    100% 50%,
    calc(100% - var(--r)) 100%,
    0 100%
  );
}



.ribbon3 {
  --r: 0.8em; 

  display: inline-block;
  font-size: 18px;
  font-weight: bold;
  color: #fff;
   background-image: linear-gradient(145deg, #05b12aff, #9c264fff);
  padding: 0 1em;
  padding-left: calc(var(--r) + 1em);
  line-height: 1.8;
  width: fit-content;


  clip-path: polygon(
    0 50%,               
    var(--r) 0,         
    100% 0,              
    100% 100%,           
    var(--r) 100%,       
    0 50%               
  );
}


.ribbon4 {
  --s: 1.8em; 
  --d: 0.8em;  
  --c: 0.8em;  

  display: inline-block;
  font-size: 18px;
  font-weight: bold;
  color: #fff;
  line-height: 1.8;
  background-color: #0ab443ff;
  padding: 0 1.5em 0 calc(var(--s) + 1em);
  width: fit-content;
  position: relative;


  clip-path: polygon(
    var(--s) 0,
    100% 0,
    calc(100% - var(--c)) 50%,
    100% 100%,
    var(--s) 100%,
    0 calc(100% - var(--d)),
    0 var(--d)
  );


  background-image: linear-gradient(145deg, #05b15bff, #8b0f3a);
  box-shadow: 2px 4px 8px rgba(0, 0, 0, 0.3);
}



</style>
@endpush
@section('content')
<div class="row mt-4">
    <div class="col-md-6 col-12">
        @php
            
            $thumbnail = $product->thumbnail_image;
           
            $images = json_decode($product->feature_image, true) ?? [];
           
            array_unshift($images, $thumbnail);
        @endphp

        <div class="product-gallery">
           
            <div class="owl-carousel owl-theme" id="product-main-slider">
                @foreach($images as $img)
                    <div class="item text-center">
                        <img class="img-fluid zoom-img" 
                             style="object-fit:contain; max-height:300px; width:100%;" 
                             src="{{ asset($img) }}" alt="Product Image">
                    </div>
                @endforeach
            </div>

           
            <div class="owl-carousel mt-3" id="product-thumb-slider">
                @foreach($images as $img)
                    <div class="item text-center">
                        <img class="img-thumbnail" 
                             src="{{ asset($img) }}" 
                             alt="Thumb"
                             style="max-height:80px; cursor:pointer; object-fit:contain; width:auto;">
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-md-6 col-12 mt-4 mt-md-0">
        <h3>{{ $product->name }}</h3>
        <h4>
            <del class="text-muted">৳{{ $product->old_price }}</del> 
            <span class="fw-bold text-danger">৳{{ $product->new_price }}</span>
</h4>
<div class="ribbon">Product Code</div>
       <div class="ribbon4">{{ $product->code }}</div><br>
<div class="ribbon2">Category </div> 
      <div class="ribbon3">{{$product->category->name}}</div>
        <div class="d-flex align-items-center mt-3">
            <button id="minusQty" class="btn btn-outline-secondary px-3">-</button>
            <input id="qty" type="text" readonly class="form-control text-center mx-2" value="1" style="width:50px;">
            <button id="plusQty" class="btn btn-outline-secondary px-3">+</button>
        </div>

        
        <div class="d-flex gap-3 mt-3">
            <button id="add-to-cart" class="btn btn-primary w-100">Add To Cart</button>
            <button id="order-now" class="btn btn-danger w-100">Order Now</button>
        </div>

        <div class="d-flex gap-3 mt-3">
            <a href="tel:{{ $setting->phone }}" class="btn btn-info w-100">
                Call Now {{ $setting->phone }}
            </a>
            <a href="https://wa.me/{{ $setting->phone }}" target="_blank" class="btn btn-success w-100">
                WhatsApp Now
            </a>
        </div>
    </div>
</div>

<div class="bg-white">
    <div class="d-flex gap-2  px-3 py-3">
        <button id="description" class="btn btn-outline-info active-tab">Description</button>
        <button id="review" class="btn btn-outline-success">Review</button>
    </div>

    <div id="description_open" class="w-100 bg-body p-3 border rounded">
        {!! $product->description !!}
    </div>

    <div id="review_open" class="w-100 bg-light p-3 border rounded" style="display: none;">
        <p>This is the product review section. Customers can see or add reviews here.</p>
    </div>
</div>


@if(!empty($relatedProducts) && $relatedProducts->count() > 0)
 @include('frontend.component.headline', [
        'title' => 'Related Products',
        'link_title' => 'View More',
        'link' => '#'
    ])
@include('frontend.component.product_cart', ['products' => $relatedProducts])
@endif


@push('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-zoom/1.7.21/jquery.zoom.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script>
$(document).ready(function(){

  // Main & Thumb Owl Carousel Init
  var mainSlider = $("#product-main-slider");
  var thumbSlider = $("#product-thumb-slider");

  mainSlider.owlCarousel({
    items:1,
    loop:true,
    nav:false,
    dots:false,
    autoplay:true,
    autoplayTimeout:3000,
    smartSpeed:800
  }).on('changed.owl.carousel', syncPosition);

  thumbSlider.owlCarousel({
    items:4,
    margin:5,
    dots:false,
    nav:false,
    responsive:{
      0:{ items:3 },
      576:{ items:4 },
      768:{ items:5 }
    }
  }).on('click', '.item', function() {
      var index = $(this).index();
      mainSlider.trigger('to.owl.carousel', [index, 300, true]);
  });

  function syncPosition(event){
    var index = event.item.index - event.relatedTarget._clones.length / 2;
    var count = event.item.count;
    index = ((index % count) + count) % count;
    thumbSlider.find(".owl-item").removeClass("active-thumb").eq(index).addClass("active-thumb");
  }

  // Quantity Plus/Minus
  $('#plusQty').on('click', function() {
      var qty = parseInt($('#qty').val());
      $('#qty').val(qty + 1);
  });

  $('#minusQty').on('click', function() {
      var qty = parseInt($('#qty').val());
      if(qty > 1) $('#qty').val(qty - 1);
  });

  // Add to Cart Button
  $('#add-to-cart').on('click', function(){
      let qty = $('#qty').val();
      alert('🛒 Added ' + qty + ' item(s) to your cart!');
      // Ajax Request করতে পারো এখানে যদি চাও
      // $.post('/add-to-cart', {product_id: {{ $product->id }}, qty: qty});
  });

  // Order Now Button
  $('#order-now').on('click', function(){
      let qty = $('#qty').val();
      alert('🚀 Proceeding to Order with quantity: ' + qty);
      // Redirect বা Checkout লজিক এখানে যোগ করো
      // window.location.href = '/checkout?product_id={{ $product->id }}&qty=' + qty;
  });

});
</script>
<script>
$(document).ready(function () {
    // When "Description" button clicked
    $('#description').on('click', function () {
        $('#description_open').show();
        $('#review_open').hide();

        // Update button styles
        $('#description').addClass('active-tab');
        $('#review').removeClass('active-tab');
    });

    // When "Review" button clicked
    $('#review').on('click', function () {
        $('#review_open').show();
        $('#description_open').hide();

        // Update button styles
        $('#review').addClass('active-tab');
        $('#description').removeClass('active-tab');
    });
});
</script>
@endpush
@endsection
