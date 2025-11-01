<style> 
/* Header general style */
.header-links a {
    color: #333;
    text-decoration: none;
    font-weight: 500;
}

.header-links a:hover {
    color: #0d6efd;
}

/* Search box */
.search-input {
    padding-right: 45px; /* space for search icon */
}

.search-btn {
    background: transparent;
    border: none;
    color: #555;
    font-size: 1.2rem;
    padding-right: 10px;
}

.search-btn:hover {
    color: #0d6efd;
}

/* Responsive tweaks */
@media (max-width: 768px) {
    .header-links {
        display: flex;
        justify-content: center;
        gap: 10px;
        flex-wrap: wrap;
    }
    .search-input {
        font-size: 0.9rem;
    }
    .search-btn {
        font-size: 1rem;
    }
}

.menu {
  list-style: none;
  margin: 0;
  padding: 0;
}

.menu li {
  position: relative;
}

.menu .submenu {
  display: none;
  position: absolute;
  top: 100%;
  left: -30%;
  background: green;
  list-style: none;
  padding: 10px 0;
  margin: 0;
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
  min-width: 100px;
  z-index: 10;
}


.menu li:hover > .submenu {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
}
.scrolling-text {
 
  overflow: hidden;
  white-space: nowrap;
 
 
  font-weight: 600;
  font-size: 1rem;
  padding: 10px 0;
  position: relative;
}

.scroll-content {
  display: block;
  padding-left: 100vh; 
  animation: scroll-text 20s linear infinite;
}


@keyframes scroll-text {
  0% {
    transform: translateX(0);
  }
  100% {
    transform: translateX(-50%);
  }
}



</style>
<div class="container-fluid">
<div class="row">


 <a href="tel:+8801828509632"  class="btn btn-secondary col-md-2">+8801828509632</a>
<div class="scrolling-text col-md-10 bg-primary">
   
  <div class="scroll-content">
    🛒 Big Sale! Up to 50% OFF on Electronics — 🎉 Free Shipping on Orders over $99 — 🚀 New Arrivals in Fashion! 
    🛒 Big Sale! Up to 50% OFF on Electronics — 🎉 Free Shipping on Orders over $99 — 🚀 New Arrivals in Fashion!
  </div>
</div>
</div>
</div>

<div class="container py-3">



    <div class="row align-items-center gy-3">
        
       
        <div class="col-12 col-md-3 text-center text-md-start">
           <a href="{{route('home')}}">  <img src="{{ asset($setting->logo ?? '') }}" alt="Logo"> </a>
        </div>

        
        <div class="col-12 col-md-6">
            <form class="d-flex position-relative">
                <input type="search" class="form-control search-input" placeholder="Search Product by Name" aria-label="Search">
                <button type="submit" class="btn search-btn btn-primary position-absolute end-0 top-0 bottom-0">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>

       
        <div class="col-12 col-md-3">
            <ul class="list-inline text-center text-md-end mb-0 header-links">
                <li class="list-inline-item"><a href="#">Track Order</a></li>
                <li class="list-inline-item"><a href="#">Login</a>/<a href="#">Sign Up</a></li>
                <li class="list-inline-item">
                    <a href="#"><i class="bi bi-cart3 fs-5"></i></a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="bg-primary text-white d-flex align-items-center justify-content-center">
    <ul class="list-unstyled d-flex gap-3 m-0 menu" >
        @foreach($category as $cat)
        <li class="py-2"><a href="#" class="text-white text-decoration-none w-100">{{$cat->name}}</a>
         @if($cat->children->isNotEmpty())
         <i class="bi bi-box"></i>
        <ul class="list-unstyled submenu">
             @foreach($cat->children as $child)
            <li class="py-1 "><a href="#" class="text-white text-decoration-none w-100" >{{$child->name}}</a></li>
            @endforeach
         </ul>
         @endif
    </li>

        @endforeach
    </ul>
</div>