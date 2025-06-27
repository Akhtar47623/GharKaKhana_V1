@extends('frontend.chef-dashboard.layouts.app')
@section('content')
<div class="content-body">
    <div class="container-fluid">
      @section('pageHeading')
      <h2>{{__('sentence.picdel') }}</h2>
      @endsection 

      <!-- row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h4>{{__('sentence.addpickup') }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                         {{ Form::open(['url' => route('pickup-delivery.store'), 'method'=>'POST', 'files'=>true, 'name' => 'frmPickupDelivery', 'id' => 'frmPickupDelivery','class'=>"form-main"]) }}
                        <div class="basic-form">
                           
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="">{{__('sentence.picdel') }}<span class="text-danger">*</span></label>
                                    <select  name="options" id="pickup_delivery" required="" class="form-control">
                                        <option value="" selected="">{{__('sentence.pso') }}</option>
                                        <option value="1">{{__('sentence.piconly') }}</option>
                                        <option value="2">{{__('sentence.picdelb') }}</option>
                                        <option value="3">{{__('sentence.delonly') }} </option>
                                    </select>
                                    <input type="hidden" id="optionCount" value={{!empty($count)?$count:0}}>
                                </div>
                            </div>
                            <div id="pickup" style="display: none">
                                <div class="form-row" >
                                    
                                    <div class="form-group col-md-4">
                                        <h4 style=" font-weight: 600;font-size: 20px;line-height: 24px;color: #ffc200;padding: 0 0 10px 0;margin: 0 0 0 0;">{{__('sentence.picd') }}</h4>
                                        <label>
                                            <a href="javascript:void(0)" name="btnSetDefaultAddress" id="btnSetDefaultAddress" style="color: #ffc200;" class="btn btn-sm btn-rounded btn-outline-light">{{__('sentence.setsa') }}
                                            </a>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label >{{__('sentence.state') }}<span class="text-danger">*</span></label>
                                        {{ Form::select('state',!empty($states) ? $states : [], old(),["required","placeholder"=>'Select State',"id"=>"state","name"=>"state","class"=>"form-control"]) }}                                   
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>{{__('sentence.city') }}<span class="text-danger">*</span></label>
                                        <select name="city" id="city" class="form-control" required="">
                                            <option>{{__('sentence.selectcity') }}</option>
                                        </select>
                                    </div>
                                                                
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label>{{__('sentence.address') }}<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="address" id="address" placeholder="{{__('sentence.addent') }}" required="">                                   
                                    </div>
                                    
                                                                
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                       <label>{{__('sentence.zipcode') }}<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="zipcode" id="zipcode" placeholder="{{__('sentence.zip') }}" required="">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>{{__('sentence.mobile') }}<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="mobile" id="mobile" placeholder="{{__('sentence.mo') }}" required="">                                   
                                    </div>
                                                                                                    
                                </div>
                            </div>

                            <div id="delivery" style="display: none">
                                <h4 style=" font-weight: 600;font-size: 20px;line-height: 24px;color: #ffc200;padding: 0 0 10px 0;margin: 0 0 0 0;">{{__('sentence.deld') }}</h4>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>{{__('sentence.delo') }}</label>                                              
                                        <select name="delivery_by" required="">
                                            <option value="1">{{__('sentence.chefnm') }}</option>
                                            {{-- <option value="2">{{__('sentence.delcom') }}</option> --}}
                                        </select>
                                                                                                 
                                    </div>
                                </div>
                                
                                <div class="distance-sec">
                                    <div id="inc">
                                        <div id="option">

                                            <h6>{{__('sentence.dist') }}</h6>
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label class="col-lg-4 col-form-label" >{{__('sentence.from') }}
                                                    </label>
                                                    <div class="input-group mb-2">
                                                        <input type="number" class="form-control" name="addmore[0][min_miles]" id="miles0" class="miles-input" required="" value="0" readonly>
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">{{__('sentence.miles') }}</div>
                                                        </div> 
                                                    </div>     
                                                </div>
                                                
                                                <div class="form-group col-md-4">
                                                    <label class="col-lg-4 col-form-label" >{{__('sentence.to') }}
                                                    </label>
                                                    <div class="input-group mb-2">
                                                        <input type="number" class="form-control" name="addmore[0][max_miles]" id="mmiles0" class="miles-input" required="" min='0'>
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">{{__('sentence.miles') }}</div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label class="col-lg-4 col-form-label" >{{__('sentence.rate') }}
                                                    </label>
                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">{{!empty($currency)?$currency->symbol:''}}</div>
                                                        </div>
                                                        <input type="number" name="addmore[0][min_miles_rate]" class="form-control"class="dollar-sign" id="rate" required="">

                                                    </div>
                                                    <input type="hidden" id="currency" value="{{!empty($currency)?$currency->symbol:''}}">     
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="add-remove-btn">
                                        <a href="javascript:;" title="" class="add-distance" style="color: #ffc200;"><i class="fas fa-plus"></i> {{__('sentence.addmo') }}</a>
                                        <a href="javascript:;" title="" class="remove-distance" style="display:none;float: right;color: #ffc200;"><i class="fas fa-minus"></i> {{__('sentence.removeo') }}</a>
                                    </div>
                                </div>                    
                               
                            </div> <br><br>
                             <button type="submit" class="btn btn-warning" name="btnSubmit">{{__('sentence.add') }}</button>
                        <button type="submit" name="btnCancel" class="btn btn-warning" onclick=" window.history.back()">{{__('sentence.cancel') }}</button>
                        
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
<script src="{{asset('public/backend/common/jquery.validate.js')}}"></script>
<script type="text/javascript" src="{{ asset('public/frontend/js/pages/pickup-delivery.js')}}"></script>
<script>
    jQuery(document).ready( function () {
    var count=$("#optionCount").val();
    var cnt=count!=0?count-1:0;
    var cityId='';
    $(".add-distance").click( function(e) {
        var m = $("#mmiles"+cnt).val();
        
        if(m==''){
            return false;
        }
        $("#mmiles"+cnt).attr('readonly', true);
        cnt++;
        e.preventDefault();
        
        $("#inc").append('<div id="option'+cnt+'">\
            <div class="form-row">\
            <div class="form-group col-md-4">\
            <label>{{__("sentence.gthan")}}\
            </label>\
            <div class="input-group mb-2">\
            <input type="number" class="form-control" name="addmore['+cnt+'][min_miles]" id="miles'+cnt+'" value="'+m+'" class="miles-input" required="" value="0" readonly>\
            <div class="input-group-append">\
            <div class="input-group-text">Miles</div></div></div></div>\
            <div class="form-group col-md-4">\
            <label >{{__('sentence.to') }}\
            </label>\
            <div class="input-group mb-2">\
            <input type="number" class="form-control" name="addmore['+cnt+'][max_miles]" id="mmiles'+cnt+'" min="'+m+'" class="miles-input" required="">\
            <div class="input-group-append">\
            <div class="input-group-text">Miles</div>\
            </div></div></div>\
            <div class="form-group col-md-4">\
            <label>{{__('sentence.rate') }}\
            </label>\
            <div class="input-group mb-2">\
            <div class="input-group-prepend">\
            <div class="input-group-text">'+$('#currency').val()+'</div>\
            </div>\
            <input type="number" name="addmore['+cnt+'][min_miles_rate]" class="form-control"class="dollar-sign" id="rate" required="">\
            </div>\
            </div>\
            </div>\
            </div>');
        if(cnt>0){
            $(".remove-distance").show();
        }
        return false;
    });
    $(".remove-distance").click( function(e) {
        $( "#option"+cnt ).remove();

        if(cnt==1){
            cnt=0;
            $("#mmiles"+cnt).attr('readonly', false);
            $(this).hide();
        }else{
            cnt--;
            $("#mmiles"+cnt).attr('readonly', false);
        }
        return false;
    });
    if(cnt>0){
            $(".remove-distance").show();
        }
    
      
});
</script>
@endsection
