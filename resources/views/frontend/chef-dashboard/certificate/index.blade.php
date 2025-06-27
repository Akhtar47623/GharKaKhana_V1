@extends('frontend.chef-dashboard.layouts.app')
@section('pageCss')
<link href="{{asset('public/frontend/chef-dashboard/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
@endsection
@section('content')
  	<div class="content-body">
        <div class="container-fluid">
          @section('pageHeading')
          <h2>{{__('sentence.certificate') }}</h2>
          @endsection
          
            <!-- row -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">
                                    <h4>{{__('sentence.certificate') }}</h4>
                                </div>
                                <a href="{{ route('certificate.create') }}" class="btn btn-xs btn-warning" title="Add new">
                            <i class="fa fa-plus-circle"></i>{{__('sentence.addcerti') }}</a>
                            </div>
                            <div class="card-body">
                                @if(!empty($certiData))
                                @foreach ($certiData as $value)
                                <div class="sp15 row border-bottom favorites-items p-3 align-items-center">
                                    <div class="col-xl-6 col-lg-6 col-sm-6 col-12 mb-3 mb-lg-0">
                                        <div class="media align-items-center">
                                            <img class="rounded mr-3" src="{{asset('public/frontend/images/certificate')}}/{{$value->image}}" alt="" style="width:80px">
                                            <div class="media-body">
                                                <small class="mt-0 mb-1 font-w500">{{$value->certi_authority}}</small>
                                                <h5 class="mb-2 fs-14">{{$value->certi_name}}</h5>
                                                <h5 class="mb-0 fs-12"><span class="text-warning">{{$value->certi_from}}-{{$value->certi_to}}</h5>
                                                                                              
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-sm-3 col-6 media">

                                        <div class="media-body">
                                            <span class="text-black" style="margin-left: 10px">{{__('sentence.status') }}</span>
                                            <div class="product-status">
                                                <label class="switch">
                                                    <input type="checkbox" class="togBtn" data-id="{{$value->id}}" data-action="{{route('change-certi-status')}}" {{$value->status=="1"?'checked':''}}>
                                                    <div class="slider round">
                                                        <span class="on">Active</span><span class="off">InActive</span>
                                                    </div>
                                                </label>
                                            </div>                                       
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-sm-3 col-6 media text-right">

                                        <div class="media-body">
                                            <div class="dropdown">
                                                <button class="btn btn-warning tp-btn-light sharp" type="button" data-toggle="dropdown">
                                                    <span class="fs--1">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M11.0005 12C11.0005 12.5523 11.4482 13 12.0005 13C12.5528 13 13.0005 12.5523 13.0005 12C13.0005 11.4477 12.5528 11 12.0005 11C11.4482 11 11.0005 11.4477 11.0005 12Z" stroke="#3E4954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M18.0005 12C18.0005 12.5523 18.4482 13 19.0005 13C19.5528 13 20.0005 12.5523 20.0005 12C20.0005 11.4477 19.5528 11 19.0005 11C18.4482 11 18.0005 11.4477 18.0005 12Z" stroke="#3E4954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M4.00049 12C4.00049 12.5523 4.4482 13 5.00049 13C5.55277 13 6.00049 12.5523 6.00049 12C6.00049 11.4477 5.55277 11 5.00049 11C4.4482 11 4.00049 11.4477 4.00049 12Z" stroke="#3E4954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg>
                                                    </span>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right border py-0">
                                                    <div class="py-2">
                                                        <a href="{{route('certificate.edit',$value->uuid)}}" class="dropdown-item">{{__('sentence.edit')}}</a>
                                                        <a id="item" type="delete" title="Delete" rel="tooltip" class="dropdown-item text-danger sharp remove delete"  data-id="{{($value->id)}}"  data-action="{{route('certificate.destroy', $value->uuid)}}" data-message="{{__('validation.confirm')}}">{{__('sentence.delete')}}</a>
                                                    </div>
                                                </div>
                                            </div>                                   
                                        </div>
                                    </div>
                                    
                                </div>
                                @endforeach
                                @endif  
                                
                            </div>
                        </div>
                    </div>
				</div>
        </div>
    </div>
@endsection
@section('pageScript')
<script src="{{asset('public/frontend/chef-dashboard/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('public/frontend/js/pages/toggle.js')}}"></script>
@endsection 
