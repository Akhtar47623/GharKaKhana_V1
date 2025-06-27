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
                            <li><a href="{{ route('discount.index') }}"> {{ Config::get('constants.title.discount') }} </a></li>
                            <li><a href="#">{{ $title }}</a></li>
                        </ol>
                    </div>
                    {{ Form::open(['url' => route('discount.store'), 'method'=>'POST', 'files'=>true, 'name' => 'frmDiscount', 'id' => 'frmDiscount']) }}
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
                                {{ Form::label('company_discount','Company Discount') }}
                                 <div class="input-group">
                                     {{ Form::text('company_discount', old('company_discount'), ["required","class"=>"form-control","placeholder"=>'Enter Company Discount',"id"=>"company_discount","name"=>"company_discount"]) }}
                                     <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                    <label for="">Promo Code</label>
                                    <input type="text" name="promocode" class="form-control" placeholder="Generate Promo Code " id="promocode" required="required" autocomplete="off">
                                    <a href="javascript:void(0)" name="gencode" id="gencode" onclick="getElementById('promocode').value=randomString();">Generate Code</a>
                            </div>    
                        </div>
                        <div class="row">
                             <div class="form-group col-sm-6">
                                    <label for="">Start Date<em>*</em></label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" name="start_date" class="form-control pull-right" autocomplete="off" placeholder="Select Start Date" id="start_date" required="required">
                                    </div>
                            </div>
                             <div class="form-group col-sm-6">
                                <label for="">Expired Date</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right" autocomplete="off" placeholder="Select Expired Date" name="expired_date" id="expired_date" required="required">
                                </div>
                             </div>
                                                   
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                    <label for="">Total Coupons</label>
                                    <input type="number" name="total_coupon" class="form-control" id="total_coupon"  required="required"  placeholder="Enter Total Coupons" autocomplete="off">
                            </div>
                            <div class="form-group col-sm-6">
                                    <label for="">Minimum Order Value</label>
                                    <input type="number" name="minimum_order_value" placeholder="Enter Minimum Order Value" class="form-control" id="minimum_order_value" required="required"  autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="form-group">
                            {{ Form::button('<i class="fa fa-save"></i> Save',["required","type"=>"submit", "name"=>"submit","value"=>"Save","id"=>"btnSubmit","class"=>"btn btn-primary",'data-loading-text'=>'<i class="fa fa-spinner fa-spin"></i> loading']) }}
                            <a href="{{ route('discount.index') }}" class="btn btn-primary"><i class="fa fa-remove"></i> Cancel</a>
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
<link rel="stylesheet" type="text/css" href="{{ asset('public/backend/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.css')}}">    
<script type="text/javascript" src="{{ asset('public/backend/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}"></script>
<script src="{{ asset('public/backend/js/pages/discount.js') }}"></script>
<script src="{{asset('public/backend/common/jquery.validate.js')}}"></script>
<script src="{{asset('public/backend/bower_components/select2/dist/js/select2.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('public/backend/bower_components/select2/dist/css/select2.min.css') }}">
<script type="text/javascript">
  $(function () {
    $('.select2').select2()
  });
</script>
@stop