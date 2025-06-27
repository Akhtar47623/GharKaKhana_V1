@php
$permission = new \App\Model\Permissions();
@endphp
@extends('admin.layouts.master')
@section('content')
<div class="content-wrapper">
	<section class="content">
    <!-- Content Header (Page header) -->
    	<section class="content-header">
    	<h1>
    	
    		<small></small>
    	</h1>
    	<ol class="breadcrumb">
    		<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    		<li><a href="{{route('ticket')}}">Ticket</a></li>
    		<li class="active">OrderDetail</li>
    	</ol>
    	</section>
          
        <!-- Main content -->
     
     	<section class="invoice">
     		<div class="user-order-list-bottom">
     			<ul>
     				<li class="{{!empty($orderList->created_at_timezone)?'active':''}} ">
     					Pending Order <br>{{!empty($orderList->created_at_timezone)?$orderList->created_at_timezone:''}}
     				</li>
     				<li class="{{!empty($orderList->accepted_at_timezone)?'active':''}}">
     					Accept Order<br>{{!empty($orderList->accepted_at_timezone)?$orderList->accepted_at_timezone:''}}
     				</li>
     				<li class="{{!empty($orderList->ready_at_timezone)?'active':''}}">
     					Ready Order<br>{{!empty($orderList->ready_at_timezone)?$orderList->ready_at_timezone:''}}
     				</li>
     				<li class="{{!empty($orderList->delivery_at_timezone)?'active':''}}">
     					Out For Delivery<br>{{!empty($orderList->delivery_at_timezone)?$orderList->delivery_at_timezone:''}}
     				</li>
     				<li class="{{!empty($orderList->completed_at_timezone)?'active':''}}">
     					Completed Order<br>{{!empty($orderList->completed_at_timezone)?$orderList->completed_at_timezone:''}}
     				</li>
     			</ul>
     		</div>
     	</section>
        <section class="invoice">
          <!-- title row -->
         	<div class="row">
            	<div class="col-xs-12">
              		<h2 class="page-header">
                		<i class="fa fa-globe"></i> Order Detail
                		<small class="pull-right">Date: {{date('M d, Y',strtotime($orderList->created_at_timezone))}}</small>
              		</h2>
            	</div><!-- /.col -->
          	</div> 
          	<!-- info row -->
          	<div class="row invoice-info">
            	<div class="col-sm-4 invoice-col">
	              	From
	              	<address>
	                	<strong>{{$orderList->user->display_name}}</strong><br>
	                	{{$orderList->user->location->address}}<br>
	               
	                	Mo: {{$orderList->user->mobile}}<br>
	                	Email: {{$orderList->user->email}}
	              	</address>
            	</div><!-- /.col -->
            	<div class="col-sm-4 invoice-col">
              		To
	              	<address>
	                	<strong>{{$orderList->chef->display_name}}</strong><br>
	                	{{$orderList->chef->chefLocation->address}}<br>
	                	Mo: {{$orderList->chef->mobile}}<br>
	                	Email: {{$orderList->chef->email}}
	              	</address>
            	</div><!-- /.col -->
            	<div class="col-sm-4 invoice-col">
	            		<b>Order ID:</b> #{{$orderList->id}}<br>
            		<b>Order Date :</b> {{date('M d, Y',strtotime($orderList->created_at_timezone))}}<br>
            	</div><!-- /.col -->
          	</div><!-- /.row -->
    	</section>
    	<section class="invoice">
	        	<div class="row">
		          	<div class="col-md-4">
		          		<dl>
		          			<dt>Delivery / Pickup</dt>
		          			<dd>{{$orderList->pick_del_option==1?"Pickup":"Delivery"}}</dd><br>
		          			@if($orderList->pick_del_option==2)
		          			<dt>Delivery By</dt>
		          			<dd>{{$orderList->delivery_by==1?"Chef":"Delivery Company"}}</dd><br>
		          			@endif
		          			<dt>Payment Amount</dt>
		          			<dd><b>{{!empty($currency)?$currency->symbol:''}}{{$orderList->pay_total}}</b></dd><br>
		          		</dl>
		            </div>
		          	<div class="col-md-4">
		          		<dl>
			          		<dt>Payment Status</dt>
			          		<dd>{{$orderList->payment_method==1?"Not Paid(COD)":"Paid"}}</dd><br>
			          		@if($orderList->pick_del_option==2)
			          		<dt>Delivery Amount</dt>
			          		<dd>{{!empty($currency)?$currency->symbol:''}}{{$orderList->delivery_fee}}</dd><br>
			          		<dt>Tips Amount</dt>
			          		<dd>{{!empty($currency)?$currency->symbol:''}}{{$orderList->tip_fee}}
			          		</dd><br>
		          			@endif
		          		</dl>
		      	</div>
		    </div>
     	</section>
          <!-- Table row -->
        <section class="invoice">
	   		
		      	<div class="row">
		            <div class="col-xs-12 table-responsive">
		              	<table class="table table-striped">
			                <thead>
			                	<tr>
			                		<th>SrNo</th>
			                		<th></th><th>Item</th>
			                		<th>Qty</th>
			                		<th>Description</th>
			                		<th>Total</th>
			                	</tr>
			                </thead>
			                <tbody>
			                	@if(!empty($orderList->orderItems))
			                	@php $n=1; @endphp
			                	@foreach($orderList->orderItems as $i)

			                	<tr>
			                		<td>{{$n++}}</td>
			                		<td><img class="mr-3 img-fluid rounded" width="85" src="{{asset('public/frontend/images/menu')}}/{{$i->menu->photo}}" alt="DexignZone">  
			                		</td>
			                		<td>{{$i->menu->item_name}} <br>
			                			@if(!empty($orderList->orderItems))
			                			@foreach($i->orderItemOptions as $opt)
			                			<small>{{$opt->option}}</small>
			                			@endforeach
			                			@endif  
			                		</td>
			                		<td>{{$i->qty}}</td>
			                		<td>{{$i->notes}}</td>
			                		<td>{{!empty($currency)?$currency->symbol:''}} {{$i->total}}</td>
			                	</tr>
			                	@endforeach
			                	@endif
			                </tbody>
		            	</table>
		        	</div><!-- /.col -->
		   		</div><!-- /.row -->
   			
   		</section>	
   	</section>
</div><!-- /.content-wrapper -->
@endsection