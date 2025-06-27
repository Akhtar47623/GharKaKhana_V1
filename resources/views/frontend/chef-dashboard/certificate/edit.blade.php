@extends('frontend.chef-dashboard.layouts.app')
@section('pageCss')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style type="text/css">.ui-datepicker-calendar { display: none !important; }</style>
@endsection
@section('content')
 <div class="content-body">
        <div class="container-fluid">
            @section('pageHeading')
            <h2>{{__('sentence.certificate') }}</h2>
            @endsection 
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="mr-auto d-none d-lg-block">
                        <a class="text-warning d-flex align-items-center mb-3 font-w500" href="{{route('certificate.index')}}">
                        <svg class="mr-3" width="24" height="12" viewBox="0 0 24 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.274969 5.14888C0.27525 5.1486 0.275484 5.14827 0.275812 5.14799L5.17444 0.272997C5.54142 -0.0922061 6.135 -0.090847 6.5003 0.276184C6.86555 0.643168 6.86414 1.23675 6.49716 1.60199L3.20822 4.87499H23.0625C23.5803 4.87499 24 5.29471 24 5.81249C24 6.33027 23.5803 6.74999 23.0625 6.74999H3.20827L6.49711 10.023C6.86409 10.3882 6.8655 10.9818 6.50025 11.3488C6.13495 11.7159 5.54133 11.7171 5.17439 11.352L0.275764 6.47699C0.275483 6.47671 0.27525 6.47638 0.274921 6.4761C-0.0922505 6.10963 -0.0910778 5.51413 0.274969 5.14888Z" fill="#ffc200"></path>
                        </svg>
                           {{__('sentence.back') }}</a>
                        
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('certificate.index')}}">{{__('sentence.certinm') }}</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">{{__('sentence.editcerti') }}</a></li>
                    </ol>
                </div>
            </div>
                <!-- row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">
                                      <h4>{{__('sentence.editcerti') }}</h4>
                                </div>
                                
                            </div>
                            <div class="card-body">
                                 <div class="basic-form">
                                      {{ Form::open(['url' => route('certificate.update',$certiData->id), 'method'=>'PATCH', 'files'=>true, 'name' => 'frmCertificate', 'id' => 'frmCertificate','class'=>"form-main"]) }}
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">{{__('sentence.certinam') }}
                                                                <span class="text-danger">*</span></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" name="certi_name" id="certi_name" value="{{$certiData->certi_name}}" placeholder="{{__('sentence.entcertnm') }}" required="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">{{__('sentence.certiurl') }}
                                                    <span class="text-danger">*</span></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" name="certi_url" id="certi_url" value="{{$certiData->certi_url}}"   placeholder="{{__('sentence.entcertiurl') }}" required="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">{{__('sentence.from') }}
                                                                <span class="text-danger">*</span></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" name="certi_from" id="from"  value="{{$certiData->certi_from}}"  required="">
                                                    </div>
                                                </div>
                                            </div>
                                             <div class="col-xl-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">{{__('sentence.to') }}
                                                                <span class="text-danger">*</span></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" name="certi_to" id="to" value="{{$certiData->certi_to}}" required="">
                                                    </div>
                                                </div>
                                             </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                 <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">{{__('sentence.certiauth') }}
                                                        <span class="text-danger">*</span></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" name="certi_authority" id="certi_authority" value="{{$certiData->certi_authority}}"  value="{{$certiData->certi_to}}" placeholder="{{__('sentence.entcertauth') }}" required="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">{{__('sentence.img') }}</label>
                                                         <div class="col-sm-8">
                                                                <div class="custom-file">
                                                                    <input type="file" name="image" onchange="previewImage(this)"  class="custom-file-input" id="image">
                                                                    <label class="custom-file-label">{{__('sentence.choosef') }}</label>
                                                                </div>
                                                                {{ Form::hidden('oldImage', $certiData->image) }}
                                                                <div id="previewImage" class="custom-file" style="padding: 10px;">
                                                                @if(isset($certiData))
                                                                <br><img src="{{ asset('public/frontend/images/certificate/'.$certiData->image) }}" height="60px" width="60px" alt="Certificate Image" >
                                                                @endif
                                                            </div>
                                                        </div>
                                                       
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-10">
                                                <button type="submit" class="btn btn-warning" name="btnSubmit" >{{__('sentence.update') }}</button>
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
<script src="{{asset('public/frontend/chef-dashboard/vendor/jqueryui/js/jquery-ui.min.js')}}"></script>
<script src="{{asset('public/backend/common/jquery.validate.js')}}"></script>
<script type="text/javascript" src="{{ asset('public/frontend/js/pages/certificate.js')}}"></script>
@endsection 

