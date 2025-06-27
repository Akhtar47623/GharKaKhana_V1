@extends('frontend.chef-dashboard.layouts.app')
@section('pageCss')
<link href="{{asset('public/backend/bootstrap-toggle.min.css') }}" rel="stylesheet">
<link href="{{asset('public/frontend/chef-dashboard/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="content-body">
    <div class="container-fluid">
      @section('pageHeading')
      <h2>{{__('sentence.promotions') }}</h2>
      @endsection

      <!-- row -->
      <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h4>{{__('sentence.promotionlist') }}</h4>
                    </div>
                    <a href="{{ route('chef-discount.create') }}" class="btn btn-xs btn-warning" title="Add new">
                        <i class="fa fa-plus-circle"></i> {{__('sentence.addpromo') }}</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                     <th>{{__('sentence.promocode') }}</th>
                                     <th>{{__('sentence.disc') }}</th>
                                     <th>{{__('sentence.expdate') }}</th>
                                     <th>{{__('sentence.totalcoupon') }}</th>
                                     <th>{{__('sentence.totalucoupon') }}</th>
                                     <th>{{__('sentence.status') }}</th>
                                     <th>{{__('sentence.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>

                                @foreach ($chefPromotion as $chefdisc)  

                                <tr>
                                    <td>{{$chefdisc->promo_code}}</td>
                                    <td>{{$chefdisc->discount}}</td>
                                    <td>{{$chefdisc->expired_at}}</td>
                                    <td>{{$chefdisc->total_coupons}}</td>
                                    <td>{{$chefdisc->total_used_coupons}}</td>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" data-id="{{$chefdisc->id}}" class="switch togBtn toggle_class" data-id="" data-action="" {{ $chefdisc->status ? 'checked' : ''}}>
                                            <div class="slider round">
                                                <span class="on">Active</span><span class="off">Inactive</span>
                                            </div>
                                        </label>
                                    </td>
                                    <td> 
                                        <div class="menu-item-action">
                                            <a href="{{route('chef-discount.edit', $chefdisc->uuid)}}" class="btn btn-warning shadow btn-xs sharp mr-1"><i class=" fas fa-pencil-alt"></i></a>
                                            <a id="item" type="delete" title="Delete" rel="tooltip" class="btn btn-danger shadow btn-xs sharp remove delete"  data-id="{{($chefdisc->id)}}"  data-action="{{route('chef-discount.destroy', $chefdisc->id)}}" data-message="{{__('validation.confirm')}}"><i class=" fas fa-trash-alt" aria-hidden="true"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('pageScript')
<script src="{{asset('public/backend/bootstrap-toggle.min.js') }}"></script>
<script src="{{asset('public/frontend/chef-dashboard/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/frontend/chef-dashboard/js/plugins-init/datatables.init.js')}}"></script>
<script type="text/javascript" src="{{ asset('public/frontend/js/pages/chef-discount.js')}}"></script>
@endsection 
