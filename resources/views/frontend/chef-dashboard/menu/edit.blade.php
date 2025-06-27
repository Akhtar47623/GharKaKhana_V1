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
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">{{__('sentence.editmenu') }}</a></li>
                    </ol>
                </div>
            </div>
                <!-- row -->
                <div class="row">
                    <div class="col-xl-12">
                       <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{__('sentence.editmenu') }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="col-xl-12 col-lg-12">
                                    {{-- <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">{{__('sentence.itemdetail') }}</h4>
                                        </div> --}}
                                        {{-- <div class="card-body"> --}}
                                            <div class="basic-form">
                                                {{ Form::open(['url' => route('menu.update',$menuItemData->id), 'method'=>'PATCH', 'files'=>true, 'name' => 'frmMenu', 'id' => 'frmMenu','class'=>"form-main"]) }}
                                                <div class="form-row">
                                                    <div class="form-group col-md-4">
                                                        <label for="">{{__('sentence.category') }}<span class="text-danger">*</span></label>
                                                        {{ Form::select('item_category',!empty($categories) ? $categories : [], $menuItemData->item_category,["required","placeholder"=>__('sentence.select-cat'),"id"=>"item_category","name"=>"item_category","class"=>"form-control"]) }}
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="">{{__('sentence.subcate') }}<span class="text-danger">*</span></label>
                                                        <input type="text" name="item_type" id="item_type" value="{{$menuItemData->item_type}}" placeholder="{{__('sentence.exsubmenu') }}" required="" autocomplete="off" class="form-control">
                                                        <div id="suggetionbox"></div>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="">{{__('sentence.itemname') }}<span class="text-danger">*</span></label>
                                                        <input type="text" name="item_name" value="{{$menuItemData->item_name}}" required="" class="form-control">
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
                                                            <input type="number" name="rate" value="{{$menuItemData->rate}}" required=""  id="basicRate"  class="form-control" onchange="displayRate();">
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
                                                            
                                                        </div>
                                                    </div>
                                                    <input type="hidden" id="service_fee_per" name="service_fee_per" value="{{$taxes->service_fee_per}}">
                                                    <input type="hidden" name="tax" id="tax" value="{{$taxes->tax}}">
                                                    @else
                                                    <div class="form-group col-md-4">
                                                        <label for="" class="rate add-menu-rate">{{__('sentence.rate') }}<span class="text-danger">*</span></label>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                @if(!empty($currency))
                                                                <span class="input-group-text">{{$currency->symbol}}</span> 
                                                                @endif                                                      
                                                            </div>
                                                            <input type="number" name="rate" value="{{$menuItemData->rate}}" required="" class="form-control">                                                 
                                                        </div>
                                                    </div>
                                                    @endif

                                                    <div class="form-group col-md-4">
                                                        <label for="">{{__('sentence.miniorder') }}<span class="text-danger">*</span></label>
                                                        <input type="number" name="minimum_order" value="{{$menuItemData->minimum_order}}" placeholder="{{__('sentence.exmini') }}"  min="0" required="" class="form-control">
                                                    </div>
                                                
                                                    <div class="form-group col-md-4">
                                                        <label for="">{{__('sentence.maxorder') }}<span class="text-danger">*</span></label>
                                                        <input type="number" name="maximum_order" value="{{$menuItemData->maximum_order}}" placeholder="{{__('sentence.exmini') }}"  required="" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-4">
                                                        <label for="">{{__('sentence.dietaryres') }}</label>
                                                        {{ Form::select('dietary_restriction',['Blank'=>__('sentence.blank'),'Vegan'=>__('sentence.vegan'),'Vegetarian'=>__('sentence.veg'),'Gluten-Free'=>__('sentence.gluten'),'Kosher'=>__('sentence.kosher'),'Halal'=>__('sentence.halal'),'Lactose-Free'=>__('sentence.lactos') ], $selDietary,["required","class"=>"select2","multiple"=>"multiple","id"=>"dietary_restriction","name"=>"dietary_restriction[]","class"=>"form-control"]) }}

                                                        
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="">{{__('sentence.itempic') }}<span class="text-danger">*</span></label>
                                                        <input type="file" name="profile" id="profile" value="" onchange="previewImage(this)" accept="image/*" class="form-control">
                                                        <input type="hidden" name="oldImage" value="{{$menuItemData->photo}}">
                                                    </div>
                                                
                                                    <div class="form-group col-md-4">
                                                        <label for="">{{__('sentence.itemlpic') }}</label>
                                                        <input type="file" name="label" id="label" value="" onchange="previewImage1(this)" accept="image/*" class="form-control">
                                                        <input type="hidden" name="oldImage1" value="{{$menuItemData->label_photo}}">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-4">
                                                        
                                                    </div>
                                                    
                                                    <div class="form-group col-md-4">
                                                        <div id="previewImage" class="m-t-20" style="padding: 10px">
                                                            @if(isset($menuItemData))
                                                            <img src="{{ asset('public/frontend/images/menu/'.$menuItemData->photo) }}" height="80px" width="80px" alt="Menu Photo">
                                                            @endif   
                                                        </div> 
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <div id="previewImage1" class="m-t-20" style="padding: 10px">
                                                            @if($menuItemData->label_photo!=NULL)
                                                            <img src="{{ asset('public/frontend/images/menu/'.$menuItemData->label_photo) }}" height="80px" width="80px" alt="Label Photo">
                                                            @endif   
                                                        </div>
                                                    </div>
                                                </div> 

                                                <div class="card">
                                                    <div class="card-header">
                                                        <h4 class="card-title">{{__('sentence.option') }}</h4>
                                                    </div>
                                                    <div class="card-body">                                            
                                                        <div class="form-row">
                                                            <div class="form-group col-md-4">
                                                                <input type="hidden" id="noOfOption" value="{{!empty($itemCount)?$itemCount:0}}">
                                                                <label for="">Option</label>
                                                                <!-- <div class="onoffswitch">
                                                                    <input type="checkbox" name="options" class="onoffswitch-checkbox" id="myonoffswitch" tabindex="0" <?php echo $menuItemData->options ==1 ? 'checked' : ''?>>
                                                                    <label class="onoffswitch-label" for="myonoffswitch">
                                                                        <span class="onoffswitch-inner"></span>
                                                                        <span class="onoffswitch-switch"></span>
                                                                    </label>
                                                                </div> -->
                                                                <label class="switch">
                                                                    <input type="checkbox" name="options" id="myonoffswitch" class="onoffswitch-label" <?php echo $menuItemData->options ==1 ? 'checked' : ''?>>
                                                                    <div class="slider round">
                                                                        <span class="on">YES</span><span class="off">NO</span>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <div class="option-box <?php echo $menuItemData->options ==1 ? 'active' : ''?>">
                                                                    
                                                                    <div id="inc">
                                                                        @php $c=1; @endphp
                                                                        @foreach($itemOptionData as $value)

                                                                        <div class="card option-box-wrap" id="option-box{{$c}}">
                                                                            <div class="card-body">
                                                                                
                                                                                <div class="form-row">
                                                                                    <div class="col-md-3 input-group-sm">
                                                                                        <label for="">{{__('sentence.option') }}</label>
                                                                                        <input type="hidden" name="addmore[{{$c}}][id]" id="addmore{{$c}}" value="{{$value->id}}">
                                                                                        <input type="text" value="{{$value->option}}" name="addmore[{{$c}}][option]" id="option{{$c}}" required="" class="form-control">
                                                                                    </div>
                                                                                    <div class="col-md-2">
                                                                                        <label for="">{{__('sentence.upcharge') }}</label><br>
                                                                                            <label class="switch">
                                                                                            <input type="checkbox" name="addmore[{{$c}}][upcharge]" class="togBtn" <?php 
                                                                                                echo !empty($value['upcharge'])
                                                                                                ?
                                                                                                $value['upcharge'] ==1 ? 'checked' : ''
                                                                                                :
                                                                                                ''
                                                                                                ?>>
                                                                                            <div class="slider round">
                                                                                                <span class="on">YES</span><span class="off">NO</span>
                                                                                            </div>
                                                                                        </label>
                                                                                    </div>
                                                                                    @if($currency->id==142)
                                                                                    <div class="col-md-3 rate-hide-show <?php 
                                                                                        echo !empty($value['upcharge'])?$value['upcharge'] ==1 ? 'active' : '':''?>">
                                                                                        <label for="" class="rate ">{{__('sentence.rate') }}<span class="text-danger">*</span>
                                                                                            <?php
                                                                                            $disOptRate=$value['rate']+($value['rate']*$taxes->service_fee_per/100);
                                                                                            $disOptRate=$disOptRate+($disOptRate*$taxes->tax/100);
                                                                                            ?>
                                                                                        <span style="font-size: 10px" class="text-danger display-option-rate">
                                                                                            (With Comm. & Tax: {{$disOptRate}})</span></label>
                                                                                        <div class="input-group input-group-sm mb-3">
                                                                                            <div class="input-group-prepend">
                                                                                                @if(!empty($currency))
                                                                                                <span class="input-group-text ">{{$currency->symbol}}</span>   
                                                                                                @endif                                                          
                                                                                            </div>
                                                                                            <input type="number" name="addmore[{{$c}}][rate]" value="{{!empty($value['rate'])?$value['rate']:''}}" required="" class="form-control option-rate" >                            
                                                                                                                        
                                                                                        </div>
                                                                                    </div>
                                                                                    @else
                                                                                    <div class="col-md-3 rate-hide-show <?php 
                                                                                        echo !empty($value['upcharge'])?$value['upcharge'] ==1 ? 'active' : '':''?>">
                                                                                        <label for="" class="rate">{{__('sentence.rate') }}<span class="text-danger">*</span></label>
                                                                                        <div class="input-group input-group-sm mb-3">
                                                                                            <div class="input-group-prepend">
                                                                                                @if(!empty($currency))
                                                                                                <span class="input-group-text">{{$currency->symbol}}</span>   
                                                                                                @endif                                                          
                                                                                            </div>
                                                                                            <input type="number" name="addmore[{{$c}}][rate]" value="{{!empty($value['rate'])?$value['rate']:''}}" required="" class="form-control">                            
                                                                                                                        
                                                                                        </div>
                                                                                    </div>
                                                                                    @endif

                                                                                    <div class="col-md-2">
                                                                                        <label for="">{{__('sentence.status') }}</label>
                                                                                        <label class="switch">
                                                                                            <input type="checkbox" name="addmore[{{$c}}][status]" <?php echo !empty($value['status'])?$value['status'] ==1 ? 'checked' : '':''?>>
                                                                                            <div class="slider round">
                                                                                                <span class="on">{{__('sentence.available')}}</span><span class="off">{{__('sentence.navailable')}}</span>
                                                                                            </div>
                                                                                        </label>
                                                                                    </div>
                                                                                    
                                                                                    <div class="col-md-2">
                                                                                        <label for="">{{__('sentence.group') }}<span class="text-danger">*</span></label>
                                                                                        <select name="addmore[{{$c}}][group]" class="form-control-sm">
                                                                                            @if($groups)
                                                                                            @foreach($groups as $g) 
                                                                                            <option value="">{{__('sentence.select-grp')}}</option>                                           
                                                                                            <option value="{{$g->id}}"
                                                                                                <?php
                                                                                                if($g->id == $value['group_id'])
                                                                                                    echo "selected"
                                                                                                ?>
                                                                                                >{{$g->group_name}}</option>
                                                                                                @endforeach
                                                                                                @endif
                                                                                            </select>

                                                                                        </div>
                                                                                    </div>
                                                                                
                                                                            </div>
                                                                            <?php $c++; ?>
                                                                            
                                                                        </div>
                                                                        @endforeach
                                                                        <input type="hidden" id="currency" value="{{!empty($currency)?$currency->symbol:''}}">
                                                                    </div>                                                            
                                                                    <div class="add-remove-btn">
                                                                        <a href="javascript:;" title="" class="add-item"><i class="fas fa-plus"></i> {{__('sentence.addmo') }}</a>
                                                                        <a href="javascript:;" title="" class="remove-item" style="display:none"><i class="fa fa-minus" aria-hidden="true"></i> {{__('sentence.removeo') }}</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="">{{__('sentence.itemv') }}</label>
                                                                
                                                                <label class="switch">
                                                                    <input type="checkbox" name="item_visibility"  <?php echo $menuItemData->item_visibility ==1 ? 'checked' : ''?>>
                                                                    <div class="slider round">
                                                                        <span class="on">{{__('sentence.on')}}</span><span class="off">{{__('sentence.off')}}</span>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="">{{__('sentence.items') }}</label>
                                                                
                                                                <label class="switch">
                                                                    <input type="checkbox" name="status" <?php echo $menuItemData->status ==1 ? 'checked' : ''?>>
                                                                    <div class="slider round">
                                                                        <span class="on">{{__('sentence.available')}}</span><span class="off">{{__('sentence.navailable')}}</span>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-12">
                                                                <label for="">{{__('sentence.desc') }}<span class="text-danger">*</span></label>
                                                                <textarea name="item_description" id="" required="" class="form-control" rows=4>{{$menuItemData->item_description}}</textarea>
                                                            </div>                                                    
                                                        </div>                                            
                                                    </div>
                                                </div>

                                                <div class="card">
                                                    <div class="card-header">
                                                        <h4 class="card-title">Nutrition</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="basic-form">
                                                            <div class="form-row">
                                                                <div class="form-group col-md-4">
                                                                    <label for="">{{__('sentence.servicepc') }}</label>
                                                                    <input type="text" name="service_per_container" value="{{!empty($nutrition)?$nutrition->service_per_container:''}}" class="form-control">
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <label for="">{{__('sentence.rounding') }}</label>
                                                                    <select name="rounding" class="form-control">
                                                                        @if(!empty($nutrition))
                                                                            <option value="0" {{$nutrition->rounding=='gm'?'Selected':''}}>{{__('sentence.defualt') }}</option>   
                                                                            <option value="1" {{$nutrition->rounding=='gm'?'Selected':''}}>{{__('sentence.usually') }}</option>
                                                                            <option value="2" {{$nutrition->rounding=='gm'?'Selected':''}}>{{__('sentence.varied') }}</option>
                                                                        @else
                                                                            <option value="0" selected="">{{__('sentence.default') }}</option>   
                                                                            <option value="1">{{__('sentence.usually') }}</option>
                                                                            <option value="2">{{__('sentence.varied') }}</option>
                                                                        @endif                           
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <label for="">{{__('sentence.qty') }}</label>
                                                                    <input type="text" name="quantity" value="{{!empty($nutrition)?$nutrition->quantity:''}}" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-md-4">
                                                                    <label for="">{{__('sentence.unit') }}</label>
                                                                    <input type="text" name="units" value="{{!empty($nutrition)?$nutrition->units:''}}" class="form-control">
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <label for="">{{__('sentence.servicesize') }}</label>
                                                                    <input type="text" name="serving_size" value="{{!empty($nutrition)?$nutrition->serving_size:''}}" class="form-control">
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <label for="">{{__('sentence.servicesu') }}</label>
                                                                    <select name="serving_size_unit" class="form-control">
                                                                        @if(!empty($nutrition))
                                                                        <option value="gm" {{$nutrition->serving_size_unit=='gm'?'Selected':''}}>{{__('sentence.grams') }}</option>                  
                                                                        <option value="ml" {{$nutrition->serving_size_unit=='ml'?'Selected':''}}>{{__('sentence.mililiter') }}</option>
                                                                        @else
                                                                        <option value="gm" selected="">{{__('sentence.grams') }}</option>                  
                                                                        <option value="ml">{{__('sentence.mililiter') }}</option>  
                                                                        @endif                                  
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-md-4">
                                                                    <label for="">{{__('sentence.cal') }}</label>
                                                                    <input type="text" name="calories" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" value="{{!empty($nutrition)?$nutrition->calories:''}}">
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <label for="">{{__('sentence.totalf') }}</label>
                                                                    <input type="text" name="total_fat" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" value="{{!empty($nutrition)?$nutrition->total_fat:''}}">
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <label for="">{{__('sentence.saturatedf') }}</label>
                                                                    <input type="text" name="saturated_fat" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" value="{{!empty($nutrition)?$nutrition->saturated_fat:''}}">
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-md-4">
                                                                    <label for="">{{__('sentence.transf') }}</label>
                                                                    <input type="text" name="trans_fat" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" value="{{!empty($nutrition)?$nutrition->trans_fat:''}}">
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <label for="">{{__('sentence.cholesterol') }}</label>
                                                                    <input type="text" name="cholesterol" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" value="{{!empty($nutrition)?$nutrition->cholesterol:''}}">
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <label for="">{{__('sentence.sodium') }}</label>
                                                                    <input type="text" name="sodium" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" value="{{!empty($nutrition)?$nutrition->sodium:''}}">
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                
                                                                <div class="form-group col-md-4">
                                                                    <label for="">{{__('sentence.totalc') }}</label>
                                                                    <input type="text" name="total_carbohydrates" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" value="{{!empty($nutrition)?$nutrition->total_carbohydrates:''}}">
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <label for="">{{__('sentence.dietaryf') }}</label>
                                                                    <input type="text" name="dietry_fiber" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" value="{{!empty($nutrition)?$nutrition->dietry_fiber:''}}">
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <label for="">{{__('sentence.sugar') }}</label>
                                                                    <input type="text" name="sugars" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" value="{{!empty($nutrition)?$nutrition->sugars:''}}">
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                
                                                                <div class="form-group col-md-4">
                                                                    <label for="">{{__('sentence.addeds') }}</label>
                                                                    <input type="text" name="added_sugar" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" value="{{!empty($nutrition)?$nutrition->added_sugar:''}}">
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <label for="">{{__('sentence.protien') }}</label>
                                                                    <input type="text" name="protein" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" value="{{!empty($nutrition)?$nutrition->protein:''}}">
                                                                </div>
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
                                                                    <input type="checkbox" id="weekday-mon" name="mon" class="weekday" {{!empty($itemScheduleData)?$itemScheduleData->mon==1?'checked':'':''}}>
                                                                    <label for="weekday-mon">{{__('sentence.mon') }}</label>
                                                                    <div class="time-sec">
                                                                        <label for="">{{__('sentence.startt') }}</label>
                                                                        <input type="time" name="mon_start_time"  id="mon_start_time" required="" value="{{$itemScheduleData->mon_start_time??''}}">
                                                                        <label for="">{{__('sentence.endt') }}</label>
                                                                        <input type="time" name="mon_end_time" id="mon_end_time" required="" value="{{$itemScheduleData->mon_end_time??''}}">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group col-md-2">
                                                                <div class="weekDays-selector">
                                                                    <input type="checkbox" id="weekday-tue" name="tue" class="weekday" {{!empty($itemScheduleData)?$itemScheduleData->tue==1?'checked':'':''}}>
                                                                    <label for="weekday-tue">{{__('sentence.tue') }}</label>
                                                                    <div class="time-sec">
                                                                        <label for="">{{__('sentence.startt') }}</label>
                                                                        <input type="time" name="tue_start_time" id="tue_start_time" required="" value="{{$itemScheduleData->tue_start_time??''}}">
                                                                        <label for="">{{__('sentence.endt') }}</label>
                                                                        <input type="time" name="tue_end_time" id="tue_end_time" required="" value="{{$itemScheduleData->tue_end_time??''}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-2">
                                                                <div class="weekDays-selector">
                                                                    <input type="checkbox" id="weekday-wed" name="wed" class="weekday" {{!empty($itemScheduleData)?$itemScheduleData->wed==1?'checked':'':''}}>
                                                                    <label for="weekday-wed">{{__('sentence.wends') }}</label>
                                                                    <div class="time-sec">
                                                                        <label for="">{{__('sentence.startt') }}</label>
                                                                        <input type="time" name="wed_start_time" id="wed_start_time" required="" value="{{$itemScheduleData->wed_start_time??''}}">
                                                                        <label for="">{{__('sentence.endt') }}</label>
                                                                        <input type="time" name="wed_end_time" id="wed_end_time" required="" value="{{$itemScheduleData->wed_end_time??''}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-2">
                                                                <div class="weekDays-selector">
                                                                    <input type="checkbox" id="weekday-thu" name="thu" class="weekday" {{!empty($itemScheduleData)?$itemScheduleData->thu==1?'checked':'':''}}>
                                                                        <label for="weekday-thu">{{__('sentence.thu') }}</label>
                                                                            <div class="time-sec">
                                                                                <label for="">{{__('sentence.startt') }}</label>
                                                                                <input type="time" id="thu_start_time" name="thu_start_time" required="" value="{{!empty($itemScheduleData)?$itemScheduleData->thu_start_time:''}}">
                                                                                <label for="">{{__('sentence.endt') }}</label>
                                                                                <input type="time" id="thu_end_time" name="thu_end_time" required="" value="{{!empty($itemScheduleData)?$itemScheduleData->thu_end_time:''}}">
                                                                            </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-2">
                                                                <div class="weekDays-selector">
                                                                    <input type="checkbox" id="weekday-fri" name="fri" class="weekday" {{!empty($itemScheduleData)?$itemScheduleData->fri==1?'checked':'':''}}>
                                                                    <label for="weekday-fri">{{__('sentence.fri') }}</label>
                                                                    <div class="time-sec">
                                                                        <label for="">{{__('sentence.startt') }}</label>
                                                                        <input type="time" name="fri_start_time" id="fri_start_time" required="" value="{{$itemScheduleData->fri_start_time??''}}">
                                                                        <label for="">{{__('sentence.endt') }}</label>
                                                                        <input type="time" name="fri_end_time" id="fri_end_time" required="" value="{{$itemScheduleData->fri_end_time??''}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-2">
                                                                <div class="weekDays-selector">
                                                                    <input type="checkbox" id="weekday-sat" name="sat" class="weekday" {{!empty($itemScheduleData)?$itemScheduleData->sat==1?'checked':'':''}}>
                                                                    <label for="weekday-sat">{{__('sentence.sat') }}</label>
                                                                    <div class="time-sec">
                                                                        <label for="">{{__('sentence.startt') }}</label>
                                                                        <input type="time" name="sat_start_time" id="sat_start_time" required="" value="{{$itemScheduleData->sat_start_time??''}}">
                                                                        <label for="">{{__('sentence.endt') }}</label>
                                                                        <input type="time" name="sat_end_time" id="sat_end_time" required="" value="{{$itemScheduleData->sat_end_time??''}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group col-md-2">
                                                                <div class="weekDays-selector">
                                                                    <input type="checkbox" id="weekday-sun" name="sun" class="weekday" {{!empty($itemScheduleData)?$itemScheduleData->sun==1?'checked':'':''}}>
                                                                    <label for="weekday-sun">{{__('sentence.sun') }}</label>
                                                                    <div class="time-sec">
                                                                        <label for="">{{__('sentence.startt') }}</label>
                                                                        <input type="time" name="sun_start_time" id="sun_start_time" required="" value="{{$itemScheduleData->sun_start_time??''}}">
                                                                        <label for="">{{__('sentence.endt') }}</label>
                                                                        <input type="time" name="sun_end_time" id="sun_end_time" required="" value="{{$itemScheduleData->sun_end_time??''}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-2">
                                                                <label for="">{{__('sentence.recurrung') }}</label>
                                                                
                                                                <label class="switch">
                                                                    <input type="checkbox" name="recurring" id="myonoffswitch" class=" onoffswitch-label" {{!empty($itemScheduleData)?$itemScheduleData->recurring ==1 ? 'checked' : '':''}}>
                                                                    <div class="slider round">
                                                                        <span class="on">Yes</span><span class="off">No</span>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                            <div class="form-group col-md-3">
                                                                <label for="">{{__('sentence.leadt') }}<span class="text-danger">*</span></label>
                                                                {{ Form::select('lead_time',['0'=>'0 '.__('sentence.day'),'1'=>'1 '.__('sentence.day'),'2'=>'2 '.__('sentence.days'),'3'=>'3 '.__('sentence.days'),'4'=>'4 '.__('sentence.days'),'5'=>'5 '.__('sentence.days'),'6'=>'6 '.__('sentence.days'),'7'=>'7 '.__('sentence.days')], !empty($itemScheduleData)?$itemScheduleData->lead_time:'',["required","placeholder"=>''.__('sentence.leadt'),"id"=>"lead_time","name"=>"lead_time","class"=>"form-control"]) }}
                                                            </div>

                                                        </div> <br><br>

                                                        <button type="submit" name="btnSubmit" class="btn btn-warning">{{__('sentence.update') }}</button>
                                                        <img id="loader" src="{{ asset('public/frontend/images/loader.gif')}}" alt="" />
                                                        <button type="button" name="btnCancel" class="btn btn-warning" onclick=" window.history.back()">{{__('sentence.cancel') }}</button> 
                                                            {{ Form::close() }}                      
                                                    </div>
                                                </div>
                                            </div>
                                        {{-- </div> --}}
                                    {{-- </div> --}}
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
    var cnt=$('#noOfOption').val();
    
    if(cnt>0){
            $(".remove-item").show();
        } 
    
    $(".add-item").click( function(e) {        
        cnt++;       
        e.preventDefault();
        $("#inc").append('<div class="card" id="option-box'+cnt+'"><div class="card-body"><div class="form-row">\
        <div class="col-md-3 input-group-sm">\
        <label for="">{{__("sentence.option") }}</label>\
        <input type="hidden" name="addmore['+cnt+'][id]" id="addmore'+cnt+'" value="0">\
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
        <label for="">{{__("sentence.rate") }}<span class="text-danger">*</span><span style="font-size: 10px" class="text-danger display-option-rate"></span></label>\
        <div class="input-group input-group-sm mb-3">\
        <div class="input-group-prepend">\
        <span class="input-group-text">'+$('#currency').val()+'</span> \  </div>\
        <input type="number" name="addmore['+cnt+'][rate]" value="" required="" class="form-control  option-rate"> \
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
        <select name="addmore['+cnt+'][group]" required="" class="form-control-sm " style="border-color: #dddddd;color: #666666;">\
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
        

        if(cnt>=0){
            $(".remove-item").show();
        }
        return false;
    });
    $(".remove-item").click( function(e) {

        var optid=$("#addmore"+cnt).val();
        
        if(optid){
            $.ajax({
                type: "POST",
                url:  BASEURL+'delete-item',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: optid                        
                },
                success: function(result) {
                    console.log("Menu Item Deleted")
                },
                error: function(result) {
                    console.log("Menu Item Not Deleted");
                }
            });
        }
        
        if(cnt==1){
            
            $(this).hide();
            $( "#option-box"+cnt).remove();
            cnt--;
            $('#myonoffswitch').trigger('click');
        }else{
            $( "#option-box"+cnt ).remove();
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
                    $('#suggetionbox').fadeIn();  
                    $('#suggetionbox').html(data);
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

