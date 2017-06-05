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

    <!-- {{-- <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script> --}} -->
    
</head>
<body class="skin-blue">
    <div id="app" v-cloak>
        <!-- <nav class="navbar navbar-default navbar-static-top"> -->
       <!--  {{-- <nav class="navbar navbar-inverse navbar-fixed-top">         --}} -->
        <nav class="navbar navbar-default navbar-fixed-top">        
          <div class="container-fluid">
            <div class="navbar-header">
                <!-- Collapsed Hamburger -->
                <button type="button" id="btn-menu" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image/Logo -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
            </div>
            <!-- /.navbar-header -->
                 

            <!-- Right Side Of Navbar -->
            <ul id="topbar" class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                   <i class="fa fa-sign-out fa-fw"></i> Logout 
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>   
                <!-- <div class="collapse navbar-collapse" id="app-navbar-collapse">
                   
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>                    
                </div> -->
                
            <!-- ============================================================== -->
            <!-- Left Side Of Navbar -->
            <sidebar></sidebar>
            <!-- ============================================================== -->
            <!-- End Left Sidebar -->    
          </div>
        </nav>
        <!-- ============================================================== -->
        <!-- Page Content -->
        <!-- ============================================================== -->
        <div id="page-wrapper">
            welcome to home page of obts
            <router-view></router-view> 
        </div>
        <!-- /#page-wrapper -->           
    </div> 
    <!-- /#app -->
    <!-- <footer class="footer text-center"> 2017 &copy; Ample Admin brought to you by wrappixel.com </footer> -->

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
