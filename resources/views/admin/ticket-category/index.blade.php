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
                            @if($permission::checkActionPermission('create_ticket_category'))
                            <a href="{{ route('ticket-category.create') }}" class="btn btn btn-primary" title="Add new"><i class="fa fa-plus-circle"></i> ADD</a>
                            @endif
                        </h3>
                        <ol class="breadcrumb">
                            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                            <li><a href="#">{{ $title }}</a></li>
                        </ol>
                    </div>
                <div class="box-body">
                    <table id="cuisineList" class="table table-striped table-bordered" cellspacing="0" width="100%">
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
                                <th>Name</th>
                                <th>Parent</th>
                                <th>Status</th>
                                <th class="disabled-sorting text-right">Actions</th>
                            </tr>
                        </thead>
                    <tfoot>
                    </tfoot>
                    <tbody>
                        @if(!empty($ticketCat))
                        @foreach ($ticketCat as $value)
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
                            <td>@if($value->parent_id==0)
                                        Main
                                    @else
                                        @foreach($ticketCat as $cat)
                                            @if($cat->id == $value->parent_id)
                                                {{$cat->name}}
                                            @endif
                                        @endforeach
                                    @endif
                                        
                                </td>
                            <td>
                                <input data-id="{{$value->id}}" class="toggle_class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-action="{{route('changestatuscat')}}" data-tableId="genreList" data-on="Active" data-off="InActive" {{ $value->status==1 ? 'checked' : '' }}>
                            </td>
                            <td class="text-right"> 
                                @if($permission::checkActionPermission('update_ticket_category'))
                                <a href="{{route('ticket-category.edit', $value->id)}}" title="Edit" class="btn btn-round btn-warning"><i class="fa fa-pencil"></i></a>
                                @endif
                                @if($permission::checkActionPermission('delete_ticket_category'))
                                <button id="country" type="button" title="Delete" rel="tooltip" class="btn  btn-danger remove"  data-id="{{($value->id)}}"  data-action="{{route('ticket-category.destroy', $value->id)}}" data-message="{{Config::get('constants.message.confirm')}}"><i class="fa fa-trash"></i></button>
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
<script src="{{asset('public/backend/common/jquery.validate.js')}}"></script>
<script src="{{ asset('public/backend/js/pages/ticket-category.js') }}"></script>

@stop