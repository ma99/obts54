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
     
      <link href="{{ asset('css/bootstrap-datepicker.css') }}" rel="stylesheet">
      {{-- <link href="{{ asset('css/admin-style.css') }}" rel="stylesheet"> --}}
      <link href="{{ asset('css/app.css') }}" rel="stylesheet">
      <link href="{{ asset('css/admin/AdminLTE.css') }}" rel="stylesheet">
      <link href="{{ asset('css/admin/skins/skin-blue.css') }}" rel="stylesheet">
      
      
      <style>
        [v-cloak] {
          display: none;
        }
      </style>

      <!-- {{-- <script>
          window.Laravel = {!! json_encode([
              'csrfToken' => csrf_token(),
          ]) !!};
      </script> --}} -->
      
  </head>
  <!-- Static Top -->
  {{-- <body class="hold-transition skin-blue sidebar-mini"> --}}
  <!-- Fixed Top -->
  <body class="hold-transition skin-blue sidebar-mini fixed">
      <div class="wrapper" id="app" v-cloak>
        <!-- Main Header -->
        @include('admin.header')
        
        <!-- Left side column. contains the logo and sidebar -->
        @include('admin.sidebar')      

        <!-- Content Wrapper. Contains page content --> 
        @include('admin.content-page')            

        <!-- Main Footer -->
        @include('admin.footer')

        <!-- Control Sidebar -->
        @include('admin.control_sidebar')
      </div>
      <!-- ./wrapper -->
      
      <!-- Scripts -->
      {{-- <script src="{{ asset('js/slimscroll/jquery.slimscroll.min.js') }}"></script>  --}}    
      <script src="{{ asset('js/app.js') }}"></script>     
      <script src="{{ asset('js/admin/app.min.js') }}"></script>
     
      @yield('scripts')    
  </body>
</html>
