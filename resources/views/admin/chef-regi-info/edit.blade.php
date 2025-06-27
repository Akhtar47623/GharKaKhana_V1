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
                            <li><a href="{{ route('chef-registration-info.index') }}">{{Config::get('constants.title.categories')}}</a>
                            </li>
                            <li><a href="#">{{ $title }}</a></li>
                        </ol>
                    </div>
                    {{ Form::open(['url' => route('chef-registration-info.update', $chefRegInfo->id), 'method'=>'PATCH', 'files'=>true, 'name' => 'frmChefRegInfo', 'id' => 'frmChefRegInfo']) }}
                    {{ method_field('PATCH') }}
                    @php
                        $required = 'required';
                    @endphp
                    <div class="box-body">
                        <div class="row"> 
                            <div class="form-group col-sm-4">
                                {{ Form::label('country_id','Country') }}
                                {{ Form::select('country_id',!empty($countries) ? $countries : [], $chefRegInfo->country_id,["required","class"=>"form-control select2","placeholder"=>'Select Country',"id"=>"country_id","name"=>"country_id","style"=>"width:100%"]) }} 
                            </div>
                           <div class=" form-group col-sm-4">
                                {{ Form::label('state','State') }}
                                {{ Form::select('state_id',!empty($states) ? $states : [], $chefRegInfo->state_id,["required","class"=>"form-control select2","placeholder"=>'Select State',"id"=>"state_id","name"=>"state_id","style"=>"width:100%"]) }}
                                
                            </div>
                            <div class="form-group col-sm-4">
                                {{ Form::label('user_type','User Type') }}
                                {{ Form::select('user_type',["1"=>"Home Chef","2"=>"Catering"], $chefRegInfo->user_type,["required","class"=>"form-control","placeholder"=>'Select User Type',"id"=>"user_type","name"=>"user_type"]) }}
                            </div>
                           
                        </div> 
                        <div class="row">
                            <div class="form-group col-sm-12">
                                {{ Form::label('description','Description') }}
                                {{Form::textarea('description',$chefRegInfo->description, ['class'=>'form-control','rows'=>3,"id"=>"summary_ckeditor","name"=>"summary_ckeditor"])}}            
                            </div>                                                 
                        </div>                        
                    </div>
                    <div class="box-footer">
                        <div class="form-group">
                            {{ Form::button('<i class="fa fa-save"></i> Save',["required","type"=>"submit", "name"=>"submit","value"=>"Save","id"=>"btnSubmit","class"=>"btn btn-primary",'data-loading-text'=>'<i class="fa fa-spinner fa-spin"></i> loading']) }}
                            <a href="{{ route('chef-registration-info.index') }}" class="btn btn-primary"><i class="fa fa-remove"></i> Cancel</a>
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

<script src="{{ asset('public/backend/js/pages/chef_regi_info.js') }}"></script>
<script src="{{asset('public/backend/common/jquery.validate.js')}}"></script>
<script src="{{asset('public/backend/bower_components/select2/dist/js/select2.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('public/backend/bower_components/select2/dist/css/select2.min.css') }}">
<script src="{{asset('public/backend/bower_components/ckeditor/ckeditor.js')}}"></script>
<script>CKEDITOR.replace('summary_ckeditor' );</script>
 <script type="text/javascript">
  $(function () {
    $('.select2').select2()
  });
</script>
@stop