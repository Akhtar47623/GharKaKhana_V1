@extends('admin.layouts.master')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border content-header">
                        <h3>{{ $title }}  
                           <!--  <a href="{{ route('users.create') }}" class="btn btn btn-primary" title="Add new"><i class="fa fa-plus-circle"></i> ADD</a>
                            <button class="btn btn btn-primary delete_all" 
                                    data-message_error_alert="{{ Config::get('constants.message.message_error_alert') }}" 
                                    data-message_confirm_alert="{{ Config::get('constants.message.message_confirm_alert') }}" 
                                    data-action="{{ route('citymultidelete') }}"
                                    data-table_id="citydata"><i class="now-ui-icons ui-1_simple-remove delete_all"></i> Delete Selected
                            </button> -->
                        </h3>
                        <ol class="breadcrumb">
                            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                            <li><a href="#">{{ $title }}</a></li>
                        </ol>
                    </div>
                    <div class="box-body">
                        <table id="userList" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                         <!--        <th>
                                    <div class="form-check pull-left">
                                        <label class="form-check-label">
                                          <input type="checkbox" id="master" class="form-check-input">
                                          <span class="form-check-sign"></span>
                                        </label>
                                    </div>
                              </th> -->
                                <th>Profile</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                    <tfoot>
                    </tfoot>
                  <tbody>
                    @if(!empty($chefList))
                    @foreach ($chefList as $value)
                    <tr>
                      <!-- <td>
                         <div class="form-check pull-left">
                            <label class="form-check-label">
                              <input type="checkbox" id="master" class="sub_chk" data-id="{{$value->id}}">
                              <span class="form-check-sign"></span>
                            </label>    
                        </div>
                    </td> -->
                        <td><img class=" img-responsive img-circle" style="margin: 0 auto;width: 50px;border: 3px solid #d2d6de;" src="{{asset('public/frontend/images/users/'.$value->profile)}}" /></td>
                        <td>{{$value->display_name}}</td>
                        <td>{{$value->email}}</td>
                        <td>{{$value->mobile}}</td>
                        <td>  <input data-id="{{$value->id}}" class="toggle_class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $value->status=='A' ? 'checked' : ''}}></td>
                        <td class="text-right">
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
<script>$(function() {
$('.toggle_class').change(function() {
  var status = $(this).prop('checked') == true ? 'A' : 'I'; 
    var id = $(this).data('id');
    $.ajax({
      type: "post",
      dataType: "json",
      url: 'changeverifystatus',
       headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      data: {'status': status, 'id': id},
      success: function(data){
        console.log(data.success)
      }
    });
  })
  })</script>
@stop