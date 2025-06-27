<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

    <head>
        <title>Prep By Chef</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <meta name="format-detection" content="telephone=no">
        <meta name="keywords" content="">
        <meta name="description" content="">
        <!--css styles starts-->
        <link rel="shortcut icon" type="image/x-icon" href="{{asset('public/frontend/images/favicon.ico')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/css/style.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/css/responsive.css')}}" media="screen">
    </head>

    <body>
        <div class="wrapper">
            <section class="login-sec">
                <div class="container">
                    <div class="thank-you">
                    <h3>{{__('sentence.reg-thanks-one')}} <br>{{__('sentence.reg-thanks-two')}} <a href="{{route('chef-sign-in') }}" title="">{{__('sentence.reg-thanks-three')}}</a> {{__('sentence.reg-thanks-four')}}</h3>
                    </div>
                </div>
            </section>
        </div>
        <!--scripts starts here-->
        <script type="text/javascript" src="{{ asset('public/frontend/js/jquery.min.js')}}"></script>
        <!--scripts ends here-->
    </body>
</html>


