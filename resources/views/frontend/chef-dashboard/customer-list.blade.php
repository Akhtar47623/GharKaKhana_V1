@extends('frontend.chef-dashboard.layouts.app')
@section('pageCss')
<link href="{{asset('public/frontend/chef-dashboard/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="content-body">
    <div class="container-fluid">
      @section('pageHeading')
      <h1 class="login-title">{{__('sentence.custreport') }}</h1>
      @endsection
            <!-- row -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                           <div class="card-title">
                              <h4>{{__('sentence.custreport') }}</h4>
                           </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="custList" class="display" style="min-width: 845px">
                                    <thead>
                                        <tr>
                                           <th>Sr.No</th>
                                           <th>{{__('sentence.name') }}</th>
                                           <th>{{__('sentence.location') }}</th>
                                           <th>{{__('sentence.totalspent') }}</th>
                                           <th>{{__('sentence.lastorderdate') }}</th>
                                       </tr>
                                   </thead>
                                   <tbody>
                                    @php $i=1; @endphp
                                        @foreach($custList as $cl)  

                                        <tr>
                                          <td>#{{$i++}}</td>
                                          <td width="20%">{{$cl->user->display_name}}</td>
                                          <td>{{$cl->user->location->address}}</td>
                                          <td width="15%">{{!empty($currency)?$currency->symbol:''}} {{$cl->sum}}</td>
                                          <td width="20%">{{$cl->last_order_date}}</td>
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
<script src="{{asset('public/frontend/chef-dashboard/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
<script>$('#custList').DataTable({});</script>
@endsection 
