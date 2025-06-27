<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <title>Prep By Chef</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <meta name="format-detection" content="telephone=no">
        <meta name="keywords" content="">
        <meta name="description" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!--css styles starts-->
        <link rel="shortcut icon" type="image/x-icon" href="{{asset('public/frontend/images/favicon.ico')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/css/slick.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/css/all.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/css/style.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/css/responsive.css')}}" media="screen">
        
        <!--Toaster--->
        <link rel="stylesheet" type="text/css" href="{{asset('public/backend/toastr.css') }}">
        <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/css/jquery-ui.css') }}">
        <script> var BASEURL = '{{ url("/") }}/' </script>
        
        @yield('pageCss')
    </head>

    <body>
        <!--*******************
            Preloader start
        ********************-->
        <div id="preloader">
            <div class="sk-three-bounce">
                <div class="sk-child sk-bounce1"></div>
                <div class="sk-child sk-bounce2"></div>
                <div class="sk-child sk-bounce3"></div>
            </div>
        </div>
        <!--*******************
            Preloader end
        ********************-->
        <div class="wrapper">
            @if(auth('front')->check() && auth('front')->user()->type == "Customer")
                @include('frontend.layouts.customer-header')
            @else
                @include('frontend.layouts.header')
            @endif
            
            @yield('content')            
            @include('frontend.layouts.footer')            
        </div>
        @include('frontend.layouts.script')
        
    </body>
</html>