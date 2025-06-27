<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Prep By Chef | Chef Dashboard </title>
    <link rel="stylesheet" href="{{asset('public/frontend/chef-dashboard/vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}">        
    <link rel="icon" type="" sizes="16x16" href="{{asset('public/frontend/images/favicon.ico')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/backend/toastr.css') }}">
    <link href="{{asset('public/frontend/chef-dashboard/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/chef-dashboard/css/LionIcons.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/css/all.css')}}">
    <link rel="stylesheet" href="{{asset('public/frontend/chef-dashboard/vendor/toastr/css/toastr.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/chef-dashboard/css/custom.css')}}">
    <style>.error-help-block{color:red;}</style>
    <script> var BASEURL = '{{ url("/") }}/' </script>
    <!--   Step Process Dashboard -->
    
    @yield('pageCss')
</head>
<body>
	<div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!-- <a href="index.html" class="brand-logo">
                <img class="logo-abbr" src="./images/logo.png" alt="">
                <img class="logo-compact" src="./images/logo-text.png" alt="">
                <img class="brand-title" src="./images/logo-text.png" alt="">
            </a> -->
    <div id="main-wrapper">
        <div class="nav-header">
            <a href="#" class="brand-logo">
            <img class="logo-abbr" src="{{asset('public/frontend/images/logo-icon.png')}}" alt="">
            <img class="brand-title" src="{{asset('public/frontend/images/logo-text.png')}}" alt="">

            </a>
            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
            
        @include('frontend.chef-dashboard.layouts.chat')
        @include('frontend.chef-dashboard.layouts.header')
        @include('frontend.chef-dashboard.layouts.sidebar')
        @yield('content')           
    </div>
    @include('frontend.chef-dashboard.layouts.script')       
    @yield('pageScript')

</body>
</html>

