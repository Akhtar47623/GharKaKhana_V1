@extends('admin.layouts.master')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border content-header">
                        <h3>{{$title }}</h3>
                        <ol class="breadcrumb">
                            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                            <li><a href="#">{{ $title }}</a></li>
                        </ol>
                    </div>
                    <div class="box-body">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#basicInfo" data-toggle="tab">Basic Info</a></li>
                                <li><a href="#passwordArea" data-toggle="tab">Change Password</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active " id="basicInfo">
                                    {{ Form::open(['url' => route('profileUpdate'), 'method'=>'POST', 'first_name' => 'usersbasic', 'id' => 'usersbasic','class'=>'form-horizontal','files'=>'true']) }}
                                    <div class="form-group">
                                        {{ Form::label("first_name", "First Name",['for'=>'name','class'=>'col-sm-4 control-label']) }}
                                        <div class="col-sm-6">
                                            {{ Form::text('first_name', $adminuser->first_name, ["type"=>"name", "class"=>"form-control ","placeholder"=>"First Name","name"=>"first_name"]) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label("last_name", "Last Name",['for'=>'last_name','class'=>'col-sm-4 control-label']) }}
                                        <div class="col-sm-6">
                                            {{ Form::text('last_name', $adminuser->last_name, ["type"=>"name", "class"=>"form-control ","placeholder"=>"Last Name","name"=>"last_name"]) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label("email", "Email",['for'=>'email','class'=>'col-sm-4 control-label']) }}
                                        <div class="col-sm-6">
                                            {{ Form::email('email', $adminuser->email, ["type"=>"email", "required","class"=>"form-control ","placeholder"=>"example@email.com","name"=>"email"]) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label("phone", "Phone",['for'=>'phone','class'=>'col-sm-4 control-label']) }}
                                        <div class="col-sm-6">
                                            {{ Form::text('phone', $adminuser->phone, ["type"=>"email", "required","class"=>"form-control ","placeholder"=>"9876543215","name"=>"phone","maxlength"=>"11"]) }}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label("profile", "Profile",['for'=>'email','class'=>'col-sm-4 control-label']) }} 
                                        <div class="col-sm-6">
                                            {{ Form::file('profile', ["class"=>"form-control","placeholder"=>"Profile","id"=>"profile","name"=>"profile"]) }}
                                            @if(!empty($adminuser->profile))
                                            <img class="profile-user-img img-responsive img-circle" src="{{asset('public/backend/images/users/'.$adminuser->profile)}}" alt="User profile picture">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-4 col-sm-10">
                                            {{ Form::submit('Submit',["name"=>"submit","value"=>"Submit","class"=>"btn btn-primary"]) }}
                                        </div>
                                    </div>
                                    {{ Form::hidden('basicInfo','basicInfo',['name'=>'type']) }}
                                    {{ Form::hidden('oldimage', $adminuser->profile,['name'=>'oldimage']) }}

                                    {{ Form::close() }}
                                </div>
                                <div class="tab-pane" id="passwordArea">
                                    {{ Form::open(['url' => route('profileUpdate'), 'method'=>'POST', 'name' => 'userspassword', 'id' => 'userspassword','class'=>'form-horizontal']) }}
                                    <div class="form-group">
                                        {{ Form::label("password", "Password",['for'=>'password','class'=>'col-sm-4 control-label']) }}
                                        <div class="col-sm-6">
                                            {{ Form::password('password',["required","class"=>"form-control","placeholder"=>"******","name"=>"password","id"=>"password"]) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label("password_confirm", "Confirm Password",['for'=>'password_confirm','class'=>'col-sm-4 control-label']) }}
                                        <div class="col-sm-6">
                                            {{ Form::password('password_confirm',["required","class"=>"form-control","placeholder"=>"******","name"=>"password_confirm","id"=>"password_confirm"]) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-4 col-sm-10">
                                            {{ Form::submit('Submit',["name"=>"submit","value"=>"Submit","class"=>"btn btn-primary"]) }}
                                        </div>
                                    </div>
                                    {{ Form::hidden('passwordupdate','passwordupdate',['name'=>'type']) }}
                                    {{ Form::close() }}
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
<script src="{{asset('public/backend/common/jquery.validate.js')}}"></script>
<script src="{{ asset('public/backend/js/pages/profile.js') }}"></script>
@stop