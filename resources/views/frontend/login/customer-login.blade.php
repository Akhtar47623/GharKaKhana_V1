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
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/css/all.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/css/responsive.css')}}" media="screen">
    <style>.error-help-block{color:red;}</style>
    <script> var BASEURL = '{{ url("/") }}/' </script>
</head>
<body>

    <div class="wrapper">
        <section class="login-sec">
            <div class="login-wrap">
                <div class="login-left" style="background-image: url({{asset('public/frontend/images/login-bg-img.jpg')}})"></div>
                <div class="login-right">
                    <div class="login-right-wrap">
                        <div class="login-logo">
                            <a href="{{ route('home') }}" title="">
                                <img src="{{asset('public/frontend/images/white-logo.png')}}">
                            </a>
                        </div>
                        <div class="login-title">
                            <h1>{{__('sentence.custlogn') }}</h1>
                        </div>
                        <div class="login-top">
                            <div class="login-form-sec">
                                {{ Form::open(['url' => route('customer-login'), 'method'=>'POST', 'files'=>true, 'name' => 'frmLogin', 'id' => 'frmLogin','class'=>"form-main"]) }}
                                <ul>
                                    <li>
                                        <div class="form-wrap">
                                            <label for=""><em>*</em>{{__('sentence.email') }}</label>
                                            <input type="email" name="email" value="" required="">
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-wrap">
                                            <label for=""><em>*</em>{{__('sentence.pass') }}</label>
                                            <input type="password" name="password" id="password" value="" required="">
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-content-wrap">
                                            <div class="form-content-remember">
                                                <input type="checkbox" name="">
                                                <span>{{__('sentence.rememberp') }}</span>
                                            </div>
                                            <div class="form-content">
                                                <a href="{{route('password-recovery')}}" title="">{{__('sentence.forgotp') }}</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-wrap">
                                            <button type="submit" name="btnSubmit" id="btnSubmit">{{__('sentence.login') }}</button>
                                            <button type="button" onclick="window.location='{{ url("/") }}'">{{__('sentence.cancel') }}</button>           
                                        </div>
                                    </li>    
                                    <li>
                                        <div class="register-link">
                                            <p>{{__('sentence.dontacc') }} <a href="{{ route('customer-sign-up') }}" title="">{{__('sentence.reg') }}</a> {{__('sentence.here') }}.</p>
                                        </div>
                                    </li>                                
                                </ul>
                                <div class="social-login">
                                    @error('name')
                                    <p class="alert alert-danger">{{ $message }}</p>                                      
                                    @enderror
                                    <div class="alert display-none alert-success"></div>
                                    <div class="alert display-none alert-danger"></div> 
                                    <h3><span>{{__('sentence.or') }}</span></h3>
                                    <ul class="social-login">
                                        <li>
                                            <a href="{{ url('/login/google') }}" title="" class="google"><i class="fab fa-google"></i> {{__('sentence.contig') }}</a>
                                        </li>
                                        <li>
                                            <a  href="{{ url('/login/facebook') }}" title="" class="facebook"><i class="fab fa-facebook-square"></i> {{__('sentence.contif') }}</a>
                                        </li>
                                    </ul>
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!--scripts starts here-->
    <script type="text/javascript" src="{{ asset('public/frontend/js/jquery.min.js')}}"></script>
    <script src="{{asset('public/backend/common/jquery.validate.js')}}"></script>
    <script type="text/javascript" src="{{ asset('public/frontend/js/pages/cust-login.js')}}"></script>
    <!--scripts ends here-->
</body>
</html>