@extends('frontend.chef-dashboard.layouts.app')
@section('pageCss')
<link href="{{asset('public/frontend/chef-dashboard/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend/css/magnific-popup.css')}}">
@endsection
@section('content')
 	<div class="content-body">
   	 	<div class="container-fluid">
               @section('pageHeading')
               <h2>{{__('sentence.report') }}</h2>
               @endsection
  
        	<!-- row -->
        	<div class="row">
            	<div class="col-12">
                	<div class="card">
                    	<div class="card-header">
                             <div class="card-title">
                                    <h4>{{__('sentence.salesr') }}</h4>
                                </div>
                            	<span data-href="export" id="export" class="btn btn-success btn-sm" onclick="exportTasks(event.target);"><i class="fa fa-download" aria-hidden="true"></i> CSV</span>
                    	</div>
                    	<div class="card-body">
                        	<div class="table-responsive">
                        		<table id="example" class="display dataTable" style="min-width: 100%" role="grid" aria-describedby="example_info">
                        			<thead>
                        			<tr>
                                        <th>{{__('sentence.viewdetail') }}</th>
                                        <th>{{__('sentence.order') }} #</th>
                                        <th>{{__('sentence.completeddate') }}</th>
                                        <th>{{__('sentence.custname') }}</th>
                                        <th>{{__('sentence.zipcode') }}</th>
                                        <th>{{__('sentence.pickup') }}</th>
                                        <th>{{__('sentence.subtotal') }}</th>
                                        <th>{{__('sentence.discount') }}</th>
                                        <th>{{__('sentence.refund') }}</th>
                                        <th>{{__('sentence.servicefee') }}</th>
                                        <th>{{__('sentence.earning') }}</th>
                                        <th>{{__('sentence.delfee') }}</th>
                                        <th>{{__('sentence.tip') }}</th>
                                        <th>{{__('sentence.payout') }}</th>
                                        <th>{{__('sentence.status') }}</th>
                                        <th>{{__('sentence.tax') }}</th>
                                        <th>{{__('sentence.payrolls') }}</th>
                                        <th>{{__('sentence.payrolld') }}</th>
                                    </tr>
                        			</thead>
                        			<tbody>
                        			@if(!empty($orderList))
                        			@foreach ($orderList as $ol)
                        			<tr>
                                        <td><div class="product-action">
                                            <a href="#order-details-popup{{$ol->id}}" title="" class="popup-with-form"><i class="fa fa-eye" aria-hidden="true"></i></a></div>
                                        </td>
                                        <td>{{$ol->id}}</td>
                                        <td>{{date('F d, Y',strtotime($ol->completed_at))}}</td>
                                        <td>{{$ol->user->first_name  .' '.$ol->user->last_name }}</td>
                                        <td>{{$ol->user->location->zipcode}}</td>
                                        <td>{{$ol->pick_del_option==1?"Pickup":"Delivery"}}</td>
                                        <td>{{!empty($currency)?$currency->symbol:''}} {{$ol->sub_total}}</td>
                                        <td>{{$ol->chef_discount}}</td>
                                        <td>0</td>
                                        <td>{{!empty($currency)?$currency->symbol:''}} {{$ol->service_fee}}</td>
                                        <td>{{!empty($currency)?$currency->symbol:''}} {{$ol->sub_total - $ol->chef_discount-$ol->service_fee}}</td>
                                        <td>{{!empty($currency)?$currency->symbol:''}} {{$ol->delivery_fee}} </td>
                                        <td>{{!empty($currency)?$currency->symbol:''}} {{$ol->tip_fee}} </td>
                                        <td>{{!empty($currency)?$currency->symbol:''}}{{$ol->tip_fee + $ol->sub_total - $ol->chef_discount - $ol->service_fee }}</td>
                                        <td>Completed</td>
                                        <td>{{!empty($currency)?$currency->symbol:''}} {{$ol->tax_fee}}</td>
                                        <td>pending</td>
                                        <td>23/03/2021</td>
                                    </tr>
                        			</tbody>
                        		@endforeach
                        		@endif	

                        		</table>
                        	</div>
                    	</div>
                	</div>
            	</div>
         	</div>
    	</div>
	</div>
		@if(!empty($orderList))
		    @foreach ($orderList as $ol)
		    <div id="order-details-popup{{$ol->id}}" class="white-popup-block mfp-hide">
		    	<div class="pending-order-result">
		    		<div class="pending-order-box" data-source="{{$ol->id}}" style="">
		    			<div class="pending-order-box-wrap">
		    				<div class="order-details-sec">
		    					<h5>Order Details</h5>
		    					<div class="pending-order-box-table">
		    						<table id="reportList" class="display" width="100%">
		    							<thead>
		    								<tr>
		    									<th>Sr. No</th>
		    									<th>Item</th>
		    									<th>Qty</th>
		    									<th>Special Instruction</th>
		    								</tr>
		    							</thead>
		    							<tbody>
		    								@if(!empty($ol->orderItems))
		    								@php $n=1; @endphp
		    								@foreach($ol->orderItems as $i)
		    								<tr>
		    									<td>{{$n}}</td>
		    									<td>
		    										<div class="item-name">
		    											<span>{{$i->menu->item_name}}</span>
		    											<em>
		    												@if(!empty($ol->orderItems))
		    												@foreach($ol->orderItemOptions as $opt)
		    												{{$opt->option}}<br>
		    												@endforeach
		    												@endif
		    											</em>
		    										</div>
		    									</td>
		    									<td>
		    										<div class="qty-sec">
		    											<span>{{$i->qty}}</span>
		    										</div>
		    									</td>
		    									<td>
		    										<div class="instruction-text">
		    											<span>{{$i->notes}}</span>
		    										</div>
		    									</td>
		    								</tr>
		    								@php $n++; @endphp
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
		@endforeach
		@endif	
@endsection
@section('pageScript')
<script src="{{asset('public/frontend/chef-dashboard/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
<script>$('#reportList').DataTable({});</script>
<script type="text/javascript" src="{{ asset('public/frontend/js/pages/report.js')}}"></script>
<script type="text/javascript" src="{{ asset('public/frontend/js/jquery.magnific-popup.min.js')}}"></script>
@endsection 
