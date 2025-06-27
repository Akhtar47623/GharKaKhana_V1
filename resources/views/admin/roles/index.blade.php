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
                            @if($permission::checkActionPermission('create_roles'))
                            <a href="{{ route('roles.create') }}" class="btn btn-primary" title="Add new"><i class="fa fa-plus-circle"></i> ADD</a>
                            @endif
                            @if($permission::checkActionPermission('delete_roles'))
                            <button class="btn btn-primary delete_all" 
                                    data-message_error_alert="{{ Config::get('constants.message.message_error_alert') }}" 
                                    data-message_confirm_alert="{{ Config::get('constants.message.message_confirm_alert') }}" 
                                    data-action="{{ route('rolesmultidelete') }}"
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
                        <table id="rolesdata" class="table table-striped table-bordered" cellspacing="0" width="100%">
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
                                <th width="30%">Name</th>
                                <th width="30%">Created At</th>
                                <th class="disabled-sorting text-right">Actions</th>
                            </tr>
                        </thead>
                    <tfoot>
                    </tfoot>
                  <tbody>
                    @if(!empty($role))
                    @foreach ($role as $value)
                    <tr>
                      <td>
                         <div class="form-check pull-left">
                            <label class="form-check-label">
                              <input type="checkbox" id="master" class="sub_chk" data-id="{{$value->id}}">
                              <span class="form-check-sign"></span>
                            </label>    
                        </div>
                    </td>
                      <td>{{$value->name}}</td>
                      <td>{{$value->created_at}}</td>
                      <td class="text-right">
                        @if($permission::checkActionPermission('update_roles'))
                        <a href="{{route('roles.edit', $value->id)}}" title="Edit" class="btn btn-round btn-warning"><i class="fa fa-pencil"></i></a>
                        @endif
                        @if($permission::checkActionPermission('delete_roles'))
                        <button id="role" type="button" title="Delete" rel="tooltip" class="btn  btn-danger remove"  data-id="{{($value->id)}}"  data-action="{{route('roles.destroy', $value->id)}}" data-message="{{Config::get('constants.message.confirm')}}"><i class="fa fa-trash"></i></button>
                        @endif
                        <a href="{{route('roles.permission',$value->uuid)}}" title="Permission" rel="tooltip"class="btn btn-primary" title="Add new"><i class="fa fa-lock"></i></a>
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
<script src="{{ asset('public/backend/js/pages/roles.js') }}"></script>
<script src="{{asset('public/backend/common/jquery.validate.js')}}"></script>
@stop