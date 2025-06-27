@extends('frontend.chef-dashboard.layouts.app')
<style>
@section('pageCss')
<style>.display-none{display:none;}</style>
@endsection    
</style>
@section('content')
<div class="content-body">
    <div class="container-fluid">
        @section('pageHeading')
        <h2>{{__('sentence.profile') }}</h2>
        @endsection     
       
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{__('sentence.profile') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-3">
                                <div class="nav flex-column nav-pills mb-3">
                                    <a href="#v-pills-basic" data-toggle="pill" class="nav-link active show">{{__('sentence.basciinformation') }}</a>
                                    <a href="#v-pills-location" data-toggle="pill" class="nav-link">{{__('sentence.locationdetail') }}</a>
                                    <a href="#v-pills-business" data-toggle="pill" class="nav-link">{{__('sentence.bussinessdetail') }}</a>
                                    <a href="#v-pills-tax" data-toggle="pill" class="nav-link">{{__('sentence.taxdetail') }}</a>
                                    <a href="#v-pills-password" data-toggle="pill" class="nav-link">{{__('sentence.changepass') }}</a>
                                    <a href="#v-pills-contract" data-toggle="pill" class="nav-link">{{__('sentence.download-contract')}}</a>
                                   
                                </div>
                            </div>
                            <div class="col-xl-9">
                                <div class="tab-content">
                                    <div id="v-pills-basic" class="tab-pane fade active show">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">{{__('sentence.basciinformation') }}</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="basic-form">
                                                {{ Form::open(['url' => route('chef-basic-info.update',$basicInfo->id), 'method'=>'PATCH', 'files'=>true, 'name' => 'frmChefBasicInfo', 'id' => 'frmChefBasicInfo','class'=>"form-main"]) }}
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label>{{__('sentence.firstname') }}<span class="text-danger">*</span></label>
                                                                <input type="text" name="first_name" class="form-control" value="{{!empty($basicInfo)?$basicInfo->first_name:''}}" required="">
                                                            </div>
                                                             <div class="form-group col-md-6">
                                                                <label>{{__('sentence.lastname') }}<span class="text-danger">*</span></label>
                                                                <input type="text" name="last_name" class="form-control" value="{{!empty($basicInfo)?$basicInfo->last_name:''}}" required="">
                                                            </div>
                                                             <div class="form-group col-md-6">
                                                                <label>{{__('sentence.mobile') }}<span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" name="mobile" value="{{!empty($basicInfo)?$basicInfo->mobile:''}}" required="">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label>{{__('sentence.email') }}<span class="text-danger">*</span></label>
                                                                <input type="email" name="email" class="form-control" value="{{!empty($basicInfo)?$basicInfo->email:''}}" required="">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label>{{__('sentence.profile') }}<span class="text-danger">*</span></label>
                                                                <div class="custom-file">
                                                                    <input type="file" name="profile" id="profile" onchange="previewImage(this)" accept="image/*" class="custom-file-input">
                                                                    <label class="custom-file-label">{{__('sentence.choosef') }}</label>
                                                                </div>
                                                                {{ Form::hidden('oldImage', $basicInfo->profile) }}
                                                                <input type="hidden" id="profile-avtr" name="profile_avtr" value="image-3.png">
                                                                 <div id="previewImage" style="padding: 10px;" class="custom-file">
                                                                    @if(isset($basicInfo))
                                                                    <br><img src="{{ asset('public/frontend/images/users/'.$basicInfo->profile) }}" height="60px" width="60px" alt="User profile picture">
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <div class="form-wrap">
                                                                    <label>{{__('sentence.use-default-image')}}</label>
                                                                    <div id="avtarImage" class="default-img">
                                                                        <img id="image-1.png" src="{{asset('public/frontend/images/users/image-1.png')}}" height='70px' width='70px' onclick="previewAvatar(this)">
                                                                        <img id="image-2.png" src="{{asset('public/frontend/images/users/image-2.png')}}" height='70px' width='70px' onclick="previewAvatar(this)">
                                                                        <img id="image-5.png" src="{{asset('public/frontend/images/users/image-5.png')}}" height='70px' width='70px' onclick="previewAvatar(this)">
                                                                        <img id="image-7.png" src="{{asset('public/frontend/images/users/image-7.png')}}" height='70px' width='70px' onclick="previewAvatar(this)">                  
                                                                        <img id="image-4.png" src="{{asset('public/frontend/images/users/image-4.png')}}" height='70px' width='70px' onclick="previewAvatar(this)">
                                                                        <img id="image-6.png" src="{{asset('public/frontend/images/users/image-6.png')}}" height='70px' width='70px' onclick="previewAvatar(this)">            
                                                                        <img id="image-8.png" src="{{asset('public/frontend/images/users/image-8.png')}}" height='70px' width='70px' onclick="previewAvatar(this)">
                                                                        <img id="image-9.png" src="{{asset('public/frontend/images/users/image-9.png')}}" height='70px' width='70px' onclick="previewAvatar(this)">            
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group col-md-6">
                                                                <br><button type="submit" name="btnSubmit" class="btn btn-warning">{{__('sentence.save') }}</button>
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
                                    </div>

                                    <div id="v-pills-location" class="tab-pane fade">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">{{__('sentence.locationdetail') }}</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="basic-form">
                                                    {{ Form::open(['url' => route('chef-location.update',$basicInfo->id), 'method'=>'PATCH', 'files'=>true, 'name' => 'frmChefLocation', 'id' => 'frmChefLocation']) }}
                                                        <div class="form-row">
                                                            <div class="form-group col-md-12">
                                                                <label>{{__('sentence.address') }}</label>
                                                                <input type="text" name="address" class="form-control"  value="{{!empty($location)?$location->address:''}}">
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                 <label for="">{{__('sentence.country') }}</label>
                                                                {{ Form::select('country',!empty($countries) ? $countries : [],$basicInfo->country_id,
                                                                ["required","style"=>"width:100%","placeholder"=>'Select Country',"id"=>"country","name"=>"country",'disabled',"class"=>"dropdown bootstrap-select form-control show dropup"]) }}
                                                            </div>
                                                             <div class="form-group col-md-6">
                                                                <label for="">{{__('sentence.state') }}<span class="text-danger">*</span></label>
                                                                {{ Form::select('state',!empty($states) ? $states : [],$location->state_id ,["required","style"=>"width:100%","placeholder"=>'Select State',"id"=>"state","name"=>"state","class"=>"dropdown bootstrap-select form-control show dropup"]) }}
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                @if($basicInfo->country_id==142)
                                                                <label for="">{{__('sentence.muni') }}<span class="text-danger">*</span></label>
                                                                @else
                                                                <label for="">{{__('sentence.city') }}<span class="text-danger">*</span></label>
                                                                @endif
                                                                {{ Form::select('city',!empty($cities) ? $cities : [],$location->city_id ,["required","style"=>"width:100%","placeholder"=>'Select city',"id"=>"city","name"=>"city","class"=>"dropdown bootstrap-select form-control show dropup"]) }}
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                               <label>{{__('sentence.zipcode') }}</label>
                                                                <input type="text" name="zip_code" class="form-control" value="{{!empty($location)?$location->zip_code:''}}">
                                                            </div>
                                                        </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                     <br><button type="submit" name="btnSubmit" class="btn btn-warning">{{__('sentence.save') }}</button>
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
                                
                                    <div id="v-pills-business" class="tab-pane fade">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">{{__('sentence.bussinessdetail') }}</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="basic-form">
                                                    {{ Form::open(['url' => route('chef-business.update',$basicInfo->id), 'method'=>'PATCH', 'files'=>true, 'name' => 'frmChefBusiness', 'id' => 'frmChefBusiness']) }}
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label>{{__('sentence.bussinessname') }}</label>
                                                            <input type="text" name="business_nm" class="form-control"  value="{{!empty($business)?$business->business_name:''}}">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="">{{__('sentence.cuisines') }}<span class="text-danger">*</span></label>
                                                            {{ Form::select('cuisines',!empty($cuisines) ? $cuisines : [], $selCuisines,["required","class"=>"form-control ","multiple"=>"multiple","id"=>"cuisines[]","name"=>"cuisines[]"]) }}
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>{{__('sentence.desc') }}<span class="text-danger">*</span></label>
                                                            <textarea class="form-control" name="description" required="" maxlength="150">{{!empty($business)?$business->description:''}}</textarea>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>{{__('sentence.messaging') }}</label><br>
                                                            <label class="switch">
                                                                <input type="checkbox" class="changeBtn" name="messaging" 
                                                                {{!empty($business)?$business->messaging=="1"?'checked':'':''}}>
                                                                <div class="slider round">
                                                                    <span class="on">On</span><span class="off">Off</span>
                                                                </div>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <br><button type="submit" name="btnSubmit" class="btn btn-warning">{{__('sentence.save') }}</button>
                                                    </div>
                                                    {{ Form::close() }}
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="alert display-none alert-success"></div>
                                                        <div class="alert display-none alert-danger"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                                                      
                                    <div id="v-pills-tax" class="tab-pane fade">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">{{__('sentence.taxdetail') }}</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="basic-form">
                                                  {{ Form::open(['url' => route('chef-tax.update',$basicInfo->id), 'method'=>'PATCH', 'files'=>true, 'name' => 'frmChefTax', 'id' => 'frmChefTax','class'=>"form-main"]) }}
                                                        <div class="form-row">
                                                            @if($basicInfo->country_id==142)
                                                            <div class="form-group col-md-6">
                                                                <label for="">RFC<span class="text-danger">*</span></label>
                                                                <input type="text" value="{{!empty($tax)?$tax->rfc:''}}" class="form-control" name="rfc" required="">
                                                            </div>
                                                            <input type="hidden" name="country_id" value="142">
                                                            <div class="form-group col-md-6">
                                                                <div class="form-wrap">
                                                                    <label for="">{{__('sentence.uploadidp') }}<span class="text-danger">*</span></label>
                                                                    <div class="custom-file input-group">
                                                                        <input type="file" name="uploadid" id="uploadid" onchange="previewImage1(this)"  class="custom-file-input" style='margin:2px' required="">
                                                                        <label class="custom-file-label">{{__('sentence.choosef') }}</label>
                                                                    </div>
                                                                    {{ Form::hidden('oldImage', !empty($tax)?$tax->upload_id_proof:'') }}
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                   <div id="previewImage1" style="padding: 10px 0 200px 0px;" class="custom-file">
                                                                        @if(!empty($tax->upload_id_proof))
                                                                        <br>
                                                                        <embed src="{{ asset('public/frontend/images/users/'.$tax->upload_id_proof) }}" width="200px" height="200px" />
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>  
                                                            @else
                                                             <div class="form-group col-md-6">
                                                                <label>{{__('sentence.federaltd') }}</label>
                                                                <input type="text"name="fed_tax" class="form-control" value="{{!empty($tax)?$tax->federal_tax_id:''}}">
                                                            </div>
                                                             <div class="form-group col-md-6">
                                                                <label>{{__('sentence.social') }}</label>
                                                                <input type="text" name="social" class="form-control"  value="{{!empty($tax)?$tax->social:''}}">
                                                            </div>
                                                            @endif
                                                        </div>

                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                               <br><button type="submit" name="btnSubmit" class="btn btn-warning">{{__('sentence.save') }}</button>
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
                                    </div>
                                    <div id="v-pills-password" class="tab-pane fade">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">{{__('sentence.changepass') }}</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="basic-form">
                                                {{ Form::open(['url' => route('chef-change-password'), 'method'=>'PATCH', 'files'=>true, 'name' => 'frmChefChangePassword', 'id' => 'frmChefChangePassword']) }}
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label>{{__('sentence.email') }}<span class="text-danger">*</span></label>
                                                                <input type="email" name="email" class="form-control" value="{{!empty($basicInfo)?$basicInfo->email:''}}" required="" readonly="">
                                                            </div>
                                                             <div class="form-group col-md-6">
                                                                <label>{{__('sentence.oldpass') }}<span class="text-danger">*</span></label>
                                                                <input type="password" name="old_password" class="form-control" id="old_password" required="">
                                                            </div>
                                                             <div class="form-group col-md-6">
                                                                <label>{{__('sentence.pass') }}<span class="text-danger">*</span></label>
                                                               <input type="password" name="password" class="form-control" id="password" required="">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label>{{__('sentence.cpass') }}<span class="text-danger">*</span></label>
                                                               <input type="password" class="form-control" name="confirm_password" id="confirm_password" required="">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group col-md-6">
                                                               <br><button type="submit" name="btnSubmit" class="btn btn-warning">{{__('sentence.save') }}</button>
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
                                    </div>

                                    <div id="v-pills-contract" class="tab-pane fade">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">{{__('sentence.download-contract')}}</h4>
                                            </div>
                                            <div class="card-body">                                                             
                                                @if(isset($location->contract))
                                                <div class="form-group col-md-4">
                                                    <label></label>
                                                    <a class="btn btn-warning btn-sm" href="{{ asset('public/frontend/contract/'.$location->contract) }}" download><i class="fa fa-download" aria-hidden="true" ></i> {{__('sentence.download-contract')}}</a>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
<script type="text/javascript" src="{{ asset('public/frontend/js/easy-responsive-tabs.js')}}"></script>
<script type="text/javascript" src="{{ asset('public/frontend/js/pages/edit-profile.min.js')}}"></script>
@endsection