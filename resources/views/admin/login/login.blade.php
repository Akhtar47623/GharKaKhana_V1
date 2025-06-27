<!DOCTYPE html>
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
        <style type="text/css">
            .bgimg{background-image: url('public/backend/dist/img/photo2.png');}
            body.login-page, body.register-page{background-image: url('public/backend/dist/img/admin-bgg.jpg');}
            .checkbox, .radio{margin-top: 20px;}
            .forgot-link{display: inline-block;margin: 20px 0 0 0;}
            .login-logo img, .register-logo img{max-width: 100%;border-radius: 10px;}
        </style>
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">

            <div class="login-box-body">
                <div class="login-logo">
                    <img src="{{asset('public/frontend/images/logo.png')}}">
                </div>
                <p class="login-box-msg"><b>Sign In</b></p>
                {{ Form::open(['url' => "admin","method"=>"POST"]) }} 
                <div class="form-group has-feedback">
                    {{ Form::email('email', Input::old('email'), ["type"=>"email","class"=>"form-control ","placeholder"=>"example@email.com","name"=>"email"]) }}
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    {!! $errors->first('email','<span class="help-block  "><strong class="text-danger">:message</strong></span>') !!}
                </div>
                <div class="form-group has-feedback">
                    {{ Form::password('password',["class"=>"form-control","placeholder"=>"******","name"=>"password"]) }}
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    {!! $errors->first('password','<span class="help-block  "><strong class="text-danger">:message</strong></span>') !!}
                </div>
                <div class="row">
                    <div class="col-xs-12">
                            <center>
                            {{ Form::submit('Login',["name"=>"btnsubmit","id"=>"btnSubmit","value"=>"Sign In","class"=>"btn btn-lg btn-primary btn-block"]) }}
                            </center>
                    </div>
                    <div class="col-xs-6">
                        <div class="checkbox icheck">
                            <label>
                                {{ Form::checkbox('remember', Input::old('remember'), ["class"=>"form-control","name"=>"remember"]) }} Remember Me
                            </label>
                        </div>
                    </div>
                    <div class="col-xs-6 text-right">
                            <a href="{{route('forgot-password')}}" class="link forgot-link">Forgot Password</a>
                        </div>
                </div>
               
                {{ Form::close() }}
               
                <br/>
                
                @if( Session::has('flash_message_error') )
                <div class="callout callout-danger alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                    {!! Session::get('flash_message_error') !!}
                </div>
                @endif

                @if( Session::has('flash_message_success') )
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i> Alert!</h4>
                    {!! Session::get('flash_message_success') !!}
                </div>
                @endif
            </div>
        </div> 
        <script src="{{ asset('public/backend/bower_components/jquery/dist/jquery.min.js')}}"></script> 
        <script src="{{ asset('public/backend/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script> 
        <script src="{{ asset('public/backend/plugins/iCheck/icheck.min.js')}}"></script>
        <script>
$(function () {
    $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' /* optional */
    });
});
        </script>
    </body>
</html>
