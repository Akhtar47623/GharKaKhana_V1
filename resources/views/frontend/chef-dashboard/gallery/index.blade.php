@extends('frontend.chef-dashboard.layouts.app')
@section('pageCss')
<link rel="stylesheet" href="{{ asset('public/frontend/chef-dashboard/vendor/dropzone/dist/dropzone.css')}}">
@endsection
@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="dashboard-item-box">
            @section('pageHeading')
            <h2>{{__('sentence.gallery') }}</h2>
            @endsection   
            <div class="row">
                <div class="col-lg-12">
                    <div class="card"> 
                        <div class="card-body" id="cbody" style="display: none">                           
                            <div class="dashboard-items-content">
                                <form method="post" action="{{url('image/upload/store')}}" enctype="multipart/form-data" class="dropzone" id="dropzone">
                                    {!! csrf_field() !!}
                                </form>
                                <div class="gallery-images" id="gellery">
                                    <ul class="popup-gallery">
                                        @foreach($gelleryData as $gellery)
                                        <li>
                                            <div class="dashboard-gallery-img" style="background-image: url('{{asset('public/frontend/images/gellery/'.$gellery->filename)}}');">
                                                <a id="image" type="delete" title="Delete" rel="tooltip" class="delete-img"  data-id="{{($gellery->id)}}"  data-action="{{ url('/image/delete/'.$gellery->id) }}" data-message="{{__('validation.confirm')}}"><i id="rem" class="btn btn-danger shadow btn-xs sharp mr-1 fa fa-trash-alt"></i></a>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
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
<script src="{{ asset('public/frontend/chef-dashboard/vendor/dropzone/dist/dropzone.js')}}"></script>
<script type="text/javascript" src="{{ asset('public/frontend/js/easy-responsive-tabs.js')}}"></script>
<script type="text/javascript" src="{{ asset('public/frontend/js/pages/gallery.js')}}"></script>
@endsection 