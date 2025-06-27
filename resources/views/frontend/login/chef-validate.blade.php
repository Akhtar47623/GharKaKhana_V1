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
                            <h1>{{__('sentence.validate') }}</h1>
                        </div>
                        <div class="login-top">
                            <div class="login-form-sec">
                               {{ Form::open(['url' => route('chef-validate'), 'method'=>'POST', 'files'=>true, 'name' => 'frmValidate', 'id' => 'frmValidate','class'=>"form-main"]) }}

                               <span class="note"><em>*</em> {{__('sentence.fieldr') }}</span>
                               <ul>
                                    <li>
                                        <div class="form-wrap">
                                            <label for="">{{__('sentence.email') }}</label>
                                            <?php if(isset($data)){ ?>
                                                <input type="email" name="demail" value="{{$data->email}}" disabled="">
                                                <input type="hidden" name="email" value="{{$data->email}}">
                                            <?php }else{ ?>
                                                <input type="email" name="email" id="email" value="" required="">
                                            <?php } ?>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-wrap">
                                            <label for="">{{__('sentence.pass') }}</label>
                                            <input type="password" name="password" id="password" value="" required="">
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-content">
                                            <label for="">{{__('sentence.validcode') }}</label>
                                            <?php if(isset($data)){ ?>
                                                <input type="text" name="validate_code" value="{{$data->validate_code}}" disabled="">
                                                <input type="hidden" name="validate_code" value="{{$data->validate_code}}"> 
                                            <?php }else{ ?>
                                                <input type="text" name="validate_code" value="" required="">
                                            <?php } ?>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-wrap">
                                            <button type="Submit" name="btnSubmit">{{__('sentence.validate') }}</button>
                                            <button type="button" name="reSend" id="reSend">{{__('sentence.resendm') }}</button>
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
    <script type="text/javascript" src="{{ asset('public/frontend/js/pages/chef-validate.js')}}"></script>
    <!--toaster-->
    <script src="{{asset('public/backend/toastr.min.js')}}"></script>

    <!--scripts ends here-->
    {!! Toastr::message() !!}
</body>
</html>