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
                            <li><a href="{{ route('country.index') }}"> {{ Config::get('constants.title.country') }} </a></li>
                            <li><a href="#">{{ $title }}</a></li>
                        </ol>
                    </div>
                    {{ Form::open(['url' => route('country.update', $countryData->id), 'method'=>'PATCH', 'files'=>true, 'name' => 'frmCountry', 'id' => 'frmCountry']) }}
                    {{ method_field('PATCH') }}
                    @php
                        $required = 'required';
                    @endphp

                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                {{ Form::label('name','Name') }}
                                {{ Form::text('name', $countryData->name, [$required,"class"=>"form-control","placeholder"=>'Enter Country Name',"id"=>"name","name"=>"name","maxlength"=>100]) }}
                            </div>
                            
                            <div class="form-group col-sm-6">
                                {{ Form::label('sortname','Sort Name') }}
                                {{ Form::text('sortname', $countryData->sortname, ["required","class"=>"form-control","placeholder"=>'Enter Country Sort Name',"id"=>"sortname","name"=>"sortname","minlength"=>"2","maxlength"=>"2"]) }}
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                {{ Form::label('phoneCode','Phone Code') }}
                                {{ Form::number('phoneCode', $countryData->phoneCode, ["required","class"=>"form-control","placeholder"=>'Enter Country Phone Code',"id"=>"phoneCode","name"=>"phoneCode","min"=>1]) }}
                                
                            </div>
                            <div class=" form-group col-sm-6">
                                {{ Form::label('currency','Currency') }}
                                {{ Form::text('currency', old('currency'), ["required","class"=>"form-control","placeholder"=>'Enter Currency Name',"id"=>"currency","name"=>"currency","minlength"=>"2","maxlength"=>"2"]) }}
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                {{ Form::label('code','Code') }}
                                {{ Form::text('code', old('code'), ["required","class"=>"form-control","placeholder"=>'Enter Country Code (e.g USD)',"id"=>"code","name"=>"code"]) }}                                
                            </div>
                            <div class=" form-group col-sm-6">
                                {{ Form::label('symbol','Symbol') }}
                                {{ Form::text('symbol', old('symbol'), ["required","class"=>"form-control","placeholder"=>'Enter Currency Symbol',"id"=>"symbol","name"=>"symbol"]) }}
                                
                            </div>
                        </div>
                       
                    </div>
                    <div class="box-footer">
                        <div class="form-group">
                            {{ Form::button('<i class="fa fa-save"></i> Save',["required","type"=>"submit", "name"=>"submit","value"=>"Save","id"=>"btnSubmit","class"=>"btn btn-primary",'data-loading-text'=>'<i class="fa fa-spinner fa-spin"></i> loading']) }}
                            <a href="{{ route('country.index') }}" class="btn btn-primary"><i class="fa fa-remove"></i> Cancel</a>
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
<script src="{{ asset('public/backend/js/pages/country.js') }}"></script>
<script src="{{asset('public/backend/common/jquery.validate.js')}}"></script>
@stop