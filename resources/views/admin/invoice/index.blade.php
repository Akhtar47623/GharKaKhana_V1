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
                        <table id="invoiceList" class="table table-striped table-bordered" cellspacing="0" width="100%">
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
                                    <th>Ord. No</th>
                                    <th>RFC</th>
                                    <th>CURP</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Address</th>
                                    <th>Municipality</th>
                                    <th>State</th>
                                    <th>Zipcode</th>
                                    <th >Status</th>
                                    <th class="disabled-sorting text-right" width="12%">Actions</th>
                                    
                                </tr>
                            </thead>
                            <tfoot>
                            </tfoot>
                            <tbody>
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
    $('#invoiceList').dataTable({
                processing: true,
                serverSide: true,
                "ajax": {
                    url: BASEURL + 'mexico-invoice/list',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                "responsive": true,
                "columns": [
                    {data: 'itechcheck', name: 'itechcheck', class: 'text-center', 'bSortable': false},
                    {data: 'order_id', name: 'order_id'},
                    {data: 'rfc', name: 'rfc'},
                    {data: 'curp', name: 'curp'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'mobile', name: 'mobile'},
                    {data: 'address', name: 'address'},
                    {data: 'city', name: 'city'},
                    {data: 'state', name: 'state'},
                    {data: 'zipcode', name: 'zipcode'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action',class:'text-right'}                     
                ],
                "columnDefs": [
                    {"searchable": true, "bSortable": false, "targets": [0, 3]},

                ]
            });

</script>
@stop