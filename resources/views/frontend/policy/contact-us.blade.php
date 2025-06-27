@extends('frontend.layouts.app')
@section('content')
<div class="wrapper">
    <section class="login-sec">
        <div class="login-wrap contact-form">
            <div class="login-left" style="background-image: url({{asset('public/frontend/images/contact-us.png')}})"></div>
                <div class="login-right">
                    <div class="login-right-wrap">

                        <div class="login-title">
                            <h1>{{__('sentence.contactus')}}</h1>
                        </div>
                        <div class="login-top">
                            <div class="login-form-sec">
                                {{ Form::open(['url' => route('contactus.store'), 'method'=>'POST', 'files'=>true, 'name' => 'frmContact', 'id' => 'frmContact','class'=>"form-main"]) }}

                                <span class="note"><em>*</em> {{__('sentence.fieldr') }}</span>
                                <ul>
                                    <li class="half-li">
                                        <div class="form-wrap">
                                            <label for="">{{__('sentence.name') }}<em>*</em></label>
                                            <input type="text" name="name" id="name" value="" required="">                 
                                        </div>
                                    </li>

                                    <li class="half-li">
                                       <div class="form-wrap">
                                            <label for="">{{__('sentence.mobile') }}<em>*</em></label>                        
                                            <input type="number" name="mobile" id="mobile" value="" required="">              
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-wrap">
                                            <label for="">{{__('sentence.email') }}<em>*</em></label>                      
                                            <input type="email" name="email" id="email" value="" required="">               
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-wrap">
                                            <label for="">{{__('sentence.subject') }}<em>*</em></label>
                                            <input type="text" name="subject" id="subject" value="" required="">
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-content">
                                            <label for="">{{__('sentence.message') }}<em>*</em></label>
                                            <textarea name="message" id="message" required=""></textarea>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="captcha" style="padding-top: 10px;">
                                            <span>{!! captcha_img() !!}</span>
                                            <button type="button" class="btn-refresh">
                                             <i class="fas fa-sync"></i></button>
                                        </div>  
                                        <div class="form-content" >
                                           <input id="captcha" type="text" class="form-control" placeholder="Enter Captcha" name="captcha" required="">
                                        </div>
                                        @if ($errors->has('captcha'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('captcha') }}</strong>
                                        </span>
                                        @endif 
                                    </li>
                                    <li>
                                        <div class="form-wrap">
                                            <button type="Submit" name="btnSubmit">{{__('sentence.submit') }}</button>
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
    
@endsection
@section('pagescript')
<script type="text/javascript" src="{{ asset('public/frontend/js/pages/contactus.js')}}"></script>
<script src="{{asset('public/backend/common/jquery.validate.js')}}"></script>
@endsection