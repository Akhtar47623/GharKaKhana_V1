<?php /*<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width">
        <title></title>
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="{{ asset('public/backend/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('public/backend/bower_components/font-awesome/css/font-awesome.min.css') }}">
        <!-- Ionicons -->
        <link rel="stylesheet" href="{{ asset('public/backend/bower_components/Ionicons/css/ionicons.min.css') }}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('public/backend/dist/css/AdminLTE.min.css') }}">
        <!-- iCheck -->
        <link rel="stylesheet" href="{{ asset('public/backend/plugins/iCheck/square/blue.css') }}">

        
        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">

            <div class="login-box-body">
                <div class="login-logo">
                    {{ config('app.name') }}
                </div>
                <p class="login-box-msg">Forgot Password</p>
                {{ Form::open(['url' => route('forgot-password'),"method"=>"POST","id"=>"forgot_password"]) }} 
                <div class="form-group has-feedback">
                    {{ Form::email('email', Input::old('email'), ["type"=>"email","class"=>"form-control ","placeholder"=>"example@email.com","name"=>"email"]) }}

                   <!--  <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    {!! $errors->first('email','<span class="help-block  "><strong class="text-danger">:message</strong></span>') !!} -->
                </div>
                
                <div class="row">
                    <div class="col-xs-8"></div>
                    <div class="col-xs-4">
                            {{ Form::submit('Login',["name"=>"btnSubmit","id"=>"btnSubmit","value"=>"Sign In","class"=>"btn btn-primary signin_button "]) }}
                    </div>
                </div>
                
                {{ Form::close() }}
               
                <br/>
                 <div id="ErrorMessagesSection" class="alert alert-danger alert-with-icon" data-notify="container" style="display: none;">
                      <button type="button" aria-hidden="true" class="close">
                      <i class="now-ui-icons ui-1_simple-remove"></i>
                      </button>
                      <span data-notify="icon" class="now-ui-icons ui-1_bell-53"></span>
                      <span data-notify="message" id="ErrorMessages"></span>
                    </div> 
                 
                
            </div>
        </div> 
       
        <script src="{{asset('public/backend/bower_components/jquery/dist/jquery.min.js')}}"></script> 
        <script src="{{ asset('public/backend/js/pages/forgot_password.js')}}"></script>
        <script src="{{ asset('public/backend/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script> 
        <script src="{{ asset('public/backend/plugins/iCheck/icheck.min.js')}}"></script>
        <script>
$(function () {
    $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' /* optional 
    });
});
        </script>

         <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
  {!! Toastr::message() !!}
    </body>
</html>*/?>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
 <div class="form-gap"></div>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
              <div class="panel-body">
                <div class="text-center">
                  <h3><i class="fa fa-lock fa-4x"></i></h3>
                  <h2 class="text-center">Forgot Your Password?</h2>
                  <p>Don't worry, Resetting your password is easy. just tell us the email address you registered</p>
                  <div class="panel-body">
    
                    {{ Form::open(['url' => route('forgot-password'),"method"=>"POST","id"=>"forgot_password"]) }} 
                <div class="form-group has-feedback">
                    {{ Form::email('email', Input::old('email'), ["type"=>"email","class"=>"form-control ","placeholder"=>"example@email.com","name"=>"email"]) }}
                </div>
                
                <div class="row">
                    <div class="col-xs-8"></div>
                    <div class="col-xs-4">
                            {{ Form::submit('Submit',["name"=>"btnSubmit","id"=>"btnSubmit","value"=>"Sign In","class"=>"btn btn-primary signin_button "]) }}
                    </div>
                </div>
                
                {{ Form::close() }}
                <div id="ErrorMessagesSection" class="alert alert-danger alert-with-icon" data-notify="container" style="display: none;">
                      <button type="button" aria-hidden="true" class="close">
                      <i class="now-ui-icons ui-1_simple-remove"></i>
                      </button>
                      <span data-notify="icon" class="now-ui-icons ui-1_bell-53"></span>
                      <span data-notify="message" id="ErrorMessages"></span>
                    </div> 
    
                  </div>
                </div>
              </div>
            </div>
          </div>
    </div>
</div>

<script src="{{asset('public/backend/bower_components/jquery/dist/jquery.min.js')}}"></script> 
<script src="{{ asset('public/backend/js/pages/forgot_password.js')}}"></script>
 <script src="{{ asset('public/backend/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script> 
  <script src="{{ asset('public/backend/plugins/iCheck/icheck.min.js')}}"></script>
    <script>
$(function () {
    $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' /* optional 
    });
});
        </script>

<link rel="stylesheet" type="text/css" href="{{asset('public/backend/toastr.css') }}">
<script src="{{asset('public/backend/toastr.min.js')}}"></script>
<style type="text/css">.form-gap {
    padding-top: 70px;
}</style>
  {!! Toastr::message() !!}