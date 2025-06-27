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
    		<li><a href="{{route('mexico-invoice.index')}}">Invoice</a></li>
    		<li class="active">Invoice Details</li>
    	</ol>
    	</section>
          
        <!-- Main content -->
     	<section class="invoice">
          <!-- title row -->
         	<div class="row">
            	<div class="col-xs-12">
              		<h2 class="page-header">
                		<i class="fa fa-globe"></i> Invoice Detail
                		<small class="pull-right">Date: {{date('M d, Y',strtotime($orderData->created_at_timezone))}}</small>

              		</h2>
              		
            	</div><!-- /.col -->
          	</div> 
          	<!-- info row -->
          	<div class="row invoice-info">
            	<div class="col-sm-4 invoice-col">
	              	<h4>Customer</h4>
	              	<address>
	                	<strong>Name</strong><br>{{$invoiceData->name}}<br><br>
	                	<strong>Address</strong><br>{{$invoiceData->address}}<br><br>
	               
	                	<strong>Mobile</strong><br>{{$invoiceData->mobile}}<br><br>
	                	<strong>Email</strong><br>{{$invoiceData->email}}<br><br>
	                	<strong>Municipality</strong><br>{{$invoiceData->city}}<br><br>
	                	<strong>State</strong><br>{{$invoiceData->state}}<br><br>
	                	<strong>Country</strong><br>{{$invoiceData->country}}<br><br>
	              	</address>
            	</div><!-- /.col -->
            	<div class="col-sm-4 invoice-col">
              		<h4>Chef</h4>
	              	<address>
	                	<strong>Name</strong><br>{{$orderData->chef->display_name}}<br><br>
	                	<strong>Address</strong><br>{{$orderData->chef->chefLocation->address}}<br><br>
	                	<strong>Mobile</strong><br> {{$orderData->chef->mobile}}<br><br>
	                	<strong>Email</strong><br>{{$orderData->chef->email}}<br><br>
	                	<strong>Municipality</strong><br>{{$orderData->chef->chefLocation->city->name}}<br><br>
	                	<strong>State</strong><br>{{$orderData->chef->chefLocation->state->name}}<br><br>
	              	</address>
            	</div><!-- /.col -->
            	<div class="col-sm-4 invoice-col">
	            		<b>Order ID:</b> #{{$orderData->id}}<br>
            		<b>Order Date :</b> {{date('M d, Y',strtotime($orderData->created_at_timezone))}}<br>
            	</div><!-- /.col -->
          	</div><!-- /.row -->
    	</section>
    	<!-- Table row -->
        <section class="invoice">
	   		
		      	<div class="row">
		            <div class="col-xs-12 table-responsive">
		              	<table class="table table-striped">
			                <thead>
			                	<tr>
			                		<th>Qty</th>
			                		<th>Item</th>			                		
			                		<th>Amt Per Item</th>
			                		<th>Item Total</th>
			                	</tr>
			                </thead>
			                <tbody>
			                	@if(!empty($orderData->orderItems))
			                	@php $taxAmt=0; $subTotal=0; @endphp
			                	@foreach($orderData->orderItems as $i)

			                	<tr>
			                		<td>{{$i->qty}}</td>
			                		<td>{{$i->menu->item_name}} <br>
			                			@if(!empty($orderData->orderItems))
			                			@foreach($i->orderItemOptions as $opt)
			                			<small>{{$opt->option}}</small>
			                			@endforeach
			                			@endif  
			                		</td>
			                		@php 
			                		$taxAmt = $taxAmt+(($i->total*$taxes->tax)/(100+$taxes->tax));
			                		
			                		$amtPerItem = ($i->total-(($i->total*$taxes->tax)/(100+$taxes->tax)))/$i->qty;
			                		$itemTotal = $i->total-(($i->total*$taxes->tax)/(100+$taxes->tax));
			                		$subTotal = $subTotal+$itemTotal;
			                		$Total = $subTotal-$orderData->chef_discount-$orderData->house_discount-$orderData->makem_discount;
			                		$delTaxAmt = ($orderData->delivery_fee*$taxes->tax)/(100+$taxes->tax);
			                		$delAmt = $orderData->delivery_fee - $delTaxAmt;
			                		$tipTaxAmt = ($orderData->tip_fee*$taxes->tax)/(100+$taxes->tax);
			                		$tipAmt = $orderData->tip_fee - $tipTaxAmt;
			                		$taxAmt = $taxAmt+$delTaxAmt+$tipTaxAmt;
			                		@endphp

			                		<td>{{!empty($currency)?$currency->symbol:''}} {{$amtPerItem}}</td>
			                		<td>{{!empty($currency)?$currency->symbol:''}} {{$itemTotal}}</td>
			                	</tr>
			                	@endforeach
			                	<tr>
			                		<td></td>
			                		<td></td>
			                		<td align="right"><b>SubTotal:</b> </td>
			                		<td>{{!empty($currency)?$currency->symbol:''}} {{$subTotal}}</td>
			                	</tr>
			                	@if($orderData->chef_discount!=0 ||$orderData->house_discount!=0 || $orderData->makem_discount!=0)
			                	<tr>
			                		<td></td>
			                		<td></td>
			                		<td align="right"><b>Discount:</b> </td>
			                		<td>{{!empty($currency)?$currency->symbol:''}} 
			                			{{$orderData->chef_discount!=0?$orderData->chef_discount:''}}
			                			{{$orderData->house_discount!=0?$orderData->house_discount:''}}
			                			{{$orderData->makem_discount!=0?$orderData->makem_discount:''}}</td>
			                	</tr>
			                	<tr>
			                		<td></td>
			                		<td></td>
			                		<td align="right"><b>Total:</b> </td>
			                		<td>{{!empty($currency)?$currency->symbol:''}} {{$Total}}</td>
			                	</tr>
			                	@endif
			                	@if($orderData->delivery_fee!=0)
			                	<tr>
			                		<td></td>
			                		<td></td>
			                		<td align="right"><b>Delivery:</b> </td>
			                		<td>{{!empty($currency)?$currency->symbol:''}} {{$delAmt}}</td>
			                	</tr>
			                	@endif
			                	@if($orderData->tip_fee!=0)
			                	<tr>
			                		<td></td>
			                		<td></td>
			                		<td align="right"><b>Tip:</b> </td>
			                		<td>{{!empty($currency)?$currency->symbol:''}} {{$tipAmt}}</td>
			                	</tr>
			                	@endif
			                	<tr>
			                		<td></td>
			                		<td></td>
			                		<td align="right"><b>Tax:</b> </td>
			                		<td>{{!empty($currency)?$currency->symbol:''}} {{$taxAmt}}</td>
			                	</tr>
			                	<tr>
			                		<td></td>
			                		<td></td>
			                		<td align="right"><b>Pay Total:</b> </td>
			                		<td>{{!empty($currency)?$currency->symbol:''}} {{$Total+$taxAmt+$delAmt+$tipAmt}}</td>
			                	</tr>               	
			                	@endif
			                </tbody>
		            	</table>
		        	</div><!-- /.col -->
		   		</div><!-- /.row -->
   				
   		</section>
   			
   	</section>
</div><!-- /.content-wrapper -->
@endsection