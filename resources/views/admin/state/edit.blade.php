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
                            <li><a href="{{ route('state.index') }}"> {{ Config::get('constants.title.state') }} </a></li>
                            <li><a href="#">{{ $title }}</a></li>
                        </ol>
                    </div>
                    {{ Form::open(['url' => route('state.update', $stateData->id), 'method'=>'PATCH', 'files'=>true, 'name' => 'frmState', 'id' => 'frmState']) }}
                    {{ method_field('PATCH') }}
                    @php
                        $required = 'required';
                    @endphp

                    <div class="box-body">
                        <div class="row"> 
                            <div class="form-group col-sm-6">
                                {{ Form::label('country_id','Country Name') }}
                                {{ Form::select('country_id',$countries,$stateData->country_id,["class"=>"form-control select2","style"=>"width: 100%","placeholder"=>'-----Select Country------',"id"=>"country_id","name"=>"country_id"]) }}
                            </div>
                       
                            <div class=" form-group col-sm-6">
                                {{ Form::label('name','Name') }}
                                {{ Form::text('name', $stateData->name, ["required","class"=>"form-control","placeholder"=>'Enter State Name',"id"=>"name","name"=>"name","maxlength"=>100]) }}
                                
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="form-group">
                            {{ Form::button('<i class="fa fa-save"></i> Save',["required","type"=>"submit", "name"=>"submit","value"=>"Save","id"=>"btnSubmit","class"=>"btn btn-primary",'data-loading-text'=>'<i class="fa fa-spinner fa-spin"></i> loading']) }}
                            <a href="{{ route('state.index') }}" class="btn btn-primary"><i class="fa fa-remove"></i> Cancel</a>
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
<script src="{{ asset('public/backend/js/pages/states.js') }}"></script>
<script src="{{asset('public/backend/common/jquery.validate.js')}}"></script>
<script src="{{asset('public/backend/bower_components/select2/dist/js/select2.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('public/backend/bower_components/select2/dist/css/select2.min.css') }}">
@stop