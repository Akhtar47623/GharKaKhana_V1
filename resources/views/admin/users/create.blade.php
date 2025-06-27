@extends('admin.layouts.master')

@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border content-header">
                        <h3>{{$title}}</h3>
                        <ol class="breadcrumb">
                            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                            <li><a href="{{ route('users.index') }}"> {{ Config::get('constants.title.user') }} </a></li>
                            <li><a href="#">{{ $title }}</a></li>
                        </ol>
                    </div>
                    {{ Form::open(['url' => route('users.store'), 'method'=>'POST', 'files'=>true, 'name' => 'frmUser', 'id' => 'frmUser']) }}
                     <div class="box-body">
                        <div class="row"> 
                            <div class="form-group col-sm-6">
                                {{ Form::label('first_name','First Name') }}
                                {{ Form::text('first_name', old('first_name'), ["required","class"=>"form-control","placeholder"=>'Enter First Name',"id"=>"first_name","name"=>"first_name","maxlength"=>100]) }}
                            </div>
                       
                            <div class=" form-group col-sm-6">
                                {{ Form::label('last_name','Last Name') }}
                                {{ Form::text('last_name', old('last_name'), ["required","class"=>"form-control","placeholder"=>'Enter Last Name',"id"=>"last_name","name"=>"last_name","maxlength"=>100]) }}                          
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row"> 
                            <div class=" form-group col-sm-6">
                                {{ Form::label('mobile','Mobile') }}
                                {{ Form::number('mobile', old('mobile'), ["required","class"=>"form-control","placeholder"=>'Enter Mobile',"id"=>"mobile","name"=>"mobile","min"=>1,"minlength"=>4,"maxlength"=>100]) }}
                            </div>
                            <div class="form-group col-sm-6">
                                {{ Form::label('email','Email') }}
                                {{ Form::email('email', old('email'), ["required","class"=>"form-control","placeholder"=>'Enter Email',"id"=>"email","name"=>"email","maxlength"=>100]) }}
                            </div>
                            
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row"> 
                            <div class="form-group col-sm-6">
                                {{ Form::label('password','Password') }}
                                {{ Form::password('password',["class"=>"form-control","placeholder"=>'******',"id"=>"password","name"=>"password", "required"]) }}
                            </div>
                            <div class=" form-group col-sm-6">
                                {{ Form::label('confirm_password','Confirm Password') }}
                                {{ Form::password('confirm_password',["class"=>"form-control","placeholder"=>'******',"id"=>"confirm_password","name"=>"confirm_password", "required"]) }}
                               
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row"> 
                            <div class="form-group col-sm-6">
                                {{ Form::label('address','Address') }}
                                {{ Form::text('address', old('address'), ["class"=>"form-control","placeholder"=>'Enter Address',"id"=>"address","name"=>"address","maxlength"=>150,"required"]) }}
                            </div>
                            <div class="form-group col-sm-6">
                                {{ Form::label('country','Country') }}
                                {{ Form::select('country',!empty($countries) ? $countries : [], old('country'),["required","class"=>"form-control select2","placeholder"=>'Select Country',"id"=>"country","name"=>"country","style"=>"width:100%"]) }} 
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row"> 
                            <div class=" form-group col-sm-6">
                                {{ Form::label('state','State') }}
                                <select id="state" name="state" class="form-control select2" style="width:100%" required="">
                                <option value="">Select State</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                {{ Form::label('city','City') }}
                                <select id="city" name="city" class="form-control select2" style="width:100%" required="">
                                    <option value="">Select City</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row"> 
                            <div class=" form-group col-sm-6">
                                {{ Form::label('zipcode','Zipcode') }}
                                {{ Form::text('zipcode', old('zipcode'),["class"=>"form-control","placeholder"=>'Enter Zipcode',"id"=>"zipcode","name"=>"zipcode","minlength"=>2,"maxlength"=>10]) }}
                            </div>
                            <div class="form-group col-sm-6">
                                {{ Form::label('role_id','Roles') }}
                                {{ Form::select('role_id',!empty($roles) ? $roles : [], old('role_id'),["required","class"=>"form-control select2","style"=>"width:100%","placeholder"=>'-----select------',"id"=>"role_id","name"=>"role_id"]) }}
                            </div>
                            
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                {{ Form::label('profile', 'Profile') }}
                                {{ Form::file('profile', ["required","class"=>"form-control","placeholder"=>"Profile","id"=>"profile","name"=>"profile","onchange"=>"previewImage(this)", "accept"=>"image/*"]) }}
                                <div id="previewImage" class="m-t-20">
                                    @if(isset($userData))
                                        <img src="{{ asset($userData->profile) }}" height="100px" width="100px"
                                             alt="User profile picture">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box-footer">
                        <div class="form-group">
                            {{ Form::button('<i class="fa fa-save"></i> Save',["required","type"=>"submit", "name"=>"submit","value"=>"Save","id"=>"btnSubmit","class"=>"btn btn-primary"]) }}
                            <a href="{{ route('users.index') }}" class="btn btn-primary"><i class="fa fa-remove"></i> Cancel</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert display-none alert-success"></div>
                            <div class="alert display-none alert-danger"></div>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('pagescript')
<script src="{{ asset('public/backend/js/pages/user.js') }}"></script>
<script src="{{asset('public/backend/common/jquery.validate.js')}}"></script>
<script src="{{asset('public/backend/bower_components/select2/dist/js/select2.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('public/backend/bower_components/select2/dist/css/select2.min.css') }}">
<script type="text/javascript">
     $('.select2').select2()
</script>

@stop