<style>
.ullist{
    list-style-type: none;
}
.ullist li a{
    text-decoration: none;
    color: black;
}

.pp{
    font-weight: 700;

}
    </style>

<div class="container-fluid bg-secondary mt-3">
<div class="container py-3">
<div class="row ">
    <div class="col-md-3">
        <img src="{{asset($setting->logo)}}" width="200px" height="50px">
        <p class="m-0 mb-1">{{$setting->phone}}</p>
        <p class="m-0 mb-1">{{$setting->email}}</p>
        <p class="m-0 mb-1">{{$setting->address}}</p>
    </div>
    <div class="col-md-3 col-6">
        <p class="pp">Usefull Link</p>
        <ul class="ullist">
            <li><a href="#">Contact Us</a></li>
            <li><a href="#">Order Process</a></li>
            <li><a href="#"> Deliveray Rulls </a></li>
        </ul>
    </div>
    <div class="col-md-3 col-6">
        <p class="pp">Other Link</p>
        <ul class="ullist">
            <li><a href="#">All Products</a></li>
            <li><a href="#">Return Policy</a></li>
            <li><a href="#">Terams & Conditions</a></li>
            <li><a href="#">Privacy Policy</a></li>
        </ul>
    </div>
    <div class="col-md-3"></div>
</div>
</div>
</div>
<div class="bg-primary text-center py-2 text-white">
Copyright © 2025 {{$setting->name}}. All rights reserved | Website Designed by: <a href="https://softrang.com/" class="text-decuration-none text-danger">softrang</a>
</div>