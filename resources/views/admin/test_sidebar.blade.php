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
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper" id="app" v-cloak>
      <!-- Main Header -->
      @include('admin.header')

      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">          

          <!-- search form (Optional) -->
          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search...">
                  <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                  </span>
            </div>
          </form>
          <!-- /.search form -->

          <!-- Sidebar Menu -->
          <ul class="sidebar-menu">
            <li class="header">HEADER</li>
            <!-- Optionally, you can add icons to the links -->
            <li>
              <router-link to="/dashboard" exact><i class="fa fa-link"></i> <span>Link</span></router-link>
            </li>
            <li>
                <router-link to="/about"><i class="fa fa-table" aria-hidden="true"></i>About</router-link>
            </li>
            <li>
                <router-link><i class="fa fa-font fa-fw" aria-hidden="true"></i>Icons</router-link>
            </li>
            <li>
              <a href="#"><i class="fa fa-link"></i> <span>Another Link</span></a>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-user"></i> <span>User</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                 <li>
                    <router-link to="/profile">
                        <i class="fa fa-address-card fa-fw" aria-hidden="true"></i>
                        Profile
                    </router-link> 
                </li>
                <li> 
                    <router-link to="/roles">
                        <i class="fa fa-plus fa-fw" aria-hidden="true"></i>
                        Set Roles
                    </router-link>
               </li>
                <li>
                    <router-link to="/staff-list">
                        <i class="fa fa-address-book-o fa-fw" aria-hidden="true"></i>
                        Admin Staff
                    </router-link>
                </li>                  
                <li><a href="#">Link in level 2</a></li>
                <li><a href="#">Link in level 2</a></li>
              </ul>
            </li>
          </ul>
          <!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Page Header
            <small>Optional description</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
            <li class="is-active">Here</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

          <!-- Your Page Content Here -->
          <router-view></router-view> 

        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->

      <!-- Main Footer -->
      <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
          Anything you want
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2016 <a href="#">Company</a>.</strong> All rights reserved.
      </footer>

      <!-- Control Sidebar -->
      @include('admin.control_sidebar')
    </div>
    <!-- ./wrapper -->
    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/admin/app.min.js') }}"></script>
    {{-- <script>
        $(document).ready(function(){
            $("button#btn-menu").click(function(){            
                $("#page-wrapper").toggleClass("add-top-margin");
            });            
        });
    </script> --}}
    @yield('scripts')    
</body>
</html>
