@extends('frontend.chef-dashboard.layouts.app')
@section('pageCss')
<link href="{{asset('public/frontend/chef-dashboard/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">

@endsection
@section('content')
	<div class="content-body">
        <div class="container-fluid">
         @section('pageHeading')
         <h2>{{__('sentence.pickupdel') }}</h2>
         @endsection
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                   
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                	
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Setting</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">{{__('sentence.pickupdel') }}</a></li>
                    </ol>
                </div>
           </div>
            <!-- row -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">
                                    <h4> {{__('sentence.pickupdel') }}</h4>
                                </div>
                                @if(empty($pickupDelivery))
                                <a href="{{ route('pickup-delivery.create') }}" class="btn btn-xs btn-warning" title="Add new">
                                <i class="fa fa-plus-circle"></i>  {{__('sentence.addpickup') }}</a>
                                @endif
                            </div>
                            <div class="card-body">
                                @if(!empty($pickupDelivery))
                                <div class="sp15 row border-bottom favorites-items p-3 align-items-center p-sm-4">
                                    <div class="col-xl-10 col-lg-10 col-sm-10 col-11 mb-3 mb-lg-0">
                                        <div class="media align-items-center">
                                            <img class="rounded mr-3" src="{{asset('public/frontend/images/pick-del.png')}}" alt="" style="width:70px">
                                            <div class="media-body">

                                                <h5 class="mb-2 fs-14">
                                                    @php
                                                    if($pickupDelivery->options==1)
                                                        echo __('sentence.pickonly');
                                                    else if($pickupDelivery->options==2)
                                                        echo __('sentence.pickanddil');
                                                    else
                                                        echo __('sentence.delonly');
                                                    @endphp
                                                </h5>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-2 col-lg-2 col-sm-2 col-1 text-right">
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
                                                    <a href="{{route('pickup-delivery.edit', $pickupDelivery->uuid)}}" class="dropdown-item">{{__('sentence.edit')}}</a>
                                                    <a id="item" type="delete" title="Delete" rel="tooltip" class="dropdown-item text-danger sharp remove delete"  data-id="{{($pickupDelivery->id)}}"  data-action="{{route('pickup-delivery.destroy', $pickupDelivery->id)}}" data-message="{{__('validation.confirm')}}">{{__('sentence.delete')}}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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

@endsection 
