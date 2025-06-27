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
    <style>.error-help-block{color:red;}</style>
    <script> var BASEURL = '{{ url("/") }}/' </script>
</head>

<body>
    
    <div class="wrapper">
        <section class="login-sec registration-sec">
            <div class="login-wrap">
                <div class="login-left" style="background-image: url({{asset('public/frontend/images/customer-registration-bg-img.jpg')}})"></div>
                <div class="login-right">
                    <div class="login-right-wrap">
                        <div class="login-logo">
                            <a href="{{ route('home') }}" title="">
                                <img src="{{asset('public/frontend/images/white-logo.png')}}">
                            </a>
                        </div>
                        <div class="login-title">
                            <h1>{{__('sentence.custreg') }}</h1>
                        </div>
                        <div class="login-top">
                            <div class="login-form-sec">
                                {{ Form::open(['url' => route('save-customer-registration'), 'method'=>'POST', 'files'=>true, 'name' => 'customerRegistration', 'id' => 'customerRegistration','class'=>"form-main"]) }}

                                <span class="note"><em>*</em> {{__('sentence.fieldr') }}</span>
                                <ul>
                                    <li>
                                        <div class="form-wrap">
                                            <label for="">{{__('sentence.firstname') }}<em>*</em></label>
                                            <input type="text" name="first_name" required="">
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-wrap">
                                            <label for="">{{__('sentence.lastname') }}<em>*</em></label>
                                            <input type="text" name="last_name" required="">
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-wrap">
                                            <label for="">{{__('sentence.mobile') }}<em>*</em></label>
                                            <input type="text" name="mobile" required="">
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-wrap">
                                            <label for="">{{__('sentence.email') }}<em>*</em></label>
                                            <input type="email" name="email" required="">
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-wrap">
                                            <label for="">{{__('sentence.pass') }}<em>*</em></label>
                                            <input type="password" name="password" id="password" required="">
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-wrap">
                                            <label for="">{{__('sentence.cpass') }}<em>*</em></label>
                                            <input type="password" name="confirm_password" id="confirm_password" required="">
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-wrap">
                                            <label for="">{{__('sentence.country') }}<em>*</em></label>
                                            {{ Form::select('country',!empty($countries) ? $countries : [], old('country'),["required","class"=>"select2","placeholder"=>'Please Select Country',"id"=>"country","name"=>"country","style"=>"width:100%"]) }}

                                        </div>
                                    </li>                                                               
                                    <li>
                                        <div class="form-wrap">
                                            <label for="">{{__('sentence.profile') }}<em>*</em></label>
                                            {{ Form::file('profile', ["required","class"=>"form-control","placeholder"=>"Profile","id"=>"profile","name"=>"profile","onchange"=>"previewImage(this)", "accept"=>"image/*"]) }}
                                            <br>
                                            <div id="previewImage" class="m-t-20" style="padding: 10px;">

                                            </div>
                                        </div>
                                    </li>
                                    <li class="full-width">
                                        <div class="form-wrap">
                                            <button type="Submit" name="btnSubmit">{{__('sentence.reg') }}</button>
                                            <div class="loader-btn">
                                                <div class="sk-three-bounce">
                                                    <div class="sk-child sk-bounce1"></div>
                                                    <div class="sk-child sk-bounce2"></div>
                                                    <div class="sk-child sk-bounce3"></div>
                                                </div>
                                            </div> 
                                            <button type="button" onclick="window.location='{{ url("/") }}'">{{__('sentence.cancel') }}</button>
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
                                            <a href="#" title="" class="google"><i class="fab fa-google"></i> {{__('sentence.contig') }}</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('/login/facebook') }}" title="" class="facebook"><i class="fab fa-facebook-square"></i> {{__('sentence.contif') }}</a>
                                        </li>                                        
                                    </ul>
                                </div>
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
        </div>

    </section>
</div>
<!--scripts starts here-->
<script type="text/javascript" src="{{ asset('public/frontend/js/jquery.min.js')}}"></script>
<script src="{{asset('public/backend/common/jquery.validate.js')}}"></script>
<script type="text/javascript" src="{{ asset('public/frontend/js/pages/customer-regi.js')}}"></script>
<!--scripts ends here-->
</body>
</html>