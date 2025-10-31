
<style> 
.img {
    border-radius: 100%;
    border: 2px solid green ;
}
</style>

<span style="font-weight: 700;">Top Categories</span>
<hr>
<div class="d-flex gap-3 align-items-center justify-content-center my-3">
    @foreach($category as $cat)
    <a href="#" class="text-decoration-none text-danger"> 
    <div class="d-flex align-items-center justify-content-center flex-column">
        <img src="{{asset($cat->image)}}" class="img" >
        <p class="text-black" >{{$cat->name}}</p>
    </div>
    </a>
    @endforeach
</div>