<head>
        <title>Home Chef</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <meta name="format-detection" content="telephone=no">
        <meta name="keywords" content="">
        <meta name="description" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!--css styles starts-->
        
        <link rel="shortcut icon" type="image/x-icon" href="{{asset('public/frontend/images/favicon.png')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/css/slick.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/css/all.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/css/style.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/css/responsive.css')}}" media="screen">
        <!--Toaster--->
        <link rel="stylesheet" type="text/css" href="{{asset('public/backend/toastr.css') }}">
        <script> var BASEURL = '{{ url("/") }}/' </script>
       
        @yield('pageCss')
    </head>
<style type="text/css">
	body{margin: 0;}
	.payment-success {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: center;
} 
.payment-success-wrap{text-align: center;}
.payment-success-wrap img{display: block;}
.payment-success-wrap a{
    border: 2px solid #303030;
    background-color: #303030;
    font-weight: 600;
    font-size: 16px;
    line-height: 20px;
    padding: 8px 15px 8px 15px;
    color: #ffc200;
    border-radius: 5px;
    margin: -100px 0 0 0;
    display: inline-block;
}
.payment-success-wrap a:hover{
background-color: #ffc200;
    color: #303030;
    border-color: #ffc200;}
</style>
<section class="payment-success">
	<div class="payment-success-wrap">
		<img src="{{asset('public/frontend/images/payment-success.gif')}}" alt="">
		<a href="{{ route('home') }}" title="">Back To Home</a>
	</div>
</section>