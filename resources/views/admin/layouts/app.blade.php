<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset($setting->favicon ?? 'assets/image/companies/favicon.png') }}">

    {{-- Fonts & Icons --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    {{-- Custom Styles --}}
  
<style>

 

#commonTable{
    width: 100%;
    border-radius: 15px;
    border: 1px solid black;
    overflow: hidden;
    border-bottom: none;
    border-left: none;
    border-right: none;
    margin-top: 15px;
}

#commonTable thead tr th {
    background-color: white;
    color: black;
}

#commonTable tbody tr:nth-child(odd) td {
    background-color: white;
    color: black;
    border-bottom: 1px solid black;
}
#commonTable tbody tr:nth-child(even) td {
    background-color: white;
    color: black;
    border-bottom: 1px solid black;
}

#commonTable_filter input{
     border: 1px solid red;
     border-radius: 10px;
}
#commonTable_filter input:focus {
    box-shadow: none;
    outline: none; 
}

    .container{
        width: 100%;
        height: auto;
        display: flex;
        margin-top: 50px;
    }
    .content{
        width: 85%;
        position: absolute;
        right: 0;
        padding: 10px;
  
        
        
    }



@media screen and (max-width: 768px) and (min-width: 425px) {
    .sidebar {
        display: none;
    }

    .content {
        width: 100%;
        
    }
}
    </style>
    @stack('styles')
</head>
<body class="bg-light text-dark">

    {{-- Top Navbar --}}
   @include('admin.layouts.partials.topbar')

    {{-- Sidebar --}}
    
    {{-- Main Content --}}
    <div class="container">
    @include('admin.layouts.partials.sidebar')
        <div class="content">
            @yield('content')
            @include('admin.layouts.partials.footer')
        </div>
    </div>

 
    {{-- Footer --}}

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#commonTable').DataTable();
    });
</script>

    @stack('scripts')
</body>
</html>
