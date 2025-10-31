<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}">

    {{-- Fonts & Icons --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Custom Styles --}}
    <style> 
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
    </style>
  </head>
<body>


   @include('frontend.layouts.partials.header')

    <div class="container-fluid">
            @yield('content')
    </div>
    @include('frontend.layouts.partials.fotter')



  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>



    @stack('scripts')
</body>
</html>
