@extends('frontend.chef-dashboard.layouts.app')
@section('pageCss')
<link href="{{asset('public/frontend/chef-dashboard/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
@endsection
@section('content')
  	<div class="content-body">
        <div class="container-fluid">
           @section('pageHeading')
           <h2>{{__('sentence.menugroup') }}</h2>
           @endsection 
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Setting</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">{{__('sentence.menugroup') }}</a></li>
                    </ol>
                </div>
           </div>
            <!-- row -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{__('sentence.menugroupol') }}</h4>
                                <a href="{{ route('group.create') }}" class="btn btn-xs btn-warning" title="Add new">
                            <i class="fa fa-plus-circle"></i> {{__('sentence.addgroup') }}</a>
                            </div>
                            <div class="card-body">
                                @if(!empty($groupData))
                                @foreach ($groupData as $value)
                                <div class="sp11 row border-bottom favorites-items p-3 align-items-center p-sm-4">
                                    <div class="col-xl-6 col-lg-6 col-sm-6 col-12 mb-lg-0">
                                        <i class="fa fa-group" style="font-size:36px"></i>
                                        <span class="text-warning" style="display:block;">{{__('sentence.name') }}</span>
                                        <h4 class="">{{$value->group_name}}</h4>
                                    </div>
                                    <div class="col-xl-2 col-lg-2 col-sm-2 col-4 ">
                                        <div class="media-body">
                                            <span class="text-warning " style="display: block;">{{__('sentence.option') }}</span>
                                            <span class="text-black">{{$value->option == 'M'?"MULTIPLE":"SINGLE"}}</span>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-2 col-sm-2 col-5">
                                        <div class="media-body ">
                                           <span class="text-warning" style="display: block;">{{__('sentence.requ') }}</span>
                                           <span class="text-black">{{$value->required == '1'?"YES":"NO"}}</span>
                                        </div>                                        
                                    </div>
                                    <div class="col-xl-2 col-lg-2 col-sm-2 col-3 text-right">
                                        <div class="media-body"></div>
                                        <span class="text-warning" style="display: block;">
                                            <div class="dropdown" style="margin-top: 25px">
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
                                                        <a href="{{route('group.edit', $value->uuid)}}" class="dropdown-item">{{__('sentence.edit')}}</a>
                                                        <a id="item" type="delete" title="Delete" rel="tooltip" class="dropdown-item text-danger sharp remove delete"  data-id="{{($value->id)}}"  data-action="{{route('group.destroy', $value->uuid)}}" data-message="{{__('validation.confirm')}}">{{__('sentence.delete')}}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </span> 
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
<script>$('#groupList').DataTable({});</script>
@endsection 
