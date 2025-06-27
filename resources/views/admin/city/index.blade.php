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
                            @if($permission::checkActionPermission('create_cities'))   
                            <a href="{{ route('city.create') }}" class="btn btn btn-primary" title="Add new"><i class="fa fa-plus-circle"></i> ADD</a>
                            @endif
                            @if($permission::checkActionPermission('delete_cities')) 
                            <button class="btn btn btn-primary delete_all" 
                                    data-message_error_alert="{{ Config::get('constants.message.message_error_alert') }}" 
                                    data-message_confirm_alert="{{ Config::get('constants.message.message_confirm_alert') }}" 
                                    data-action="{{ route('citymultidelete') }}"
                                    data-table_id="citydata"><i class="now-ui-icons ui-1_simple-remove delete_all"></i> Delete Selected
                            </button>
                            @endif
                        </h3>
                        <ol class="breadcrumb">
                            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                            <li><a href="#">{{ $title }}</a></li>
                        </ol>
                    </div>
                    <div class="box-body">
                        <table id="cityList" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <td>
                                       <div class="form-check pull-left">
                                            <label class="form-check-label">
                                              <input type="checkbox" id="master" class="sub_chk">
                                              <span class="form-check-sign"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <th width="30%">City</th>
                                    <th width="30%">State</th>
                                    <th class="disabled-sorting text-right">Actions</th>
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
<script type="text/javascript">
    $('#cityList').dataTable({
                processing: true,
                serverSide: true,
                "ajax": {
                    url: BASEURL + 'city/list',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                "responsive": true,
                "columns": [
                    {data: 'itechcheck', name: 'itechcheck', class: 'text-center', 'bSortable': false},
                    {data: 'name', name: 'name'},
                    {data: 'state_id', name: 'state_id'},
                    {data: 'action', name: 'action',class:'text-right'}
                ],
                "columnDefs": [
                    {"searchable": true, "bSortable": false, "targets": [0, 3]},

                ]
            });
</script>
@stop