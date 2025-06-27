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
                <div class="login-left" style="background-image: url({{asset('public/frontend/images/location-bg-img.jpg')}})"></div>
                <div class="login-right">
                    <div class="login-right-wrap">
                        <div class="login-logo">
                            <a href="#" title="">
                                <img src="{{asset('public/frontend/images/white-logo.png')}}">
                            </a>
                        </div>
                        <div class="login-title">
                            <h1>{{__('sentence.location') }}</h1>
                        </div>
                        <div class="login-top">
                            <div class="login-form-sec">
                                {{ Form::open(['url' => route('save-customer-location'), 'method'=>'POST', 'files'=>true, 'name' => 'frmCustomerLocation', 'id' => 'frmCustomerLocation','class'=>"form-main"]) }}
                                <span class="note"><em>*</em> {{__('sentence.fieldr') }}</span>
                                <ul>
                                    <li>
                                        <div class="form-wrap">
                                            <label for="">{{__('sentence.location') }}<em>*</em></label>
                                            <input type="text" name="location" id="location" value="" required="">
                                            <input type="hidden" name="uuid" id="uuid" value="{{$uuid}}">
                                            <input type="hidden" name="lat" id="lat">
                                            <input type="hidden" name="log" id="log">
                                            <input type="hidden" name="country" id="country">
                                            <input type="hidden" name="state" id="state">
                                            <input type="hidden" name="city" id="city">
                                            <input type="hidden" name="address" id="address">
                                            <input type="hidden" name="zipcode" id="zipcode">
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-wrap">
                                            <button type="Submit" name="btnSubmit" id="btnSubmit">{{__('sentence.save') }}</button>
                                            

                                        </div>
                                    </li>
                                </ul>
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
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&key=<?php echo config('view.google_api_key'); ?>"></script>
    <script type="text/javascript" src="{{ asset('public/frontend/js/pages/cust-location.js')}}"></script>
    <!--scripts ends here-->
</body>
</html>