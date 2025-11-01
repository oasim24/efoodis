<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}">


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />



    {{-- Fonts & Icons --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Custom Styles --}}
    <style> 
    body{
        background-color: #ecf1efff;
        
    }
    .bg-white{
        background-color: white;
    }
    .btn-primary{
        background-color: green !important;
        border: none;
        color:white !important
    }
     .btn-secondary{
       background-color: white;
       border: none;
       color: black;
       font-weight: 700;
     }
     .btn-secondary:hover{
        background-color: white;
        color: black ;
        
     }
    .bg-primary{
        background-color: green !important;
        border: none;
        color: white !important
    }
    .text-white{
        color :white !important
    }
    .bg-secondary{
        background-color: #a5d4c0ff !important;
    }
    .border-primary{
        border-color: green !important;
       
    }
    </style>

 @stack('styles')

  </head>
<body>


   @include('frontend.layouts.partials.header')

    <div class="container-fluid">
            @yield('content')
    </div>
    @include('frontend.layouts.partials.fotter')



  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-zoom/1.7.21/jquery.zoom.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>



<script>
$(document).ready(function(){
  $(".product").owlCarousel({
    loop: true,
    margin: 15,
    autoplay: true,
    autoplayTimeout: 3000, // ৩ সেকেন্ড পর পর স্লাইড পরিবর্তন
    autoplayHoverPause: true, // হোভার করলে থেমে যাবে
    dots: true,
    nav: true,
    responsive:{
      0:{
        items:2
      },
      640:{
        items:3
      },
      768:{
        items:4
      },
      992:{
        items:5
      },
      1140:{
        items:6
      }
    }
  });
});
</script>




    @stack('scripts')
</body>
</html>
