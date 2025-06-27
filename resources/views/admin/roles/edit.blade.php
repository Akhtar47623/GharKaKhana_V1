@extends('admin.layouts.master')

@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border content-header">
                        <h3>{{ $title }}</h3>
                        <ol class="breadcrumb">
                            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                            <li><a href="{{ route('roles.index') }}"> {{ Config::get('constants.title.roles') }} </a></li>
                            <li><a href="#">{{ $title }}</a></li>
                        </ol>
                    </div>
                    {{ Form::open(['url' => route('roles.update', $roles->id), 'method'=>'PATCH', 'files'=>true, 'name' => 'roles', 'id' => 'frmRoles']) }}
                    {{ method_field('PATCH') }}
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                {{ Form::label('name', "Name") }}
                                {{ Form::text('name', $roles->name, ["class"=>"form-control","placeholder"=>"Name","id"=>"name","name"=>"name","required"]) }}
                                @if ($errors->has('name'))
                                <span class="error text-danger" for="title">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="form-group">
                            {{ Form::button('<i class="fa fa-save"></i> Save',["type"=>"submit", "id"=>"btnSubmit","name"=>"submit","value"=>"Save","class"=>"btn btn-primary"]) }}
                            <a href="{{ route('roles.index') }}" class="btn btn-primary"><i class="fa fa-remove"></i> Cancel</a>
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
<script src="{{ asset('public/backend/js/pages/roles.js') }}"></script>
<script src="{{asset('public/backend/common/jquery.validate.js')}}"></script>
@stop