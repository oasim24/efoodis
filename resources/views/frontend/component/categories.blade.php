
<style> 
.img {
    border-radius: 100%;
    border: 2px solid green ;
}
</style>

<h4 style="font-weight: 700;">Top Categories</h4>
<hr>
<div class="d-flex gap-3 align-items-center justify-content-center my-3">
    @foreach($category as $cat)
    <a href="{{route('categories', $cat->id)}}" class="text-decoration-none text-danger"> 
    <div class="d-flex align-items-center justify-content-center flex-column">
        <img src="{{asset($cat->image ?? 'assets/image/categories/category.png')}}" class="img" width="100px" height="100px" >
        <p class="text-black" >{{$cat->name}}</p>
    </div>
    </a>
    @endforeach
</div>