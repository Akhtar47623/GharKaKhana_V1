@extends('frontend.chef-dashboard.layouts.app')
@section('pageCss')

@endsection
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            @section('pageHeading')
            <h2>{{__('sentence.menugroup') }}</h2>
            @endsection 
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="mr-auto d-none d-lg-block">
                        <a class="text-warning d-flex align-items-center mb-3 font-w500" href="{{route('group.index')}}">
                        <svg class="mr-3" width="24" height="12" viewBox="0 0 24 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.274969 5.14888C0.27525 5.1486 0.275484 5.14827 0.275812 5.14799L5.17444 0.272997C5.54142 -0.0922061 6.135 -0.090847 6.5003 0.276184C6.86555 0.643168 6.86414 1.23675 6.49716 1.60199L3.20822 4.87499H23.0625C23.5803 4.87499 24 5.29471 24 5.81249C24 6.33027 23.5803 6.74999 23.0625 6.74999H3.20827L6.49711 10.023C6.86409 10.3882 6.8655 10.9818 6.50025 11.3488C6.13495 11.7159 5.54133 11.7171 5.17439 11.352L0.275764 6.47699C0.275483 6.47671 0.27525 6.47638 0.274921 6.4761C-0.0922505 6.10963 -0.0910778 5.51413 0.274969 5.14888Z" fill="#ffc200"></path>
                        </svg>
                        {{__('sentence.back') }}</a>
                        
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('group.index')}}"> {{__('sentence.group') }}</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)"> {{__('sentence.addgroup') }}</a></li>
                    </ol>
                </div>
            </div>
                <!-- row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">
                                      <h4>{{__('sentence.addgroup') }}</h4>
                                </div>
                                
                            </div>
                            <div class="card-body">
                                <div class="form-validation">
                                    {{ Form::open(['url' => route('group.store'), 'method'=>'POST', 'files'=>true, 'name' => 'frmGroup', 'id' => 'frmGroup','class'=>"form-main"]) }}
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label>{{__('sentence.gnm') }}<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="group_name" id="group_name" placeholder="{{__('sentence.entgnm') }}" required="">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label>{{__('sentence.option') }}<span class="text-danger">*</span></label>
                                                <select class="form-control" id="option" name="option" required="">
                                                            <option value="" selected="">{{__('sentence.pso') }}</option>
                                                            <option value="M">{{__('sentence.multi') }}</option>
                                                            <option value="S">{{__('sentence.sing') }}</option>
                                                        </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label>{{__('sentence.requ') }}<span class="text-danger">*</span></label>
                                                
                                                    <label class="switch">
                                                        <input type="checkbox" class="togBtn" name="required">
                                                        <div class="slider round">
                                                            <span class="on">YES</span><span class="off">NO</span>
                                                        </div>
                                                    </label>
                                                
                                            </div>
                                        </div> 
                                            <div class="row">
                                                <div class="col-xl-12">
                                                    <br><button type="submit" class="btn btn-warning" name="btnSubmit">{{__('sentence.add') }}</button>
                                                    <button type="submit" name="btnCancel" class="btn btn-warning" onclick=" window.history.back()">{{__('sentence.cancel') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    {{ Form::close() }}
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
<script type="text/javascript" src="{{ asset('public/frontend/js/pages/group.js')}}"></script>
@endsection 

