@extends('frontend.chef-dashboard.layouts.app')
@section('pageCss')
<link rel="stylesheet" href="{{asset('public/frontend/chef-dashboard/vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection

@section('content')
    <div class="content-body">
        <div class="container-fluid">
             @section('pageHeading')
            <h2>Chef Discount</h2>
            @endsection
             <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="mr-auto d-none d-lg-block">
                        <a class="text-warning d-flex align-items-center mb-3 font-w500" href="{{route('chef-discount.index')}}">
                        <svg class="mr-3" width="24" height="12" viewBox="0 0 24 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.274969 5.14888C0.27525 5.1486 0.275484 5.14827 0.275812 5.14799L5.17444 0.272997C5.54142 -0.0922061 6.135 -0.090847 6.5003 0.276184C6.86555 0.643168 6.86414 1.23675 6.49716 1.60199L3.20822 4.87499H23.0625C23.5803 4.87499 24 5.29471 24 5.81249C24 6.33027 23.5803 6.74999 23.0625 6.74999H3.20827L6.49711 10.023C6.86409 10.3882 6.8655 10.9818 6.50025 11.3488C6.13495 11.7159 5.54133 11.7171 5.17439 11.352L0.275764 6.47699C0.275483 6.47671 0.27525 6.47638 0.274921 6.4761C-0.0922505 6.10963 -0.0910778 5.51413 0.274969 5.14888Z" fill="#ffc200"></path>
                        </svg>
                        Back</a>
                        
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('certificate.index')}}">Promotion</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Promocode</a></li>
                    </ol>
                </div>
            </div>
                <!-- row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">
                                    <h4>Edit Promocode</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                {{ Form::open(['url' => route('chef-discount.update',$chefDiscount->id), 'method'=>'PATCH', 'files'=>true, 'name' => 'frmPromocode', 'id' => 'frmPromocode','class'=>"form-main"]) }}
                                <div class="basic-form">                                   
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label">Promo Code
                                                <span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="promocode" id="promocode" value="{{old('promo_code', $chefDiscount->promo_code)}}" placeholder="" required="" autocomplete="off">
                                                    <a href="javascript:void(0)" name="gencode" id="gencode" onclick="getElementById('promocode').value=randomString();" class="promocode" >Generate Code</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label">Discount
                                                    <span class="text-danger">*</span></label>
                                                    <div class="col-sm-8">
                                                        <div class="input-group mb-2">
                                                            <input type="number" class="form-control" name="discount" id="discount" value="{{old('discount',$chefDiscount->discount)}}" required="" autocomplete="off">
                                                            <div class="input-group-append">
                                                                <div class="input-group-text">%</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label">Total Coupons
                                                <span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="number" class="form-control" name="total_coupons" id="total_coupons" value="{{old('total_coupons', $chefDiscount->total_coupons)}}" placeholder="" required="" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label">Min. Order Value
                                                <span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="number" class="form-control" id="minimum_order_value" name="minimum_order_value" placeholder="" required="" autocomplete="off" value="{{old('minimum_order_value', $chefDiscount->minimum_order_value)}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label">Start Date
                                                <span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                   <input name="start_date" class="datepicker-default form-control" id="start_date" required="" autocomplete="off"  value="{{old('starts_at', $chefDiscount->starts_at)}}">
                                               </div>
                                           </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label">Expire Date
                                                <span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                   <input name="expired_date" class="datepicker-default form-control" id="expired_date" required="" autocomplete="off" value="{{old('expired_at', $chefDiscount->expired_at)}}">
                                               </div>
                                           </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-warning" name="btnSubmit" >Update</button>
                                        <button type="submit" name="btnCancel" class="btn btn-warning" onclick=" window.history.back()">Cancel</button>
                                    </div>
                                </div>
                                {{ Form::close() }}
                            </div>                           
                        </div>
                    </div>
                </div>
        </div>
    </div> 
@endsection
@section('pageScript')
<script src="{{asset('public/backend/bower_components/jquery-ui/jquery-ui.js')}}"></script>
<script src="{{asset('public/backend/common/jquery.validate.js')}}"></script>
<script type="text/javascript" src="{{ asset('public/frontend/js/pages/chef-discount.js')}}"></script>  
@endsection
