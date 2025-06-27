<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
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
                                <a href="#" title="">
                                    <img src="{{asset('public/frontend/images/white-logo.png')}}">
                                </a>
                            </div>
                            <div class="login-title">
                                <h1>{{__('sentence.pass-recovery')}}</h1>
                            </div>
                            <div class="login-top">
                                <div class="login-form-sec">
                                 {{ Form::open(['url' => route('password-reset-store'), 'method'=>'POST', 'files'=>true, 'name' => 'frmResetPassword', 'id' => 'frmResetPassword','class'=>"form-main"]) }}
                                    <span class="note"><em>*</em> {{__('sentence.fieldr') }}</span>
                                    <input type="hidden" name="token" value="{{$token}}" id="token">
                                    <ul>
                                        <li>
                                            <div class="form-wrap">
                                                <label for="">{{__('sentence.npass') }}<em>*</em></label>
                                                <input type="password" name="password" id="password" value="" required="">
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-wrap">
                                                <label for="">{{__('sentence.cpass') }}<em>*</em></label>
                                                <input type="password" name="confirm_password" id="confirm_password" value="" required="">
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-wrap">
                                                <button type="submit" name="btnSubmit" id="btnSubmit">{{__('sentence.reset-pass')}}</button>
                                                <div class="loader-btn">
                                                    <div class="sk-three-bounce">
                                                        <div class="sk-child sk-bounce1"></div>
                                                        <div class="sk-child sk-bounce2"></div>
                                                        <div class="sk-child sk-bounce3"></div>
                                                    </div>
                                                </div>                                           
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
        <script type="text/javascript" src="{{ asset('public/frontend/js/pages/reset-password.js')}}"></script>
        <!--scripts ends here-->
    </body>
</html>