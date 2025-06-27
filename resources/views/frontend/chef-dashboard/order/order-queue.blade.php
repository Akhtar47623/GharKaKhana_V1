@extends('frontend.chef-dashboard.layouts.app')
@section('pageCss')
<link href="{{asset('public/frontend/chef-dashboard/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="content-body">
    <div class="container-fluid">
      @section('pageHeading')
      <h2 class="login-title">{{__('sentence.orderq') }}</h2>
      @endsection
          <!-- row -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                           <div class="card-title">
                              <h4>{{__('sentence.orderlist') }}</h4>
                           </div>
                        </div>
                        <div class="card-body">
                            <div class="widget-media trending-menus">
                                <ul class="timeline">
                                    @foreach($orderList as $ol)
                                    <li>                                        
                                        <div class="timeline-panel">
                                            <div class="media mr-4">
                                                <img alt="image" width="90" src="{{asset('public/frontend/images/users')}}/{{$ol->user->profile}}">

                                            </div>
                                            <div class="media-body">
                                                <h6 class="mb-0">{{__('sentence.order') }} <a href="{{route('order-detail',$ol->id)}}" class="text-warning">#{{$ol->id}}</a> </h6>
                                                <small>{{date('M d, Y h:i A',strtotime($ol->created_at_timezone))}}</small>
                                                <h5 class="mb-0 text-black">{{$ol->user->display_name}}</h5>
                                                <small class="text-black mb-2">{{$ol->user->location->address}}</small>
                                                <div class="info mt-2">                                            
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h5 class="fs-12 mb-0 text-warning">{{__('sentence.del')}}: <small class="text-black fs-12">{{date('M d, Y',strtotime($ol->delivery_date))}} {{date('h:i A',strtotime($ol->delivery_time))}}</small></h5>
                                                    </div>
                                                </div>                                              
                                                <div class="info mt-2">
                                            
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h4 class="font-w600 mb-0 text-black">{{!empty($currency)?$currency->symbol:''}} {{$ol->pay_total}}</h4>
                                                        <div class="d-flex align-items-center"> 
                                                            <p class="mb-0 align-items-center">{{__('sentence.status') }} 
                                                        <strong class="text-black font-w500">
                                                        @if($ol->status==2)
                                                        <a class="btn bgl-warning text-warning btn-xs">{{ __('sentence.pen') }}</a>
                                                        @elseif($ol->status==3)
                                                        <a class="btn bgl-light btn-xs">{{ __('sentence.can') }}</a>
                                                        @elseif($ol->status==4)
                                                        <a class="btn bgl-success text-success  btn-xs">{{ __('sentence.acc') }}</a>
                                                        @elseif($ol->status==5)
                                                        <a class="btn bgl-info text-info btn-xs">{{ __('sentence.ready') }}</a>
                                                        @elseif($ol->status==6)
                                                        <a class="btn bgl-primary text-primary btn-xs">{{ __('sentence.delc') }}</a>
                                                        @else
                                                        <a class="btn bgl-dark text-dark  btn-xs">{{ __('sentence.delv') }}</a>
                                                        @endif</strong></p>
                                                            
                                                        </div>
                                                        <div class="d-flex align-items-center"> 
                                                           
                                                            <p class="mb-0">
                                                        @if($ol->status==2)
                                                        <div class="dropdown">
                                                            <div class="btn-link" data-toggle="dropdown">
                                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M11.0005 12C11.0005 12.5523 11.4482 13 12.0005 13C12.5528 13 13.0005 12.5523 13.0005 12C13.0005 11.4477 12.5528 11 12.0005 11C11.4482 11 11.0005 11.4477 11.0005 12Z" stroke="#3E4954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                    <path d="M18.0005 12C18.0005 12.5523 18.4482 13 19.0005 13C19.5528 13 20.0005 12.5523 20.0005 12C20.0005 11.4477 19.5528 11 19.0005 11C18.4482 11 18.0005 11.4477 18.0005 12Z" stroke="#3E4954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                    <path d="M4.00049 12C4.00049 12.5523 4.4482 13 5.00049 13C5.55277 13 6.00049 12.5523 6.00049 12C6.00049 11.4477 5.55277 11 5.00049 11C4.4482 11 4.00049 11.4477 4.00049 12Z" stroke="#3E4954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                </svg>
                                                            </div>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item text-black" href="{{route('order-detail',$ol->id)}}">
                                                                    <svg class="mr-3" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#6F6F6F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                        <path d="M12 16V12" stroke="#6F6F6F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                        <path d="M12 8H12.01" stroke="#6F6F6F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                    </svg>
                                                                    {{__('sentence.viewdetail') }}
                                                                </a>
                                                                <a href="javascript:;" class="change-status dropdown-item text-black" data-id="{{($ol->id)}}" data-action="{{route('order.change-status')}}" data-status="accepted" title="Accept Order" >
                                                                    <svg class="mr-3" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M22 11.08V12C21.9988 14.1564 21.3005 16.2547 20.0093 17.9818C18.7182 19.709 16.9033 20.9725 14.8354 21.5839C12.7674 22.1953 10.5573 22.1219 8.53447 21.3746C6.51168 20.6273 4.78465 19.2461 3.61096 17.4371C2.43727 15.628 1.87979 13.4881 2.02168 11.3363C2.16356 9.18457 2.99721 7.13633 4.39828 5.49707C5.79935 3.85782 7.69279 2.71538 9.79619 2.24015C11.8996 1.76491 14.1003 1.98234 16.07 2.86" stroke="#2F4CDD" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                        <path d="M22 4L12 14.01L9 11.01" stroke="#2F4CDD" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                    </svg>
                                                                    {{__('sentence.accorder') }}
                                                                </a>
                                                                <a class="dropdown-item text-black" href="#">
                                                                    <svg class="mr-3" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#F24242" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                        <path d="M15 9L9 15" stroke="#F24242" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                        <path d="M9 9L15 15" stroke="#F24242" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                    </svg>
                                                                    {{__('sentence.canorder') }}
                                                                </a>
                                                            </div>
                                                        </div>
                                                        @elseif($ol->status==4)
                                                        <div class="dropdown">
                                                            <div class="btn-link" data-toggle="dropdown">
                                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M11.0005 12C11.0005 12.5523 11.4482 13 12.0005 13C12.5528 13 13.0005 12.5523 13.0005 12C13.0005 11.4477 12.5528 11 12.0005 11C11.4482 11 11.0005 11.4477 11.0005 12Z" stroke="#3E4954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                    <path d="M18.0005 12C18.0005 12.5523 18.4482 13 19.0005 13C19.5528 13 20.0005 12.5523 20.0005 12C20.0005 11.4477 19.5528 11 19.0005 11C18.4482 11 18.0005 11.4477 18.0005 12Z" stroke="#3E4954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                    <path d="M4.00049 12C4.00049 12.5523 4.4482 13 5.00049 13C5.55277 13 6.00049 12.5523 6.00049 12C6.00049 11.4477 5.55277 11 5.00049 11C4.4482 11 4.00049 11.4477 4.00049 12Z" stroke="#3E4954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                </svg>
                                                            </div>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item text-black" href="{{route('order-detail',$ol->id)}}">
                                                                    <svg class="mr-3" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#6F6F6F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                        <path d="M12 16V12" stroke="#6F6F6F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                        <path d="M12 8H12.01" stroke="#6F6F6F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                    </svg>
                                                                    {{__('sentence.viewdetail') }}
                                                                </a>
                                                                @if($ol->delivery_by==1)
                                                                    <a href="javascript:;" data-id="{{($ol->id)}}" data-action="{{route('order.change-status')}}" data-status="ready" class="change-status dropdown-item text-black" title="Ready Order" class="dropdown-item text-black">
                                                                        <svg class="mr-3" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                            <path d="M22 11.08V12C21.9988 14.1564 21.3005 16.2547 20.0093 17.9818C18.7182 19.709 16.9033 20.9725 14.8354 21.5839C12.7674 22.1953 10.5573 22.1219 8.53447 21.3746C6.51168 20.6273 4.78465 19.2461 3.61096 17.4371C2.43727 15.628 1.87979 13.4881 2.02168 11.3363C2.16356 9.18457 2.99721 7.13633 4.39828 5.49707C5.79935 3.85782 7.69279 2.71538 9.79619 2.24015C11.8996 1.76491 14.1003 1.98234 16.07 2.86" stroke="#2F4CDD" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                            <path d="M22 4L12 14.01L9 11.01" stroke="#2F4CDD" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                        </svg>
                                                                        {{__('sentence.ready') }}
                                                                    </a>
                                                                @else
                                                                    <a href="javascript:;" data-toggle="modal" data-target="#exampleModalCenter" title="Ready Order" class="dropdown-item text-black" data-id="{{($ol->id)}}" id="orderId">
                                                                        <svg class="mr-3" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                            <path d="M22 11.08V12C21.9988 14.1564 21.3005 16.2547 20.0093 17.9818C18.7182 19.709 16.9033 20.9725 14.8354 21.5839C12.7674 22.1953 10.5573 22.1219 8.53447 21.3746C6.51168 20.6273 4.78465 19.2461 3.61096 17.4371C2.43727 15.628 1.87979 13.4881 2.02168 11.3363C2.16356 9.18457 2.99721 7.13633 4.39828 5.49707C5.79935 3.85782 7.69279 2.71538 9.79619 2.24015C11.8996 1.76491 14.1003 1.98234 16.07 2.86" stroke="#2F4CDD" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                            <path d="M22 4L12 14.01L9 11.01" stroke="#2F4CDD" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                        </svg>
                                                                        {{__('sentence.ready') }}
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        @elseif($ol->status==5)
                                                        <div class="dropdown ">
                                                            <div class="btn-link" data-toggle="dropdown">
                                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M11.0005 12C11.0005 12.5523 11.4482 13 12.0005 13C12.5528 13 13.0005 12.5523 13.0005 12C13.0005 11.4477 12.5528 11 12.0005 11C11.4482 11 11.0005 11.4477 11.0005 12Z" stroke="#3E4954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                    <path d="M18.0005 12C18.0005 12.5523 18.4482 13 19.0005 13C19.5528 13 20.0005 12.5523 20.0005 12C20.0005 11.4477 19.5528 11 19.0005 11C18.4482 11 18.0005 11.4477 18.0005 12Z" stroke="#3E4954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                    <path d="M4.00049 12C4.00049 12.5523 4.4482 13 5.00049 13C5.55277 13 6.00049 12.5523 6.00049 12C6.00049 11.4477 5.55277 11 5.00049 11C4.4482 11 4.00049 11.4477 4.00049 12Z" stroke="#3E4954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                </svg>
                                                            </div>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item text-black" href="{{route('order-detail',$ol->id)}}">
                                                                    <svg class="mr-3" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#6F6F6F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                        <path d="M12 16V12" stroke="#6F6F6F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                        <path d="M12 8H12.01" stroke="#6F6F6F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                    </svg>
                                                                    {{__('sentence.viewdetail') }}
                                                                </a>
                                                                <a href="javascript:;" data-id="{{($ol->id)}}" data-action="{{route('order.change-status')}}" data-status="ready-for-delivery" class="change-status dropdown-item text-info" title="Ready For Delivery">
                                                                    <svg class="mr-3" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M22 11.08V12C21.9988 14.1564 21.3005 16.2547 20.0093 17.9818C18.7182 19.709 16.9033 20.9725 14.8354 21.5839C12.7674 22.1953 10.5573 22.1219 8.53447 21.3746C6.51168 20.6273 4.78465 19.2461 3.61096 17.4371C2.43727 15.628 1.87979 13.4881 2.02168 11.3363C2.16356 9.18457 2.99721 7.13633 4.39828 5.49707C5.79935 3.85782 7.69279 2.71538 9.79619 2.24015C11.8996 1.76491 14.1003 1.98234 16.07 2.86" stroke="#2F4CDD" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                        <path d="M22 4L12 14.01L9 11.01" stroke="#2F4CDD" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                    </svg>
                                                                    {{__('sentence.outfordel') }}
                                                                </a>
                                                            </div>
                                                        </div>
                                                        @elseif($ol->status==6)
                                                        <div class="dropdown ">
                                                            <div class="btn-link" data-toggle="dropdown">
                                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M11.0005 12C11.0005 12.5523 11.4482 13 12.0005 13C12.5528 13 13.0005 12.5523 13.0005 12C13.0005 11.4477 12.5528 11 12.0005 11C11.4482 11 11.0005 11.4477 11.0005 12Z" stroke="#3E4954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                    <path d="M18.0005 12C18.0005 12.5523 18.4482 13 19.0005 13C19.5528 13 20.0005 12.5523 20.0005 12C20.0005 11.4477 19.5528 11 19.0005 11C18.4482 11 18.0005 11.4477 18.0005 12Z" stroke="#3E4954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                    <path d="M4.00049 12C4.00049 12.5523 4.4482 13 5.00049 13C5.55277 13 6.00049 12.5523 6.00049 12C6.00049 11.4477 5.55277 11 5.00049 11C4.4482 11 4.00049 11.4477 4.00049 12Z" stroke="#3E4954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                </svg>
                                                            </div>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a href="javascript:;" data-id="{{($ol->id)}}" data-action="{{route('order.change-status')}}" data-status="delivered" class="change-status dropdown-item text-info" title="Ready For Delivery">
                                                                    <svg class="mr-3" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M22 11.08V12C21.9988 14.1564 21.3005 16.2547 20.0093 17.9818C18.7182 19.709 16.9033 20.9725 14.8354 21.5839C12.7674 22.1953 10.5573 22.1219 8.53447 21.3746C6.51168 20.6273 4.78465 19.2461 3.61096 17.4371C2.43727 15.628 1.87979 13.4881 2.02168 11.3363C2.16356 9.18457 2.99721 7.13633 4.39828 5.49707C5.79935 3.85782 7.69279 2.71538 9.79619 2.24015C11.8996 1.76491 14.1003 1.98234 16.07 2.86" stroke="#2F4CDD" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                        <path d="M22 4L12 14.01L9 11.01" stroke="#2F4CDD" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                    </svg>
                                                                    {{__('sentence.delivered') }}
                                                                </a>
                                                            </div>
                                                        </div>
                                                        @elseif($ol->status==7)
                                                        <div class="dropdown ">
                                                            <div class="btn-link" data-toggle="dropdown">
                                                              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                  <path d="M11.0005 12C11.0005 12.5523 11.4482 13 12.0005 13C12.5528 13 13.0005 12.5523 13.0005 12C13.0005 11.4477 12.5528 11 12.0005 11C11.4482 11 11.0005 11.4477 11.0005 12Z" stroke="#3E4954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                  <path d="M18.0005 12C18.0005 12.5523 18.4482 13 19.0005 13C19.5528 13 20.0005 12.5523 20.0005 12C20.0005 11.4477 19.5528 11 19.0005 11C18.4482 11 18.0005 11.4477 18.0005 12Z" stroke="#3E4954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                  <path d="M4.00049 12C4.00049 12.5523 4.4482 13 5.00049 13C5.55277 13 6.00049 12.5523 6.00049 12C6.00049 11.4477 5.55277 11 5.00049 11C4.4482 11 4.00049 11.4477 4.00049 12Z" stroke="#3E4954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                              </svg>
                                                            </div>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item text-black" href="{{route('order-detail',$ol->id)}}">
                                                                    <svg class="mr-3" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#6F6F6F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                        <path d="M12 16V12" stroke="#6F6F6F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                        <path d="M12 8H12.01" stroke="#6F6F6F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                    </svg>
                                                                    {{__('sentence.viewdetail') }}
                                                                </a>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            
                            {{-- <div class="table-responsive">
                                <table id="orderList" class="display" style="min-width: 845px">
                                    <thead>
                                        <tr>
                                           <th>{{__('sentence.order') }}</th>
                                           <th>{{__('sentence.date') }}</th>
                                           <th>{{__('sentence.name') }}</th>
                                           <th>{{__('sentence.location') }}</th>
                                           <th>{{__('sentence.amount') }}</th>
                                           <th>{{__('sentence.status') }}</th>
                                           <th></th>
                                       </tr>
                                   </thead>
                                   <tbody>
                                        @foreach($orderList as $ol)  
                                        <tr>
                                          <td><a href="{{route('order-detail',$ol->id)}}">#{{$ol->id}}</a></td>
                                          <td>{{date('d-m-Y h:i A', strtotime($ol->created_at))}}
                                        </td>
                                          <td>{{$ol->user->display_name}}</td>
                                          <td>{{$ol->user->location->address}}</td>
                                          <td align="right"><b>{{!empty($currency)?$currency->symbol:''}} {{$ol->pay_total}}</b></td>
                                          <td>
                                            @if($ol->status==2)
                                            <a class="btn bgl-warning text-warning btn-sm">{{ __('sentence.pen') }}</a>
                                            @elseif($ol->status==3)
                                            <a class="btn bgl-light btn-sm">{{ __('sentence.can') }}</a>
                                            @elseif($ol->status==4)
                                            <a class="btn bgl-success text-success  btn-sm">{{ __('sentence.acc') }}</a>
                                            @elseif($ol->status==5)
                                            <a class="btn bgl-info text-info btn-sm">{{ __('sentence.ready') }}</a>
                                            @elseif($ol->status==6)
                                            <a class="btn bgl-primary text-primary btn-sm">{{ __('sentence.delc') }}</a>
                                            @else
                                            <a class="btn bgl-dark text-dark  btn-sm">{{ __('sentence.delv') }}</a>
                                            @endif
                                          </td>
                                          <td>
                                            @if($ol->status==2)
                                              <div class="dropdown ml-auto">
                                                <div class="btn-link" data-toggle="dropdown">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                  <path d="M11.0005 12C11.0005 12.5523 11.4482 13 12.0005 13C12.5528 13 13.0005 12.5523 13.0005 12C13.0005 11.4477 12.5528 11 12.0005 11C11.4482 11 11.0005 11.4477 11.0005 12Z" stroke="#3E4954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                  <path d="M18.0005 12C18.0005 12.5523 18.4482 13 19.0005 13C19.5528 13 20.0005 12.5523 20.0005 12C20.0005 11.4477 19.5528 11 19.0005 11C18.4482 11 18.0005 11.4477 18.0005 12Z" stroke="#3E4954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                  <path d="M4.00049 12C4.00049 12.5523 4.4482 13 5.00049 13C5.55277 13 6.00049 12.5523 6.00049 12C6.00049 11.4477 5.55277 11 5.00049 11C4.4482 11 4.00049 11.4477 4.00049 12Z" stroke="#3E4954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                              </div>
                                              <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item text-black" href="{{route('order-detail',$ol->id)}}">
                                                <svg class="mr-3" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                  <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#6F6F6F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                  <path d="M12 16V12" stroke="#6F6F6F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                  <path d="M12 8H12.01" stroke="#6F6F6F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                               {{__('sentence.viewdetail') }}
                                                </a>
                                                <a href="javascript:;" class="change-status dropdown-item text-black" data-id="{{($ol->id)}}" data-action="{{route('order.change-status')}}" data-status="accepted" title="Accept Order" >
                                                <svg class="mr-3" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                  <path d="M22 11.08V12C21.9988 14.1564 21.3005 16.2547 20.0093 17.9818C18.7182 19.709 16.9033 20.9725 14.8354 21.5839C12.7674 22.1953 10.5573 22.1219 8.53447 21.3746C6.51168 20.6273 4.78465 19.2461 3.61096 17.4371C2.43727 15.628 1.87979 13.4881 2.02168 11.3363C2.16356 9.18457 2.99721 7.13633 4.39828 5.49707C5.79935 3.85782 7.69279 2.71538 9.79619 2.24015C11.8996 1.76491 14.1003 1.98234 16.07 2.86" stroke="#2F4CDD" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                  <path d="M22 4L12 14.01L9 11.01" stroke="#2F4CDD" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                {{__('sentence.accorder') }}
                                                </a>
                                                <a class="dropdown-item text-black" href="#">
                                                <svg class="mr-3" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                  <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#F24242" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                  <path d="M15 9L9 15" stroke="#F24242" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                  <path d="M9 9L15 15" stroke="#F24242" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                               {{__('sentence.canorder') }}
                                                </a>
                                                </div>
                                              </div>
                                              @elseif($ol->status==4)

                                              <div class="dropdown ml-auto">
                                                <div class="btn-link" data-toggle="dropdown">
                                                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                  <path d="M11.0005 12C11.0005 12.5523 11.4482 13 12.0005 13C12.5528 13 13.0005 12.5523 13.0005 12C13.0005 11.4477 12.5528 11 12.0005 11C11.4482 11 11.0005 11.4477 11.0005 12Z" stroke="#3E4954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                  <path d="M18.0005 12C18.0005 12.5523 18.4482 13 19.0005 13C19.5528 13 20.0005 12.5523 20.0005 12C20.0005 11.4477 19.5528 11 19.0005 11C18.4482 11 18.0005 11.4477 18.0005 12Z" stroke="#3E4954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                  <path d="M4.00049 12C4.00049 12.5523 4.4482 13 5.00049 13C5.55277 13 6.00049 12.5523 6.00049 12C6.00049 11.4477 5.55277 11 5.00049 11C4.4482 11 4.00049 11.4477 4.00049 12Z" stroke="#3E4954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                  </svg>
                                                </div>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                  <a class="dropdown-item text-black" href="{{route('order-detail',$ol->id)}}">
                                                  <svg class="mr-3" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                  <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#6F6F6F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                  <path d="M12 16V12" stroke="#6F6F6F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                  <path d="M12 8H12.01" stroke="#6F6F6F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                  </svg>
                                                 {{__('sentence.viewdetail') }}
                                                  </a>
                                                  @if($ol->delivery_by==1)
                                                  <a href="javascript:;" data-id="{{($ol->id)}}" data-action="{{route('order.change-status')}}" data-status="ready" class="change-status dropdown-item text-black" title="Ready Order" class="dropdown-item text-black">
                                                  <svg class="mr-3" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                  <path d="M22 11.08V12C21.9988 14.1564 21.3005 16.2547 20.0093 17.9818C18.7182 19.709 16.9033 20.9725 14.8354 21.5839C12.7674 22.1953 10.5573 22.1219 8.53447 21.3746C6.51168 20.6273 4.78465 19.2461 3.61096 17.4371C2.43727 15.628 1.87979 13.4881 2.02168 11.3363C2.16356 9.18457 2.99721 7.13633 4.39828 5.49707C5.79935 3.85782 7.69279 2.71538 9.79619 2.24015C11.8996 1.76491 14.1003 1.98234 16.07 2.86" stroke="#2F4CDD" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                  <path d="M22 4L12 14.01L9 11.01" stroke="#2F4CDD" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                  </svg>
                                                 {{__('sentence.ready') }}
                                                  </a>
                                                  @else
                                                  <a href="javascript:;" data-toggle="modal" data-target="#exampleModalCenter" title="Ready Order" class="dropdown-item text-black" data-id="{{($ol->id)}}" id="orderId">
                                                  <svg class="mr-3" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                  <path d="M22 11.08V12C21.9988 14.1564 21.3005 16.2547 20.0093 17.9818C18.7182 19.709 16.9033 20.9725 14.8354 21.5839C12.7674 22.1953 10.5573 22.1219 8.53447 21.3746C6.51168 20.6273 4.78465 19.2461 3.61096 17.4371C2.43727 15.628 1.87979 13.4881 2.02168 11.3363C2.16356 9.18457 2.99721 7.13633 4.39828 5.49707C5.79935 3.85782 7.69279 2.71538 9.79619 2.24015C11.8996 1.76491 14.1003 1.98234 16.07 2.86" stroke="#2F4CDD" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                  <path d="M22 4L12 14.01L9 11.01" stroke="#2F4CDD" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                  </svg>
                                                  {{__('sentence.ready') }}
                                                  </a>
                                                  @endif
                                                </div>
                                              </div>
                                              @elseif($ol->status==5)
                                              <div class="dropdown ml-auto">
                                                <div class="btn-link" data-toggle="dropdown">
                                                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                  <path d="M11.0005 12C11.0005 12.5523 11.4482 13 12.0005 13C12.5528 13 13.0005 12.5523 13.0005 12C13.0005 11.4477 12.5528 11 12.0005 11C11.4482 11 11.0005 11.4477 11.0005 12Z" stroke="#3E4954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                  <path d="M18.0005 12C18.0005 12.5523 18.4482 13 19.0005 13C19.5528 13 20.0005 12.5523 20.0005 12C20.0005 11.4477 19.5528 11 19.0005 11C18.4482 11 18.0005 11.4477 18.0005 12Z" stroke="#3E4954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                  <path d="M4.00049 12C4.00049 12.5523 4.4482 13 5.00049 13C5.55277 13 6.00049 12.5523 6.00049 12C6.00049 11.4477 5.55277 11 5.00049 11C4.4482 11 4.00049 11.4477 4.00049 12Z" stroke="#3E4954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                  </svg>
                                                </div>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item text-black" href="{{route('order-detail',$ol->id)}}">
                                                  <svg class="mr-3" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                  <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#6F6F6F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                  <path d="M12 16V12" stroke="#6F6F6F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                  <path d="M12 8H12.01" stroke="#6F6F6F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                  </svg>
                                                  {{__('sentence.viewdetail') }}
                                                  </a>
                                                  <a href="javascript:;" data-id="{{($ol->id)}}" data-action="{{route('order.change-status')}}" data-status="ready-for-delivery" class="change-status dropdown-item text-info" title="Ready For Delivery">
                                                  <svg class="mr-3" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                  <path d="M22 11.08V12C21.9988 14.1564 21.3005 16.2547 20.0093 17.9818C18.7182 19.709 16.9033 20.9725 14.8354 21.5839C12.7674 22.1953 10.5573 22.1219 8.53447 21.3746C6.51168 20.6273 4.78465 19.2461 3.61096 17.4371C2.43727 15.628 1.87979 13.4881 2.02168 11.3363C2.16356 9.18457 2.99721 7.13633 4.39828 5.49707C5.79935 3.85782 7.69279 2.71538 9.79619 2.24015C11.8996 1.76491 14.1003 1.98234 16.07 2.86" stroke="#2F4CDD" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                  <path d="M22 4L12 14.01L9 11.01" stroke="#2F4CDD" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                  </svg>
                                                 {{__('sentence.outfordel') }}
                                                  </a>
                                                </div>
                                              </div>
                                              @elseif($ol->status==6)
                                              <div class="dropdown ml-auto">
                                                <div class="btn-link" data-toggle="dropdown">
                                                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                  <path d="M11.0005 12C11.0005 12.5523 11.4482 13 12.0005 13C12.5528 13 13.0005 12.5523 13.0005 12C13.0005 11.4477 12.5528 11 12.0005 11C11.4482 11 11.0005 11.4477 11.0005 12Z" stroke="#3E4954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                  <path d="M18.0005 12C18.0005 12.5523 18.4482 13 19.0005 13C19.5528 13 20.0005 12.5523 20.0005 12C20.0005 11.4477 19.5528 11 19.0005 11C18.4482 11 18.0005 11.4477 18.0005 12Z" stroke="#3E4954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                  <path d="M4.00049 12C4.00049 12.5523 4.4482 13 5.00049 13C5.55277 13 6.00049 12.5523 6.00049 12C6.00049 11.4477 5.55277 11 5.00049 11C4.4482 11 4.00049 11.4477 4.00049 12Z" stroke="#3E4954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                  </svg>
                                                </div>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                  <a href="javascript:;" data-id="{{($ol->id)}}" data-action="{{route('order.change-status')}}" data-status="delivered" class="change-status dropdown-item text-info" title="Ready For Delivery">
                                                  <svg class="mr-3" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                  <path d="M22 11.08V12C21.9988 14.1564 21.3005 16.2547 20.0093 17.9818C18.7182 19.709 16.9033 20.9725 14.8354 21.5839C12.7674 22.1953 10.5573 22.1219 8.53447 21.3746C6.51168 20.6273 4.78465 19.2461 3.61096 17.4371C2.43727 15.628 1.87979 13.4881 2.02168 11.3363C2.16356 9.18457 2.99721 7.13633 4.39828 5.49707C5.79935 3.85782 7.69279 2.71538 9.79619 2.24015C11.8996 1.76491 14.1003 1.98234 16.07 2.86" stroke="#2F4CDD" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                  <path d="M22 4L12 14.01L9 11.01" stroke="#2F4CDD" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                  </svg>
                                                  {{__('sentence.delivered') }}
                                                  </a>
                                                </div>
                                              </div>
                                              @elseif($ol->status==7)
                                              <div class="dropdown ml-auto">
                                                <div class="btn-link" data-toggle="dropdown">
                                                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                  <path d="M11.0005 12C11.0005 12.5523 11.4482 13 12.0005 13C12.5528 13 13.0005 12.5523 13.0005 12C13.0005 11.4477 12.5528 11 12.0005 11C11.4482 11 11.0005 11.4477 11.0005 12Z" stroke="#3E4954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                  <path d="M18.0005 12C18.0005 12.5523 18.4482 13 19.0005 13C19.5528 13 20.0005 12.5523 20.0005 12C20.0005 11.4477 19.5528 11 19.0005 11C18.4482 11 18.0005 11.4477 18.0005 12Z" stroke="#3E4954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                  <path d="M4.00049 12C4.00049 12.5523 4.4482 13 5.00049 13C5.55277 13 6.00049 12.5523 6.00049 12C6.00049 11.4477 5.55277 11 5.00049 11C4.4482 11 4.00049 11.4477 4.00049 12Z" stroke="#3E4954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                  </svg>
                                                </div>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                  <a class="dropdown-item text-black" href="{{route('order-detail',$ol->id)}}">
                                                  <svg class="mr-3" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                  <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#6F6F6F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                  <path d="M12 16V12" stroke="#6F6F6F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                  <path d="M12 8H12.01" stroke="#6F6F6F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                  </svg>
                                                 {{__('sentence.viewdetail') }}
                                                  </a>
                                                </div>
                                              </div>
                                          @endif
                                          </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Delivery Detail</h5>
            <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
            </button>
          </div>
          <div class="modal-body">
            {{ Form::open(['url' => route('delivery-detail'), 'method'=>'POST', 'files'=>true, 'name' => 'frmDeliveryDetail', 'id' => 'frmDeliveryDetail','class'=>"form-main"]) }}
            <input type="hidden" id='order_id' name="order_id">
            <div class="row">
             <div class="col-xl-12">
              <div class="form-group row">
                <label class="col-sm-12">Delivery Person Name</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="del_name"  placeholder="" required="">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-12"> Delivery Person Telephone</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="del_mo"  placeholder="" required="">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-12 col-form-label"> Delivery Code</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="delivery_code"  placeholder="" required="">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-12 col-form-label">Delivery Time</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="del_time"  placeholder="" required="" id="del_time" readonly>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-warning" id="btnSubmit" name="btnSubmit" >Submit</button>
            </div>
            {{ Form::close() }}
          </div>
        </div>
      </div>
@endsection
@section('pageScript')
<script src="{{ asset('public/frontend/js/moment.min.js')}}"></script>
<script src="{{ asset('public/frontend/js/moment-timezone.min.js')}}"></script>
<script src="{{asset('public/frontend/chef-dashboard/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/frontend/chef-dashboard/vendor/datatables/js/absolute.js')}}"></script>
<script type="text/javascript" src="{{ asset('public/frontend/js/pages/order-queue.js')}}"></script>
@endsection 
  