@extends('frontend.chef-dashboard.layouts.app')
@section('pageCss')
<link href="{{asset('public/frontend/chef-dashboard/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
@endsection
@section('content')
 	<div class="content-body">
   	 	<div class="container-fluid">
               @section('pageHeading')
               <h2>{{__('sentence.compo') }}</h2>
               @endsection     
  
        	<!-- row -->
        	<div class="row">
            	<div class="col-12">
                	<div class="card">
                    	<div class="card-header">
                           <div class="card-title">
                            <h4>{{__('sentence.completeol') }}</h4>
                           </div>
                    	</div>
                    	<div class="card-body">
                        	<div class="table-responsive">
                        		<table id="completedOrderList" class="display" width="100%">
                        			<thead>
                        			<tr>
                                <th>SNo.</th>
                                <th>{{__('sentence.order') }}</th>
                                <th>{{__('sentence.date') }}</th>
                                <th>{{__('sentence.name') }}</th>
                                <th>{{__('sentence.pickup') }}</th>
                                <th>{{__('sentence.earned') }}</th>
                                <th>{{__('sentence.status') }}</th>
                              </tr>
                        			</thead>
                        			<tbody>
              										@if(!empty($order))
              										<?php $i=1 ?>
              						                @foreach ($order as $value)                			
              										<tr>
              											<td>{{$i++}}</td>
              											<td>{{$value->id}}</td>
              											<td>{{$value->delivery_date}} {{date('h:i A',strtotime($value->delivery_time))}}</td>
              											<td>{{$value->user->display_name}}</td>
              											<td>{{$value->pick_del_option==1?"Pick-up":"Delivery"}}</td>
              											<td style="text-align:right">
              												@if($value->pick_del_option=="2")
              													@if($value->delivery_by=="1")
              														{{!empty($currency)?$currency->symbol:''}} 
              						                        		{{$value->chef_commission_fee + $value->delivery_commission_fee + $value->tip_fee}}				
              													@else
              														{{!empty($currency)?$currency->symbol:''}}
              														{{$value->chef_commission_fee}}
              													@endif
              												@else
              													{{!empty($currency)?$currency->symbol:''}}
              													{{$value->chef_commission_fee}}							
              												@endif
              											</td>
              											<td style="text-align:center;"><span class="badge badge-rounded badge-success">Completed</span></td>
              										</tr>
              										@endforeach
              										@endif					
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
<!--<script>$('#completedOrderList').DataTable({});</script>-->
@endsection

