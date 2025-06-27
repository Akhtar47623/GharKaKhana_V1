@extends('frontend.chef-dashboard.layouts.app')
@section('pageCss')
<style type="text/css">
.error-help-block {
    color: red;
    display: flex;
}
</style>
@endsection
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            @section('pageHeading')
            <h2>Menu</h2>
            @endsection 
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="mr-auto d-none d-lg-block">
                        <a class="text-warning d-flex align-items-center mb-3 font-w500" href="{{route('menu.index')}}">
                        <svg class="mr-3" width="24" height="12" viewBox="0 0 24 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.274969 5.14888C0.27525 5.1486 0.275484 5.14827 0.275812 5.14799L5.17444 0.272997C5.54142 -0.0922061 6.135 -0.090847 6.5003 0.276184C6.86555 0.643168 6.86414 1.23675 6.49716 1.60199L3.20822 4.87499H23.0625C23.5803 4.87499 24 5.29471 24 5.81249C24 6.33027 23.5803 6.74999 23.0625 6.74999H3.20827L6.49711 10.023C6.86409 10.3882 6.8655 10.9818 6.50025 11.3488C6.13495 11.7159 5.54133 11.7171 5.17439 11.352L0.275764 6.47699C0.275483 6.47671 0.27525 6.47638 0.274921 6.4761C-0.0922505 6.10963 -0.0910778 5.51413 0.274969 5.14888Z" fill="#ffc200"></path>
                        </svg>
                        {{__('sentence.back') }}</a>
                        
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('menu.index')}}">Menu</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">{{__('sentence.addmenu') }}</a></li>
                    </ol>
                </div>
            </div>
                <!-- row -->
                <div class="row">
                    <div class="col-xl-12">
                       <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{__('sentence.addmenu') }}</h4>

                            </div>
                            <div class="card-body">
                                <div class="col-xl-12 col-lg-12">
                                    {{-- <div class="card"> --}}
                                        {{-- <div class="card-header">
                                            <h4 class="card-title">{{__('sentence.itemdetail') }}</h4>
                                        </div> --}}
                                       {{--  <div class="card-body"> --}}
                                            <div class="basic-form">
                                                {{ Form::open(['url' => route('menu.store'), 'method'=>'POST', 'files'=>true, 'name' => 'frmMenu', 'id' => 'frmMenu','class'=>"form-main"]) }}
                                                <div class="form-row">
                                                    <div class="form-group col-md-4">
                                                        <label for="">{{__('sentence.category') }}<span class="text-danger">*</span></label>
                                                        {{ Form::select('item_category',!empty($categories) ? $categories : [], old('item_category'),["required","placeholder"=>__('sentence.select-cat'),"id"=>"item_category","name"=>"item_category","class"=>"form-control"]) }}
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="">{{__('sentence.subcate') }}<span class="text-danger">*</span></label>
                                                        <input type="text" name="item_type" id="item_type" value="" placeholder="{{__('sentence.exsubmenu') }}" required="" autocomplete="off" class="form-control">
                                                        <div id="suggetionbox"></div>
                                                    </div>

                                                    <div class="form-group col-md-4">
                                                        <label for="">{{__('sentence.itemname') }}<span class="text-danger">*</span></label>
                                                        <input type="text" name="item_name" value="" required="" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    
                                                    @if($currency->id==142)
                                                    <div class="form-group col-md-2">
                                                        <label for="" class="rate add-menu-rate">{{__('sentence.rate') }}<span class="text-danger">*</span></label>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                @if(!empty($currency))
                                                                <span class="input-group-text">{{$currency->symbol}}</span>   
                                                                @endif
                                                            </div>
                                                            <input type="number" name="rate"  id="basicRate" value="" required="" class="form-control" onchange="displayRate();">
                                                        </div>
                                                    </div>
                                                     <div class="form-group col-md-2">
                                                        <label for="" class="rate add-menu-rate">{{__('sentence.displayrate') }}</label>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                @if(!empty($currency))
                                                                <span class="input-group-text">{{$currency->symbol}}</span>   
                                                                @endif
                                                            </div>
                                                            <input type="number" id="displayrate" name="displayrate" value="" class="form-control" readonly="" >
                                                            <input type="hidden" id="service_fee_per" name="service_fee_per" value="{{$taxes->service_fee_per}}">
                                                            <input type="hidden" name="tax" id="tax" value="{{$taxes->tax}}">
                                                        </div>
                                                    </div>
                                                    @else
                                                    <div class="form-group col-md-4">
                                                        <label for="" class="rate add-menu-rate">{{__('sentence.rate') }}<span class="text-danger">*</span></label>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                @if(!empty($currency))
                                                                <span class="input-group-text">{{$currency->symbol}}</span>   
                                                                @endif
                                                            </div>
                                                            <input type="number" name="rate" value="" required="" class="form-control">
                                                        </div>
                                                    </div>
                                                    @endif
                                                    <div class="form-group col-md-4">
                                                        <label for="">{{__('sentence.miniorder') }}<span class="text-danger">*</span></label>
                                                        <input type="number" name="minimum_order" value="" placeholder="e.g 1 or 5 or 10"  min="0" required="" class="form-control">
                                                    </div>
                                                
                                                    <div class="form-group col-md-4">
                                                        <label for="">{{__('sentence.maxorder') }}<span class="text-danger">*</span></label>
                                                        <input type="number" name="maximum_order" value="" placeholder="e.g 1 or 5 or 10"  required="" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-4">
                                                        <label for="">{{__('sentence.dietaryres') }}</label>
                                                        <select name="dietary_restriction[]" class="form-control" multiple required="">
                                                            <option value="Blank" selected="">{{__('sentence.blank') }}</option>                 
                                                            <option value="Vegan">{{__('sentence.vegan') }}</option>
                                                            <option value="Vegetarian">{{__('sentence.veg') }}</option>
                                                            <option value="Gluten-Free">{{__('sentence.gluten') }}</option>
                                                            <option value="Kosher">{{__('sentence.kosher') }}</option>
                                                            <option value="Halal">{{__('sentence.halal') }}</option>
                                                            <option value="Lactose-Free">{{__('sentence.lactos') }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="">{{__('sentence.itempic') }}<span class="text-danger">*</span></label>
                                                        <input type="file" name="profile" id="profile" value="" required="" onchange="previewImage(this)" accept="image/*" class="form-control">
                                                    </div>
                                                
                                                    <div class="form-group col-md-4">
                                                        <label for="">{{__('sentence.itemlpic') }}</label>
                                                        <input type="file" name="label" id="label" value="" onchange="previewImage1(this)" accept="image/*" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-4"></div>
                                                    <div class="form-group col-md-4">                                    
                                                        <div id="previewImage" class="m-t-20" style="padding: 20px"></div>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <div id="previewImage1" class="m-t-20" style="padding: 20px"></div>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h4 class="card-title">{{__('sentence.option') }}</h4>
                                                         <a href="{{ route('group.create') }}" class="btn btn-xs btn-rounded btn-outline-warning float-right">{{__('sentence.addgroup') }}
                                                                    </a> 
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="form-row">
                                                            <div class="form-group col-md-4">
                                                                <label for="">{{__('sentence.option') }}</label>
                                                                {{-- <div class="onoffswitch">
                                                                    <input type="checkbox" name="options" class="onoffswitch-checkbox" id="myonoffswitch" tabindex="0">
                                                                    <label class="onoffswitch-label" for="myonoffswitch">
                                                                        <span class="onoffswitch-inner"></span>
                                                                        <span class="onoffswitch-switch"></span>
                                                                    </label>
                                                                </div> --}}
                                                                <label class="switch">
                                                                    <input type="checkbox" name="options" id="myonoffswitch" class="onoffswitch-label">
                                                                    <div class="slider round">
                                                                        <span class="on">YES</span><span class="off">NO</span>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                            
                                                            <div class="form-group col-md-12">
                                                                <div class="option-box">
                                                                    <div class="add-group-btn float-right">
                                                                       
                                                                    </div><br>
                                                                    <div id="inc">
                                                                        <div class="card" id="option-box">
                                                                            <div class="card-body">
                                                                                
                                                                                    <div class="form-row">
                                                                                        <div class="col-md-3 input-group-sm">
                                                                                            <label for="">{{__('sentence.option') }}<span class="text-danger">*</span></label>
                                                                                            <input type="text" value="" name="addmore[0][option]" id="option" required="" class="form-control">
                                                                                        </div>
                                                                                        <div class="col-md-2">
                                                                                            <label for="">{{__('sentence.upcharge') }}</label><br>
                                                                                            <label class="switch">
                                                                                                <input type="checkbox" name="addmore[0][upcharge]" class="togBtn">
                                                                                                <div class="slider round">
                                                                                                    <span class="on">YES</span><span class="off">NO</span>
                                                                                                </div>
                                                                                            </label>
                                                                                        </div>
                                                                                          @if($currency->id==142)
                                                                                          <div class="col-md-3 rate-hide-show">
                                                                                                <label for="" class="rate add-menu-rate">{{__('sentence.rate') }}<span class="text-danger">*</span><span style="font-size: 10px" class="text-danger display-option-rate"></span></label>
                                                                                                <div class="input-group input-group-sm mb-3">
                                                                                                    <div class="input-group-prepend">
                                                                                                    @if(!empty($currency))
                                                                                                    <span class="input-group-text">{{$currency->symbol}}</span>   
                                                                                                    @endif                                                      </div>
                                                                                                    <input type="number" name="addmore[0][rate]"  required="" class="form-control option-rate">                            
                                                                                                    <input type="hidden" id="currency" value="{{!empty($currency)?$currency->symbol:''}}">                              
                                                                                                </div>
                                                                                            </div>
                                                                                            @else
                                                                                            <div class="col-md-3 rate-hide-show">
                                                                                                <label for="" class="rate add-menu-rate">{{__('sentence.rate') }}<span class="text-danger">*</span></label>
                                                                                                <div class="input-group input-group-sm mb-3">
                                                                                                    <div class="input-group-prepend">
                                                                                                    @if(!empty($currency))
                                                                                                    <span class="input-group-text">{{$currency->symbol}}</span>   
                                                                                                    @endif                                                </div>
                                                                                                    <input type="number" name="addmore[0][rate]" value="" required="" class="form-control">                            
                                                                                                    <input type="hidden" id="currency" value="{{!empty($currency)?$currency->symbol:''}}">                              
                                                                                                </div>
                                                                                            </div>
                                                                                            @endif
                                                                                        
                                                                                        <div class="col-md-2">
                                                                                            <label for="">{{__('sentence.status') }}</label>
                                                                                            <label class="switch">
                                                                                                <input type="checkbox" name="addmore[0][status]">
                                                                                                <div class="slider round">
                                                                                                    <span class="on">{{__('sentence.available')}}</span><span class="off">{{__('sentence.navailable')}}</span>
                                                                                                </div>
                                                                                            </label>
                                                                                        </div>
                                                                                        <div class="col-md-2">
                                                                                            <label for="">{{__('sentence.group') }}<span class="text-danger">*</span></label>
                                                                                            <select name="addmore[0][group]" class="form-control-sm" required="">
                                                                                                @if(!empty($groups))
                                                                                                    <option value="" selected="">{{__('sentence.select-grp')}}</option>
                                                                                                    @foreach($groups as $g)
                                                                                                    <option value="{{$g->group_name}}">{{$g->group_name}}</option>
                                                                                                    @endforeach
                                                                                                @endif
                                                                                            </select>
                                                                                            
                                                                                        </div>
                                                                                    </div>
                                                                                
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="add-remove-btn" >
                                                                        <a href="javascript:;" title="" class="add-item"><i class="fas fa-plus"></i> {{__('sentence.addmo') }}</a>
                                                                        <a href="javascript:;" title="" class="remove-item" ><i class="fa fa-minus" aria-hidden="true"></i> {{__('sentence.removeo') }}</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="">{{__('sentence.itemv') }}</label>
                                                                
                                                                <label class="switch">
                                                                    <input type="checkbox" name="item_visibility">
                                                                    <div class="slider round">
                                                                        <span class="on">{{__('sentence.on')}}</span><span class="off">{{__('sentence.off')}}</span>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="">{{__('sentence.items') }}</label>
                                                                
                                                                <label class="switch">
                                                                    <input type="checkbox" name="status">
                                                                    <div class="slider round">
                                                                        <span class="on">{{__('sentence.available')}}</span><span class="off">{{__('sentence.navailable')}}</span>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-12">
                                                                <label for="">{{__('sentence.desc') }}<span class="text-danger">*</span></label>
                                                                <textarea name="item_description" id="" required="" class="form-control" rows=4></textarea>
                                                            </div>                                                    
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card">
                                                    <div class="card-header">
                                                        <h4 class="card-title">{{__('sentence.nutrition') }}</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="form-row">
                                                            <div class="form-group col-md-4">
                                                                <label for="">{{__('sentence.servicepc') }}</label>
                                                                <input type="text" name="service_per_container" value="" class="form-control">
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="">{{__('sentence.rounding') }}</label>
                                                                <select name="rounding" class="form-control">
                                                                    <option value="0" selected="">{{__('sentence.defualt') }}</option>  
                                                                    <option value="1">{{__('sentence.usually') }}</option>
                                                                    <option value="2">{{__('sentence.varied') }}</option>                                         
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="">{{__('sentence.qty') }}</label>
                                                                <input type="text" name="quantity" value="" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-4">
                                                                <label for="">{{__('sentence.unit') }}</label>
                                                                <input type="text" name="units" value="" class="form-control">
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="">{{__('sentence.servicesize') }}</label>
                                                                <input type="text" name="serving_size" value="" class="form-control">
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="">{{__('sentence.servicesu') }}</label>
                                                                <select name="serving_size_unit" class="form-control">
                                                                    <option value="gm" selected="">{{__('sentence.grams') }}</option>                  
                                                                    <option value="ml">{{__('sentence.mililiter') }}</option>                                
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-4">
                                                                <label for="">{{__('sentence.cal') }}</label>
                                                                <input type="text" name="calories" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control">
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="">{{__('sentence.totalf') }}</label>
                                                                <input type="text" name="total_fat" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control">
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="">{{__('sentence.saturatedf') }}</label>
                                                                <input type="text" name="saturated_fat" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-4">
                                                                <label for="">{{__('sentence.transf') }}</label>
                                                                <input type="text" name="trans_fat" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control">
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="">{{__('sentence.cholesterol') }}</label>
                                                                <input type="text" name="cholesterol" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control">
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="">{{__('sentence.sodium') }}</label>
                                                                <input type="text" name="sodium" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-4">
                                                                <label for="">{{__('sentence.totalc') }}</label>
                                                                <input type="text" name="total_carbohydrates" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control">
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="">{{__('sentence.dietaryf') }}</label>
                                                                <input type="text" name="dietry_fiber" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control">
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="">{{__('sentence.sugar') }}</label>
                                                                <input type="text" name="sugars" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-4">
                                                                <label for="">{{__('sentence.addeds') }}</label>
                                                                <input type="text" name="added_sugar" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control">
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="">{{__('sentence.protien') }}</label>
                                                                <input type="text" name="protein" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> 

                                                <div class="card">
                                                    <div class="card-header">
                                                        <h4 class="card-title">{{__('sentence.schedule') }}</h4>
                                                    </div>
                                                    <div class="card-body">

                                                        <div class="row">
                                                            <div class="form-group col-md-2">
                                                                <div class="weekDays-selector">
                                                                    <input type="checkbox" id="weekday-mon" name="mon" class="weekday" {{!empty($ChefSchedule)?$ChefSchedule->mon==1?'checked':'':''}}>
                                                                    <label for="weekday-mon">{{__('sentence.mon') }}</label>
                                                                    <div class="time-sec">
                                                                        <label for="">{{__('sentence.startt') }}</label>
                                                                        <input type="time" id="mon_start_time" name="mon_start_time" required="" value="{{!empty($ChefSchedule)?$ChefSchedule->mon_start_time:''}}">
                                                                        <label for="">{{__('sentence.endt') }}</label>
                                                                        <input type="time" id="mon_end_time" name="mon_end_time" required="" value="{{!empty($ChefSchedule)?$ChefSchedule->mon_end_time:''}}">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group col-md-2">
                                                                <div class="weekDays-selector">
                                                                    <input type="checkbox" id="weekday-tue" name="tue" class="weekday" 
                                                                        {{!empty($ChefSchedule)?$ChefSchedule->tue==1?'checked':'':''}}>
                                                                    <label for="weekday-tue">{{__('sentence.tue') }}</label>
                                                                    <div class="time-sec">
                                                                        <label for="">{{__('sentence.startt') }}</label>
                                                                        <input type="time" id="tue_start_time" name="tue_start_time" required="" value="{{!empty($ChefSchedule)?$ChefSchedule->tue_start_time:''}}">
                                                                        <label for="">{{__('sentence.endt') }}</label>
                                                                        <input type="time" id="tue_end_time" name="tue_end_time" required="" value="{{!empty($ChefSchedule)?$ChefSchedule->tue_end_time:''}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-2">
                                                                <div class="weekDays-selector">
                                                                    <input type="checkbox" id="weekday-wed" name="wed" class="weekday" {{!empty($ChefSchedule)?$ChefSchedule->wed==1?'checked':'':''}}>
                                                                        <label for="weekday-wed">{{__('sentence.wends') }}</label>
                                                                            <div class="time-sec">
                                                                            <label for="">{{__('sentence.startt') }}</label>
                                                                            <input type="time" id="wed_start_time" name="wed_start_time" required="" value="{{!empty($ChefSchedule)?$ChefSchedule->wed_start_time:''}}">
                                                                            <label for="">{{__('sentence.endt') }}</label>
                                                                            <input type="time" id="wed_end_time" name="wed_end_time" required="" value="{{!empty($ChefSchedule)?$ChefSchedule->wed_end_time:''}}">
                                                                        </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-2">
                                                                <div class="weekDays-selector">
                                                                    <input type="checkbox" id="weekday-thu" name="thu" class="weekday" {{!empty($ChefSchedule)?$ChefSchedule->thu==1?'checked':'':''}}>
                                                                        <label for="weekday-thu">{{__('sentence.thu') }}</label>
                                                                            <div class="time-sec">
                                                                                <label for="">{{__('sentence.startt') }}</label>
                                                                                <input type="time" id="thu_start_time" name="thu_start_time" required="" value="{{!empty($ChefSchedule)?$ChefSchedule->thu_start_time:''}}">
                                                                                <label for="">{{__('sentence.endt') }}</label>
                                                                                <input type="time" id="thu_end_time" name="thu_end_time" required="" value="{{!empty($ChefSchedule)?$ChefSchedule->thu_end_time:''}}">
                                                                            </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-2">
                                                                <div class="weekDays-selector">
                                                                    <input type="checkbox" id="weekday-fri" name="fri" class="weekday" {{!empty($ChefSchedule)?$ChefSchedule->fri==1?'checked':'':''}}>
                                                                        <label for="weekday-fri">{{__('sentence.fri') }}</label>
                                                                        <div class="time-sec">
                                                                            <label for="">{{__('sentence.startt') }}</label>
                                                                            <input type="time" id="fri_start_time" name="fri_start_time" required="" value="{{!empty($ChefSchedule)?$ChefSchedule->fri_start_time:''}}">
                                                                            <label for="">{{__('sentence.endt') }}</label>
                                                                            <input type="time" id="fri_end_time" name="fri_end_time" required="" value="{{!empty($ChefSchedule)?$ChefSchedule->fri_end_time:''}}">
                                                                        </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-2">
                                                                <div class="weekDays-selector">
                                                                    <input type="checkbox" id="weekday-sat" name="sat" class="weekday" {{!empty($ChefSchedule)?$ChefSchedule->sat==1?'checked':'':''}}>
                                                                        <label for="weekday-sat">{{__('sentence.sat') }}</label>
                                                                        <div class="time-sec">
                                                                            <label for="">{{__('sentence.startt') }}</label>
                                                                            <input type="time" id="sat_start_time" name="sat_start_time" required="" value="{{!empty($ChefSchedule)?$ChefSchedule->sat_start_time:''}}">
                                                                            <label for="">{{__('sentence.endt') }}</label>
                                                                            <input type="time" id="sat_end_time" name="sat_end_time" required="" value="{{!empty($ChefSchedule)?$ChefSchedule->sat_end_time:''}}">
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group col-md-2">
                                                                <div class="weekDays-selector">
                                                                    <input type="checkbox" id="weekday-sun" name="sun" class="weekday" {{!empty($ChefSchedule)?$ChefSchedule->sun==1?'checked':'':''}}>
                                                                        <label for="weekday-sun">{{__('sentence.sun') }}</label>
                                                                        <div class="time-sec">
                                                                            <label for="">{{__('sentence.startt') }}</label>
                                                                            <input type="time" id="sun_start_time" name="sun_start_time" required="" value="{{!empty($ChefSchedule)?$ChefSchedule->sun_start_time:''}}">
                                                                            <label for="">{{__('sentence.endt') }}</label>
                                                                            <input type="time" id="sun_end_time" name="sun_end_time" required="" value="{{!empty($ChefSchedule)?$ChefSchedule->sun_end_time:''}}">
                                                                        </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-2">
                                                                <label for="">{{__('sentence.recurrung') }}</label>
                                                                
                                                                <label class="switch">
                                                                    <input type="checkbox" name="recurring" id="myonoffswitch" class=" onoffswitch-label" {{!empty($ChefSchedule)?$ChefSchedule->recurring ==1 ? 'checked' : '':''}}>
                                                                    <div class="slider round">
                                                                        <span class="on">Yes</span><span class="off">No</span>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                            <div class="form-group col-md-3">
                                                                <label for="">{{__('sentence.leadt') }}<span class="text-danger">*</span></label>
                                                               
                                                                {{ Form::select('lead_time',['0'=>'0 '.__('sentence.day'),'1'=>'1 '.__('sentence.day'),'2'=>'2 '.__('sentence.days'),'3'=>'3 '.__('sentence.days'),'4'=>'4 '.__('sentence.days'),'5'=>'5 '.__('sentence.days'),'6'=>'6 '.__('sentence.days'),'7'=>'7 '.__('sentence.days')], !empty($ChefSchedule)?$ChefSchedule->lead_time:'',["required","placeholder"=>''.__('sentence.leadt'),"id"=>"lead_time","name"=>"lead_time","class"=>"form-control"]) }}
                                                            </div>

                                                        </div> 
                                                    </div>
                                                </div>

                                                    <button type="submit" name="btnSubmit" class="btn btn-warning">{{__('sentence.add') }}</button>
                                                    <img id="loader" src="{{ asset('public/frontend/images/loader.gif')}}" alt="" />
                                                    <button type="button" name="btnCancel" class="btn btn-warning" onclick=" window.history.back()">{{__('sentence.cancel') }}</button> 
                                                        {{ Form::close() }}                                        
                                            </div>
                                        {{-- </div> --}}
                                   {{--  </div> --}}
                                </div>
                                
                                
                                    
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
@endsection
@section('pageScript')
<script src="{{asset('public/backend/common/jquery.validate.js')}}"></script>
<script type="text/javascript" src="{{ asset('public/frontend/js/pages/menu.js')}}"></script>
<script>
jQuery(document).ready( function () {

    var cnt=0;
    $(".add-item").click( function(e) {        
        cnt++;       
        e.preventDefault();
        $("#inc").append('<div class="card" id="option-box'+cnt+'">\
        <div class="card-body">\
        <div class="form-row">\
        <div class="col-md-3 input-group-sm">\
        <label for="">{{__("sentence.option") }}<span class="text-danger">*</span></label>\
        <input type="text" value="" name="addmore['+cnt+'][option]" id="option'+cnt+'" required="" class="form-control">\
        </div>\
        <div class="col-md-2">\
        <label for="">{{__("sentence.upcharge") }}</label><br>\
        <label class="switch">\
        <input type="checkbox" name="addmore['+cnt+'][upcharge]" class="togBtn">\
        <div class="slider round">\
        <span class="on">YES</span><span class="off">NO</span>\
        </div>\
        </label>\
        </div>\
        <div class="col-md-3 rate-hide-show">\
         <label for="" class="rate add-menu-rate">{{__("sentence.rate") }}<span class="text-danger"></label>\
        <div class="input-group input-group-sm mb-3">\
        <div class="input-group-prepend">\
        <span class="input-group-text">'+$('#currency').val()+'</span> \  </div>\
        <input type="number" name="addmore['+cnt+'][rate]"  required="" class="form-control">\
        </div>\
        </div>\
        <div class="col-md-2">\
        <label for="">{{__("sentence.status") }}</label>\
        <label class="switch">\
        <input type="checkbox" name="addmore['+cnt+'][status]">\
        <div class="slider round">\
        <span class="on">{{__('sentence.available')}}</span><span class="off">{{__('sentence.navailable')}}</span>\
        </div>\
        </label>\
        </div>\
        <div class="col-md-2">\
        <label for="">{{__("sentence.group") }}<span class="text-danger">*</span></label>\
        <select name="addmore['+cnt+'][group]" required="" class="form-control-sm" style="border-color: #dddddd;color: #666666;">\
        <option value="">{{__('sentence.select-grp')}}</option>\
        @if(!empty($groups))\
        @foreach($groups as $g)\
        <option value="{{$g->id}}">{{$g->group_name}}</option>\
        @endforeach\
        @endif\
        </select>\
        </div>\
        </div>\
        </div>\
        </div>');

        if(cnt>0){
            $(".remove-item").show();
        }
        return false;
    });
    $(".remove-item").click( function(e) {
        $( "#option-box"+cnt ).remove();
        if(cnt==1){
            cnt=0;
            $(this).hide();
        }else{
            cnt--;
        }
        return false;
    });
    $("#item_category").change(function () {
        var category = $(this).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        if(category != '')
        {            
            $.ajax({
                url:"{{ url('suggetion') }}",
                method:"POST",
                data:{category:category},
                success:function(data){
                    if(data){
                        $('#suggetionbox').fadeIn();  
                        $('#suggetionbox').html(data);
                    }
                }
            });
        }
    });
    $(document).on('click', '.subcat-dropdown-menu li', function(){  
        $('#item_type').val($(this).text());  
        $('#suggetionbox').fadeOut();  
    });
    $(document).on('blur', '#item_type', function(){
        $('#suggetionbox').fadeOut(); 
    });

});
    
</script>
@endsection

