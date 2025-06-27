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
                            @if($permission::checkActionPermission('create_taxes')) 
                            <a href="{{ route('taxes.create') }}" class="btn btn-primary" title="Add new"><i class="fa fa-plus-circle"></i> ADD</a>
                            @endif
                            @if($permission::checkActionPermission('delete_taxes'))
                            <button class="btn btn btn-primary delete_all" 
                                    data-message_error_alert="{{ Config::get('constants.message.message_error_alert') }}" 
                                    data-message_confirm_alert="{{ Config::get('constants.message.message_confirm_alert') }}" 
                                    data-action="{{ route('taxesmultidelete') }}"
                                    data-table_id="statedata"><i class="now-ui-icons ui-1_simple-remove delete_all"></i> Delete Selected
                            </button>
                            @endif
                        </h3>
                        <ol class="breadcrumb">
                            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                            <li><a href="#">{{ $title }}</a></li>
                        </ol>
                    </div>
                    <div class="box-body">
                        <table id="taxesList" class="table table-striped table-bordered" cellspacing="0" width="100%">
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
                                <th>Country</th>
                                <th>State</th>
                                <th>City</th>
                                <th>Currency</th>
                                <th>Chef Comm.</th>
                                <th>Del. Comm.</th>
                                <th>Ser. Fee Base</th>
                                <th>Ser. Fee %</th>
                                <th>Tax</th>
                                <th>CC Fees</th>
                                <th>House</th>                                
                                <th class="disabled-sorting text-right" width="10%">Actions</th>
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
    $('#taxesList').dataTable({
                processing: true,
                serverSide: true,
                "ajax": {
                    url: BASEURL + 'taxes/list',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                "responsive": true,
                "columns": [
                    {data: 'itechcheck', name: 'itechcheck', class: 'text-center', 'bSortable': false},                    
                    {data: 'country_id', name: 'country_id'},
                    {data: 'state_id', name: 'state_id'},
                    {data: 'city_id', name: 'city_id'},
                    {data: 'currency', name: 'currency'},
                    {data: 'chef_commission', name: 'chef_commission'},
                    {data: 'delivery_commission', name: 'delivery_commission'},
                    {data: 'service_fee_base', name: 'service_fee_base'},
                    {data: 'service_fee_per', name: 'service_fee_per'},
                    {data: 'tax', name: 'tax'},
                    {data: 'cc_fees', name: 'cc_fees'},
                    {data: 'house', name: 'house'},
                    {data: 'action', name: 'action',class:'text-right'}
                ],
                "columnDefs": [
                    {"searchable": true, "bSortable": false, "targets": [0, 3]},

                ]
            });
</script>
@stop