@extends('frontend.chef-dashboard.layouts.app')@section('pageCss')
<link href="{{asset('public/frontend/chef-dashboard/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">

@endsection
@section('content')
<div class="content-body">
    <div class="container-fluid">
        @section('pageHeading')
        <h2>Blog</h2>
        @endsection

        <!-- row -->
        <div class="row">
            <div class="col-xl-12">  
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h4>Blog List</h4>
                        </div>
                        <a href="{{ route('blog.create') }}" class="btn btn-xs btn-warning" title="Add new">
                            <i class="fa fa-plus-circle"></i>ADD BLOG</a>
                    </div>
                </div>
            </div>
            @if(!$blogData->isEmpty())
            @foreach ($blogData as $value)
            <div class="col-xl-12 col-xxl-6 col-md-6">  
                <div class="card">
                    
                    <div class="card-body border-bottom">
                        <div class="media mb-3">
                            <img class="rounded" src="{{asset('public/frontend/images/blog')}}/{{$value->image}}" style="width:100%;" alt="">
                        </div>
                        <div class="info">
                            <div class="row">
                                <div class="col-md-10 col-10">
                                    <h5 class="text-black mb-3">{{$value->title}}</h5>
                                </div>
                                <div class="col-md-2 col-2">
                                    <div class="dropdown ml-auto">
                                        <div class="btn-link" data-toggle="dropdown">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="12" cy="5" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="19" r="2"></circle></g></svg>
                                        </div>
                                        <div class="dropdown-menu dropdown-menu-right border py-0">
                                            <div class="py-2">
                                                <a href="{{route('blog.edit', $value->uuid)}}" class="dropdown-item">{{__('sentence.edit')}}</a>
                                                <a id="item" type="delete" title="Delete" rel="tooltip" class="dropdown-item text-danger sharp remove delete"  data-id="{{($value->id)}}"  data-action="{{route('blog.destroy', $value->id)}}" data-message="{{__('validation.confirm')}}">{{__('sentence.delete')}}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                        
                        </div>
                    </div>


                </div>
            </div>
            @endforeach
            @endif  
            
        </div>
        @endsection
        @section('pageScript')
        <script src="{{asset('public/frontend/chef-dashboard/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
        @endsection 