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
                            <li><a href="{{ route('taxes.index') }}"> {{ Config::get('constants.title.taxes') }} </a></li>
                            <li><a href="#">{{ $title }}</a></li>
                        </ol>
                    </div>
                   {{ Form::open(['url' => route('taxes.update', $taxesData->id), 'method'=>'PATCH', 'files'=>true, 'name' => 'frmTaxes', 'id' => 'frmTaxes']) }}
                    {{ method_field('PATCH') }}
                    @php
                        $required = 'required';
                    @endphp
                     <div class="box-body">
                        <div class="row"> 
                            <div class="form-group col-sm-6">
                                {{ Form::label('country','Country') }}
                                {{ Form::select('country',!empty($countries) ? $countries : [], $taxesData->country_id,["required","class"=>"form-control select2","style"=>"width:100%","placeholder"=>'-----Select Country------',"id"=>"country","name"=>"country"]) }}
                            </div>
                            <div class=" form-group col-sm-6">
                               {{ Form::label('state','State') }}
                                <select id="state" name="state" class="form-control select2" style="width: 100%">
                                    <option value="">Select State</option>
                                   @php
                                        if(isset($taxesData)){
                                            foreach($stateList as $key => $value) {
                                                $selected = '';
                                                if($value->id == $taxesData->state_id){
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
                            
                            <div class="form-group col-sm-6">
                                {{ Form::label('city','City') }}
                                <select id="city" name="city" class="form-control select2" style="width: 100%">
                                    <option value="">Select City</option>
                                    @php
                                        if(isset($taxesData)){
                                            foreach($cityList as $key => $value) {
                                                $selected = '';
                                                if($value->id == $taxesData->city_id){
                                                    $selected = 'selected';
                                                }
                                                echo '<option value="'.$value->id.'" '.$selected.' >'.$value->name.'</option>';
                                            }
                                        }
                                    @endphp
                                </select>
                            </div>
                             <div class=" form-group col-sm-6">
                                 {{ Form::label('currency','Currency') }}
                                <select id="currency" name="currency" class="form-control select2" style="width:100%" required="">
                                    <option value="{{$taxesData->currency}}">{{$taxesData->currency}}</option>
                                </select>
                                
                            </div>
                        </div>
                        <div class="row">
                             <div class="form-group col-sm-6">
                                {{ Form::label('chef_commission','Chef Commission') }}
                                <div class="input-group"> 
                                    {{ Form::number('chef_commission',$taxesData->chef_commission, ["required","class"=>"form-control","placeholder"=>'Enter Chef Commission',"id"=>"chef_commission","name"=>"chef_commission","maxlength"=>100]) }}
                                    <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                </div>
                            </div>
                            <div class=" form-group col-sm-6">
                                {{ Form::label('delivery_commission','Delivery Commission') }}
                                <div class="input-group"> 
                                    {{ Form::number('delivery_commission', $taxesData->delivery_commission, ["required","class"=>"form-control","placeholder"=>'Enter Chef Commission',"id"=>"delivery_commission","name"=>"delivery_commission","maxlength"=>100]) }}  
                                <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                </div>                              
                            </div>
                        </div>
                        <div class="row">
                            <div class=" form-group col-sm-6">
                                {{ Form::label('service_fee_base','Service Fee Base') }}
                                {{ Form::number('service_fee_base', $taxesData->service_fee_base, ["required","class"=>"form-control","placeholder"=>'Enter Service Fee Base',"id"=>"service_fee_base","name"=>"service_fee_base"]) }}
                                
                            </div>
                            <div class=" form-group col-sm-6">
                                {{ Form::label('service_fee_per','Service Fee') }}
                                <div class="input-group"> 
                                    {{ Form::number('service_fee_per', $taxesData->service_fee_per, ["required","class"=>"form-control","placeholder"=>'Enter Service Fee Base',"id"=>"service_fee_per","name"=>"service_fee_per"]) }} 
                                    <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                </div>                                   
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class=" form-group col-sm-6">
                                {{ Form::label('Tax','Tax') }}
                                <div class="input-group">
                                    {{ Form::number('tax', $taxesData->tax, ["required","class"=>"form-control","placeholder"=>'Enter  Tax',"id"=>"tax","name"=>"tax","maxlength"=>100,'min' => '0.00']) }} 
                                <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                </div>                                
                            </div>
                            <div class=" form-group col-sm-6">
                                {{ Form::label('cc_fees','Credit Card Fees') }}
                                <div class="input-group">
                                    {{ Form::number('cc_fees', $taxesData->cc_fees, ["required","class"=>"form-control","placeholder"=>'Enter  Credit Card',"id"=>"cc_fees","name"=>"cc_fees","maxlength"=>100,'min' => '0.00']) }} 
                                <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                </div>                                
                            </div>
                        </div>
                        <div class="row">
                            <div class=" form-group col-sm-6">
                                {{ Form::label('house','House') }}
                                <div class="input-group">
                                    {{ Form::number('house',$taxesData->house, ["required","class"=>"form-control","placeholder"=>'Enter  House',"id"=>"house","name"=>"house","maxlength"=>100]) }} 
                                    <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                </div>                               
                            </div>
                            
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="form-group">
                            {{ Form::button('<i class="fa fa-save"></i> Save',["required","type"=>"submit", "name"=>"submit","value"=>"Save","id"=>"btnSubmit","class"=>"btn btn-primary",'data-loading-text'=>'<i class="fa fa-spinner fa-spin"></i> loading']) }}
                            <a href="{{ route('taxes.index') }}" class="btn btn-primary"><i class="fa fa-remove"></i> Cancel</a>
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
<script src="{{ asset('public/backend/js/pages/taxes.js') }}"></script>
<script src="{{asset('public/backend/common/jquery.validate.js')}}"></script>
<script src="{{asset('public/backend/bower_components/select2/dist/js/select2.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('public/backend/bower_components/select2/dist/css/select2.min.css') }}">
 <script>
  $(function () {
    $('.select2').select2()
  });
</script> 
@stop