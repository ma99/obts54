<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
   
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
   
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-datepicker.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('css/admin-style.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    
    
    <style>
      [v-cloak] {
        display: none;
      }
    </style>    
</head>
<body class="skin-blue">
    <div id="app" v-cloak>
        @include ('admin.nav')        
        
        <!-- Page Content -->        
        <div id="page-wrapper">
            welcome to home page of obts
            <router-view></router-view> 
        </div>          

    </div> 
    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        $(document).ready(function(){
            $("button#btn-menu").click(function(){            
                $("#page-wrapper").toggleClass("add-top-margin");
            });            
        });
    </script>
    @yield('scripts')    
</body>
</html>
