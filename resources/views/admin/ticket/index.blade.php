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
                           <!--  @if($permission::checkActionPermission('create_ticket_category'))
                            <a href="{{ route('ticket-category.create') }}" class="btn btn btn-primary" title="Add new"><i class="fa fa-plus-circle"></i> ADD</a>
                            @endif -->
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
                                    <th>No</th>
                                    <th>Order</th>
                                    <th>Category Name</th>
                                    <th>Sub Category</th>
                                    <th>Created By</th>
                                    <th>To</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th class="disabled-sorting text-right">Actions</th>
                                </tr>
                            </thead>
                        <tfoot>
                        </tfoot>
                        <tbody>
                            @if(!empty($ticket))
                            @foreach ($ticket as $value)
                            <tr>
                                <td>
                                    <div class="form-check pull-left">
                                        <label class="form-check-label">
                                          <input type="checkbox" id="master" class="sub_chk" data-id="{{$value->id}}">
                                          <span class="form-check-sign"></span>
                                        </label>    
                                    </div>
                                </td>
                                <td>{{$value->id}}</td>
                                <td><a href="{{route('admin-order-detail',$value->order_id)}}">#{{$value->order_id}}</a></td>
                                    <td>
                                     
                                            @if($value->category->parent_id==0)
                                                Main
                                            @else
                                                @foreach($categories as $cat)
                                                    @if($cat->id == $value->category->parent_id)
                                                        {{$cat->name}}
                                                    @endif
                                                @endforeach 
                                            @endif
                                    </td>
                                <td>{{$value->category->name}}</td>
                                <td>{{$value->user->display_name}}</td>
                                <td>{{$value->to==0 ? 'Support' : 'Chef'}}</td>
                                <td>
                                  @if($value->priority==1)
                                    <h4><span class="label label-danger">Low</span></h4>
                                    @elseif($value->priority==1)
                                    <h4><span class="label label-warning">Medium</span></h4>
                                    @else
                                    <h4><span class="label label-success">High</span></h4>
                                    @endif
                                </td>
                                <td>
                                    @if($value->status==1)
                                    <h4><span class="label label-info">OPEN</span></h4>
                                    @else
                                    <h4><span class="label label-danger">CLOSE</span></h4>
                                    @endif
                                </td>
                                <td class="text-right"> 
                                    @if($permission::checkActionPermission('delete_ticket'))
                                    <button id="country" type="button" title="Delete" rel="tooltip" class="btn  btn-danger remove"  data-id="{{($value->id)}}" data-action="{{route('ticket-delete', $value->id)}}" data-message="{{Config::get('constants.message.confirm')}}"><i class="fa fa-trash"></i></button>
                                    @endif
                                    <button type="button" class="btn btn-default seen_sms" data-target="#modal-default" data-id="{{$value->id}}" ><i class="fa fa-envelope" style="font-size:20px;color:red"></i><span class="label label-warning">{{$value->messages->count()}}</span></button>
                                </td>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                       
                    </div>

                </div>
            </div>
        </div>
        <div class="modal fade in" id="modal-default">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Chat</h4>
                    </div>
                    <div class="modal-body">
                        <div class="box box-primary direct-chat direct-chat-primary">
                           
                            <div class="box-body">
                              <!-- Conversations are loaded here -->
                              <div class="direct-chat-messages" style="height: 400px">
                             
                              </div><!--/.direct-chat-messages-->
                            
                            </div><!-- /.box-body -->
                        
                            <div class="box-footer">
                                {{ Form::open(['url' => route('sendmessage'), 'method'=>'POST', 'files'=>true, 'name' => 'frmMessage', 'id' => 'frmMessage']) }}
                                    <div class="input-group">
                                        <input type="text" name="message"  placeholder="Type Message ..." class="form-control">
                                        <input type="hidden" id="ticket_id" name="ticket_id">
                                        <span class="input-group-btn">
                                            <button type="submit" id="btnSubmit" class="btn btn-primary btn-flat">Send</button>
                                        </span>
                                    </div>   
                                {{ Form::close() }}
                            </div><!-- /.box-footer-->
                         
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                         <input  id="closeTicket" class="btn btn-default pull-left toggle_class" type="button" value="Ticket Close" data-action="{{route('changestatusticket')}}" data-dismiss="modal">
                    </div>
                </div>
            <!-- /.modal-content -->
            </div>
          <!-- /.modal-dialog -->

        </div>
    </section>
</div>

@endsection
@section('pagescript')
<script src="{{asset('public/backend/common/jquery.validate.js')}}"></script>
<script src="{{ asset('public/backend/js/pages/ticket.js') }}"></script>
@stop