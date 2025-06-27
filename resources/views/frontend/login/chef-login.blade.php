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
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('public/frontend/images/favicon.icos')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/css/responsive.css')}}" media="screen">
    <style>.error-help-block{color:red;}</style>
    <script> var BASEURL = '{{ url("/") }}/' </script>
</head>

<body>
    <div class="wrapper">
        <section class="login-sec">
            <div class="login-wrap">
                <div class="login-left" style="background-image: url({{asset('public/frontend/images/chef-login-bg-img.jpg')}})">
                </div>
                <div class="login-right">
                    <div class="login-right-wrap">
                        <div class="login-logo">
                            <a href="{{ route('home') }}" title="">
                                <img src="{{asset('public/frontend/images/white-logo.png')}}">
                            </a>
                        </div>
                         
                        <div class="login-title">
                            <h1>{{__('sentence.chefl') }}</h1>
                        </div>
                        <div class="login-top">
                            <div class="login-form-sec">
                                {{ Form::open(['url' => route('chef-login'), 'method'=>'POST', 'files'=>true, 'name' => 'frmLogin', 'id' => 'frmLogin','class'=>"form-main"]) }}
                                <span class="note"><em>*</em> {{__('sentence.fieldr') }}</span>
                                <ul>
                                    <li>
                                        <div class="form-wrap">
                                            <label for="">{{__('sentence.email') }}<em>*</em></label>
                                            <input type="email" name="email" id="email" value="" required="">
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-wrap">
                                            <label for="">{{__('sentence.pass') }}<em>*</em></label>
                                            <input type="password" name="password" id="password" value="" required="">
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-content-wrap">
                                            {{-- <div class="form-content-remember">
                                                <input type="checkbox" name="">
                                                <span>{{__('sentence.rememberp') }}</span>
                                            </div> --}}
                                            <div class="form-content">
                                                <a href="{{route('validate','1')}}">{{__('sentence.validate') }}?</a>
                                            </div>
                                            <div class="form-content">
                                                <a href="{{route('password-recovery')}}" title="">{{__('sentence.forgotp') }}</a>
                                                

                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-wrap">
                                            <button type="submit" name="btnSubmit" id="btnSubmit">{{__('sentence.login') }}</button>
                                            
                                            <button type="button" onclick="window.location='{{ route("chef-sign-up") }}'">{{__('sentence.reg') }}</button>

                                        </div>
                                    </li>
                                </ul>
                                {{ Form::close() }}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert display-none alert-success"></div>
                                        <div class="alert display-none alert-danger"></div>
                                    </div>
                                </div>
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
    <script type="text/javascript" src="{{ asset('public/frontend/js/pages/chef-login.js')}}"></script>
    <!--scripts ends here-->
</body>
</html>