@php
$permission = new \App\Model\Permissions();
@endphp
@extends('admin.layouts.master')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border content-header">
                        <h3>{{ $title }}  
                            @if($permission::checkActionPermission('create_discount'))
                            <a href="{{ route('discount.create') }}" class="btn btn btn-primary" title="Add new"><i class="fa fa-plus-circle"></i> ADD</a>
                            @endif
                            @if($permission::checkActionPermission('delete_discount'))
                            <button class="btn btn btn-primary delete_all" 
                            data-message_error_alert="{{ Config::get('constants.message.message_error_alert') }}" 
                            data-message_confirm_alert="{{ Config::get('constants.message.message_confirm_alert') }}" 
                            data-action="{{ route('discountmultidelete') }}"
                            data-table_id="rolesdata"><i class="now-ui-icons ui-1_simple-remove delete_all"></i> Delete Selected
                        </button>
                        @endif
                    </h3>
                    <ol class="breadcrumb">
                        <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">{{ $title }}</a></li>
                    </ol>
                </div>
                <div class="box-body">
                    <table id="categoryList" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>
                                    <div class="form-check pull-left">
                                        <label class="form-check-label">
                                          <input type="checkbox" id="master" class="form-check-input">
                                          <span class="form-check-sign"></span>
                                      </label>
                                  </div>
                              </th>
                              <th>Promo Code</th>
                              <th>Discount Per.</th>    
                              <th>Expired Dt.</th>
                              <th>Total Coupons</th>
                              <th>Total Used Coupons</th>
                              <th>Minimum Order Value</th>                         
                              <th>Country</th>
                              <th>State</th>
                              <th>Status</th>
                              <th class="disabled-sorting text-right" width="10%">Actions</th>
                          </tr>
                        </thead>
                    <tfoot>
                    </tfoot>
                    <tbody>
                        @if(!empty($discountData))
                        @foreach ($discountData as $value)
                        <tr>
                            <td>
                                <div class="form-check pull-left">
                                    <label class="form-check-label">
                                      <input type="checkbox" id="master" class="sub_chk" data-id="{{$value->id}}">
                                      <span class="form-check-sign"></span>
                                    </label>    
                                </div>
                            </td>
                            <td>{{$value->promo_code}}</td>
                            <td>{{$value->company_discount}}</td>
                            <td>{{$value->expired_at}}</td>
                            <td>{{$value->total_coupons}}</td>
                            <td>{{$value->total_used_coupons}}</td>
                            <td>{{$value->minimum_order_value}}</td>
                            <td>{{$value->country_id}}</td>
                            <td>{{$value->state_id!=NULL?$value->state_id:'ALL'}}</td>
                            <td> 
                           	  <input data-id="{{$value->id}}" class="toggle_class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $value->status ? 'checked' : ''}}>
                      	    </td>
                            <td class="text-right">
                                @if($permission::checkActionPermission('update_discount'))
                                <a href="{{route('discount.edit', $value->id)}}" title="Edit" class="btn btn-round btn-warning"><i class="fa fa-pencil"></i></a>
                                @endif
                                @if($permission::checkActionPermission('delete_discount'))
                                <button id="country" type="button" title="Delete" rel="tooltip" class="btn  btn-danger remove"  data-id="{{($value->id)}}"  data-action="{{route('discount.destroy', $value->id)}}" data-message="{{Config::get('constants.message.confirm')}}"><i class="fa fa-trash"></i></button>
                                @endif
                            </td>
                           
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</section>
</div>
@endsection
@section('pagescript')
<script>
  $(function() {
    $('.toggle_class').change(function() {
    var status = $(this).prop('checked') == true ? 1 : 0; 
    var discount = $(this).data('id');
    $.ajax({
      type: "GET",
      dataType: "json",
      url: 'discount-changestatus',
      data: {'status': status, 'discount': discount},
      success: function(data){
        console.log(data.success)
      }
    });
  })
  })
</script>
@stop