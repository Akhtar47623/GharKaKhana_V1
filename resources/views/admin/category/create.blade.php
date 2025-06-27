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
                            <li><a href="{{ route('category.index') }}"> {{ Config::get('constants.title.categories') }} </a></li>
                            <li><a href="#">{{ $title }}</a></li>
                        </ol>
                    </div>
                    {{ Form::open(['url' => route('category.store'), 'method'=>'POST', 'files'=>true, 'name' => 'frmCategories', 'id' => 'frmCategories']) }}
                     <div class="box-body">
                        <div class="row"> 
                            <div class="form-group col-sm-6">
                                {{ Form::label('country_id','Country') }}
                                {{ Form::select('country_id',!empty($countries) ? $countries : [], old('country_id'),["required","class"=>"form-control select2","placeholder"=>'Select Country',"id"=>"country_id","name"=>"country_id","style"=>"width:100%"]) }} 
                            </div>
                           <div class=" form-group col-sm-6">
                                {{ Form::label('state','State') }}
                                <select id="state_id" name="state_id" class="form-control select2" style="width:100%" required="">
                                <option value="">Select State</option>
                                </select>
                            </div>
                           
                        </div> 
                        <div class="row"> 
                            <div class="form-group col-sm-6">
                                {{ Form::label('name','Name') }}
                                {{ Form::text('name', old('name'), ["required","class"=>"form-control","placeholder"=>'Enter Category Name',"id"=>"name","name"=>"name","maxlength"=>100]) }}
                            </div>
                            <div class="form-group col-sm-6">
                                {{ Form::label('description','Description') }}
                                {{Form::textarea('description',old('description'), ["required",'class'=>'form-control','rows'=>3,"id"=>"description","name"=>"description"])}}                             
                            </div>
                                                     
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                {{ Form::label('image', 'Image') }}
                                {{ Form::file('image', ["required","class"=>"form-control","placeholder"=>"image","id"=>"image","name"=>"image","onchange"=>"previewImage(this)", "accept"=>"image/*"]) }}
                                <div id="previewImage" class="m-t-20">
                                    
                                </div>
                            </div> 
                            <div class="form-group col-sm-6">
                                {{ Form::label('user_type','User Type') }}
                                {{ Form::select('user_type',["1"=>"Home Chef","2"=>"Catering","3"=>"Food Truck","4"=>"Restaurants"], old('user_type'),["required","class"=>"form-control select2","multiple"=>"multiple","id"=>"user_type","name"=>"user_type[]","style"=>"width:100%"]) }}
                            </div>    
                                                   
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="form-group">
                            {{ Form::button('<i class="fa fa-save"></i> Save',["required","type"=>"submit", "name"=>"submit","value"=>"Save","id"=>"btnSubmit","class"=>"btn btn-primary",'data-loading-text'=>'<i class="fa fa-spinner fa-spin"></i> loading']) }}
                            <a href="{{ route('category.index') }}" class="btn btn-primary"><i class="fa fa-remove"></i> Cancel</a>
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
<script src="{{ asset('public/backend/js/pages/category.js') }}"></script>
<script src="{{asset('public/backend/common/jquery.validate.js')}}"></script>
<script src="{{asset('public/backend/bower_components/select2/dist/js/select2.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('public/backend/bower_components/select2/dist/css/select2.min.css') }}">
<script type="text/javascript">
  $(function () {
    $('.select2').select2()
  });
</script>
@stop