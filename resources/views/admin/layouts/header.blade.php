
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{$title}} </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="shortcut icon" type="image/x-icon" href="{{asset('public/frontend/images/favicon.ico')}}">
  <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{asset('public/backend/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('public/backend/bower_components/font-awesome/css/font-awesome.min.css')}}">
  
  <!-- Datatable Css-->
  <link rel="stylesheet" href="{{asset('public/backend/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
  
  <!-- Respponsive Datatable -->
  <link rel="stylesheet" href="{{asset('public/backend/common/responsive.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/backend/common/rowReorder.dataTables.min.css')}}">
  <!--end-->

  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('public/backend/dist/css/AdminLTE.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/backend/css/custom.css')}}">
  
  <!-- AdminLTE Skins. Choose a skin from the css/skins
   folder instead of downloading all of them to reduce the load. -->
   <link rel="stylesheet" href="{{asset('public/backend/dist/css/skins/_all-skins.min.css')}}">

   <!--Toaster--->
   <link rel="stylesheet" type="text/css" href="{{asset('public/backend/toastr.css') }}">
   
   <!-- Toogle Button -->
   <link href="{{asset('public/backend/bootstrap-toggle.min.css') }}" rel="stylesheet">
     
   
   <style type="text/css">
    .display-none
    {
      display: none;
    }
   .pagination > li > a,
    .pagination > li > span {
      color: orange; // use your own color here
    }

    .pagination > .active > a,
    .pagination > .active > a:focus,
    .pagination > .active > a:hover,
    .pagination > .active > span,
    .pagination > .active > span:focus,
    .pagination > .active > span:hover {
      background-color: #ffc200;
      border-color: #ffc200;
    }
  </style> 
  @yield('pageCss')
  <!-- Google Font -->
  <link rel="stylesheet"
  href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <script> var BASEURL = '{{ url("/admin") }}/'</script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <header class="main-header">
      <!-- Logo -->
      <a href="{{route('dashboard')}}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><img src="{{asset('public/frontend/images/favicon.ico')}}"></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><img src="{{asset('public/frontend/images/logo.png')}}"></span>
      </a>
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- Messages: style can be found in dropdown.less-->
            <!-- User Account: style can be found in dropdown.less -->
           <!--  <li class="dropdown notifications-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bell-o"></i>
                <span class="label label-warning">
                  

                </span>
              </a>
              <ul class="dropdown-menu">
                <li class="header"></li>
                <li>
                  inner menu: contains the actual data
                  <ul class="menu">
                    

                    
                    <li>
                      <a href="">
                        <i class="fa fa-child text-aqua"></i> Take <b> </b>Follow up</a> 
                    </li>
                    
                    
                    
                  </ul>
                </li>
              </ul>
            </li> -->
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="{{Session::get ('admin_profile')}}" class="user-image" alt="User Image">
                <span class="hidden-xs">{{Session::get ('admin_name')}}</span>
              </a>
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                  <img src="{{Session::get ('admin_profile')}}" class="user-image" alt="User Image">
                  <p>{{Session::get ('admin_name')}}</p>
                </li>

                <!-- Menu Footer-->
                <li class="user-footer">
                 <div class="pull-left">
                  <a href="{{ route('profile') }}" class="btn btn-primary">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="{{ route('logout') }}" class="btn btn-primary">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <!-- <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li> -->
        </ul>
      </div>
    </nav>
  </header>