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
                            <li><a href="{{ route('city.index') }}"> {{ Config::get('constants.title.city') }} </a></li>
                            <li><a href="#">{{ $title }}</a></li>
                        </ol>
                    </div>
                   {{ Form::open(['url' => route('city.update', $city->id), 'method'=>'PATCH', 'files'=>true, 'name' => 'frmCity', 'id' => 'frmCity']) }}
                    {{ method_field('PATCH') }}
                    @php
                        $required = 'required';
                    @endphp
                     <div class="box-body">
                        <div class="row"> 
                            <div class="form-group col-sm-6">
                                <label for="title">Country:</label>
                                <select name="country" id="country" style="width:100%" class="form-control select2" required>
                                <option value="none">Select Country</option>
                                @php
                                if(isset($city)){
                                foreach($countries as $key => $value) {
                                $selected = '';
                                if($value->id == $city->country_id){
                                    $selected = 'selected';
                                }
                                echo '<option value="'.$value->id.'" '.$selected.' >'.$value->name.'</option>';
                            }

                        }

                    @endphp
                    </select>
                            </div>
                            <div class=" form-group col-sm-6">
                                <label for="title">State:</label>
                                <select name="state_id" id="state_id" style="width:100%" class="form-control select2" required>
                                <option value="none">Select State</option>
                                @php
                                if(isset($city)){
                                    foreach($state as $key => $value) {
                                    $selected = '';
                                    if($value->id == $city->state_id){
                                        $selected = 'selected';
                                    }
                                   echo '<option value="'.$value->id.'" '.$selected.' >'.$value->name.'</option>';
                                    }
                                }
                                 @endphp
                                </select>
                            </div>
                         </div>
                        <div class="row">
                            <div class=" form-group col-sm-6">
                                {{ Form::label('name','Name') }}
                                {{ Form::text('name', $city->name, ["required","class"=>"form-control","placeholder"=>'Enter City Name',"id"=>"name","name"=>"name","maxlength"=>100]) }}
                                
                            </div>
                        </div>

                    </div>
                    <div class="box-footer">
                        <div class="form-group">
                            {{ Form::button('<i class="fa fa-save"></i> Save',["required","type"=>"submit", "name"=>"submit","value"=>"Save","id"=>"btnSubmit","class"=>"btn btn-primary",'data-loading-text'=>'<i class="fa fa-spinner fa-spin"></i> loading']) }}
                            <a href="{{ route('city.index') }}" class="btn btn-primary"><i class="fa fa-remove"></i> Cancel</a>
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
<script src="{{ asset('public/backend/js/pages/city.js') }}"></script>
<script src="{{asset('public/backend/common/jquery.validate.js')}}"></script>
<script src="{{asset('public/backend/bower_components/select2/dist/js/select2.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('public/backend/bower_components/select2/dist/css/select2.min.css') }}">
<script type="text/javascript">
  $(function () {
    $('.select2').select2()
  });
</script>
@stop