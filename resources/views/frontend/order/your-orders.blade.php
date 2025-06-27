@extends('frontend.layouts.app')
@section('pageCss')
<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend/css/magnific-popup.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend/css/jquery.mCustomScrollbar.css')}}">
<!-- <link rel="stylesheet" type="text/css" href="{{ asset('public/frontend/css/chat.css')}}">
 --><style type="text/css">

</style>
@endsection
@section('content')

<section class="user-order-sec">
	<div class="container">
		<div class="user-order-wrap">
			<div class="user-order-heading">
				<h2>Your Orders</h2>
			</div>
			<div class="user-order-list-tab">

				<ul class="resp-tabs-list hor_1">
					<li>Orders</li>
					<li>Complete Orders</li>
					<li>Cancelled Orders</li>
				</ul>
				<div class="resp-tabs-container hor_1">
					<!-- Order Tab -->
					<div>
						<div class="user-order-list-wrap-main">
							@if(!empty($order))
							@foreach($order as $o)
							<div class="user-order-list-wrap">
								<div class="user-order-list">
									<div class="user-order-list-top">
										<div class="user-order-list-top-left">
											<div class="user-img" style="background-image: url({{asset('public/frontend/images/users/'.$o->chef->profile)}});"></div>
											<div class="order-chef-info">
												<span>Chef: {{$o->chef->first_name  .' '.$o->chef->last_name }}</span>
												<span>Order Id: #{{$o->id}}</span>
											</div>
										</div>
										<div class="user-order-list-top-right">
											<span><strong>Order Date:</strong> {{$o->delivery_date}} {{date('h:i A',strtotime($o->delivery_time))}}</span>
										</div>
									</div>
									<div class="user-order-list-middle">
										<div class="user-order-list-middle-left">
											<div class="order-heading">
												<h5>Items</h5>
												<h6>Qty</h6>
											</div>
											<div class="order-info-sec">
												<ul>
													@if(!empty($o->orderItems))
													@foreach($o->orderItems as $i)
													<li>
														<span>{{$i->menu->item_name}}</span>
														<span>{{$i->qty}}</span>
													</li>
													@endforeach
													@endif
												</ul>
											</div>
										</div>
										<div class="user-order-list-middle-right">
											<span><strong>Payment Status:</strong> {{$o->payment_method==1?"Not Paid(COD)":"Paid"}}</span>
											<span class="price">{{!empty($currency)?$currency->symbol:''}}{{$o->pay_total}}</strong></span>
										</div>
									</div>
									<div class="user-order-list-bottom">
										<ul>
											
											<li class="{{!empty($o->created_at_timezone)?'active':''}}">
												Pending Order <br>{{!empty($o->created_at_timezone)?$o->created_at_timezone:''}}
											</li>
											<li class="{{!empty($o->accepted_at_timezone)?'active':''}}">
												Accept Order<br>{{!empty($o->accepted_at_timezone)?$o->accepted_at_timezone:''}}
											</li>
											<li class="{{!empty($o->ready_at_timezone)?'active':''}}">
												Ready Order<br>{{!empty($o->ready_at_timezone)?$o->ready_at_timezone:''}}
											</li>
											<li class="{{!empty($o->delivery_at_timezone)?'active':''}}">
												Out For Delivery<br>{{!empty($o->delivery_at_timezone)?$o->delivery_at_timezone:''}}
											</li>
											<li class="{{!empty($o->completed_at_timezone)?'active':''}}">
												Completed Order<br>{{!empty($o->completed_at_timezone)?$o->completed_at_timezone:''}}
											</li>
										</ul>
									</div>
								</div>
								<div class="user-order-list-right">
									<a href="#order-details-popup{{$o->id}}" title="" class="popup-with-form">Order Details</a>
									<a href="#" title="">Request Cancellation</a>
									<a href="#" title="">Update Delivery Instruction</a>
									@if($o->chefBusiness->messaging=='1')
								
									<a href="javascript:;" data-id="{{$o->chef_id}}" data-orderid="{{$o->id}}" title="" class="order-msg">Message To Chef @if($o->orderMessages->count() > 0)<span>{{$o->orderMessages->count()}} </span>@endif</a>
									@else
									<a href="javascript:;" data-id="0" data-orderid="{{$o->id}}" title="" class="order-msg">Customer Support @if($o->orderMessages->count() > 0)<span>{{ $o->orderMessages->count() }}</span>@endif</a>
									@endif
								</div>
								
								<div id="order-details-popup{{$o->id}}" class="white-popup-block mfp-hide">
									<div class="pending-order-result">
										<input type="hidden" name="timezone" id="timezone">
												
											<div class="pending-order-box" data-source="{{$o->id}}" style="">
												
												<div class="pending-order-box-wrap">
													<div class="pending-order-box-top">
														<div class="order-id-sec">
															<small>Order</small>
															<span>#{{$o->id}}</span>
														</div>
														
														<div class="status-sec">
															<small>Order Date</small>
															<span>{{$o->delivery_date}}</span>
															<small>Delivery Time</small>
															<span>{{date('h:i A',strtotime($o->delivery_time))}}</span>
														</div>
													</div>
												</div>
												<div class="pending-order-box-wrap">
													<div class="pending-order-box-info">
														<div class="pending-order-box-left">
															<div class="pending-order-box-content">
																<small>Delivery / Pickup</small>
																<span>{{$o->pick_del_option==1?"Pickup":"Delivery"}}</span>
																@if($o->pick_del_option==2)
																<small>Delivery By</small>
																<span>{{$o->delivery_by==1?"Chef":"Delivery Company"}}</span>
																@endif
																<small>Customer Name</small>
																<span><strong>{{$o->user->first_name  .' '.$o->user->last_name }}</strong></span>
																<small>Address</small>
																<span>{{$o->user->location->address}}</span>
															</div>
														</div>
														<div class="pending-order-box-right">
															<div class="pending-order-box-content">
																<small>Payment Status</small>
																<span>{{$o->payment_method==1?"Not Paid(COD)":"Paid"}}</span>
																<small>Payment Amount</small>
																<span>{{!empty($currency)?$currency->symbol:''}}{{$o->pay_total}}</span>
																
																@if($o->pick_del_option==2)
																<small>Delivery Amount</small>
																<span>{{!empty($currency)?$currency->symbol:''}}{{$o->delivery_fee}}</span>
																									
																<small>Tips Amount</small>
																<span>{{!empty($currency)?$currency->symbol:''}}{{$o->tip_fee}}</span>
																@endif	
															</div>
														</div>
													</div>
												</div>
												<div class="pending-order-box-wrap">
													<div class="order-details-sec">
														<h5>Order Details</h5>
														<div class="pending-order-box-table">
															<table>
																<thead>
																	<tr>
																		<th>Sr. No</th>
																		<th>Item</th>
																		<th>Qty</th>
																		<th>Special Instruction</th>
																	</tr>
																</thead>
																<tbody>
																	@if(!empty($o->orderItems))
																	@foreach($o->orderItems as $i)
																	<tr>
																		<td>1</td>
																		<td>
																			<div class="item-name">
																				<span>{{$i->menu->item_name}}</span>
																				<em>
																					@if(!empty($o->orderItems))
																					@foreach($i->orderItemOptions as $opt)
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
							@endforeach	
							@endif

						</div>
					</div>
					<!-- End Order Tab -->
					<!-- Delivered Order -->
					<div>
						<div class="user-order-search">
							
								<input type="text" name="txtSearch" id="txtSearch" placeholder="Search...">
								<button type="button" id="btnSearch"><img src="{{asset('public/frontend/images/search-icon.png')}}" alt=""></button>
							
						</div>
						<div class="user-order-list-wrap-main" id="completed-order">
							@if(!empty($completedOrder))
							@foreach($completedOrder as $c)
							<div class="user-order-list-wrap">
								<div class="user-order-list">
									<div class="user-order-list-top">
										<div class="user-order-list-top-left">
											<div class="user-img" style="background-image: url({{asset('public/frontend/images/daniel-john.png')}});"></div>
											<div class="order-chef-info">
												<span>Chef: {{$c->chef->first_name  .' '.$c->chef->last_name }}</span>
												<span>Order Id: #{{$c->id}}</span>
											</div>
										</div>
										<div class="user-order-list-top-right">
											<span><strong>Order Placed Date:</strong>  {{$c->created_at_timezone}}</span>
										</div>
									</div>
									<div class="user-order-list-middle">
										<div class="user-order-list-middle-left">
											<div class="order-heading">
												<h5>Items</h5>
												<h6>Qty</h6>
											</div>
											<div class="order-info-sec">
												<ul>
													@if(!empty($c->orderItems))
													@foreach($c->orderItems as $i)
													<li>
														<span>{{$i->menu->item_name}}</span>
														<span>{{$i->qty}}</span>
													</li>
													@endforeach
													@endif
												</ul>
											</div>
										</div>
										<div class="user-order-list-middle-right">
											<span><strong>Payment Status:</strong> {{$c->payment_method==1?"Not Paid(COD)":"Paid"}}</span>
											<span class="price">{{!empty($currency)?$currency->symbol:''}}{{$c->pay_total}}</strong></span>
										</div>
									</div>
									<div class="user-order-list-bottom">
										<span>Order Date: 21-03-2021</span>
										<span class="com-btn">Delivered</span>
									</div>
								</div>
								<div class="user-order-list-right">
									<a href="#order-details-popup{{$c->id}}" title="" class="popup-with-form">Order Details</a>
									@if($c->chefBusiness->messaging=='1')
									<a href="#chef-chat" data-id="{{$c->chef_id}}" data-orderid="{{$c->id}}" title="" class="order-msg">Message To Chef<span>{{!empty($c->orderMessages)?$c->orderMessages->count():0}}</span></a>
									@else
									<a href="#chef-chat" data-id="0" data-orderid="{{$c->id}}" title="" class="order-msg">Customer Support<span>{{!empty($c->orderMessages)?$c->orderMessages->count():0}}</span></a>
									@endif

									@if($c->invoice && $c->invoice->status==3)
									<a href="{{asset('public/backend/images/invoice/'.$c->invoice->invoice)}}" title="" class="order-msg"><i class="fas fa-file-pdf" aria-hidden="true"></i> Print Invoice</a>
									@endif
									
								</div>
								<div id="order-details-popup{{$c->id}}" class="white-popup-block mfp-hide">
									<div class="pending-order-result">
										<input type="hidden" name="timezone" id="timezone">
												
											<div class="pending-order-box" data-source="{{$c->id}}" style="">
												
												<div class="pending-order-box-wrap">
													<div class="pending-order-box-top">
														<div class="order-id-sec">
															<small>Order</small>
															<span>#{{$c->id}}</span>
														</div>
														
														<div class="status-sec">
															<small>Order Date</small>
															<span>{{$c->delivery_date}}</span>
															<small>Delivery Time</small>
															<span>{{date('h:i A',strtotime($c->delivery_time))}}</span>
														</div>
													</div>
												</div>
												<div class="pending-order-box-wrap">
													<div class="pending-order-box-info">
														<div class="pending-order-box-left">
															<div class="pending-order-box-content">
																<small>Delivery / Pickup</small>
																<span>{{$c->pick_del_option==1?"Pickup":"Delivery"}}</span>
																@if($c->pick_del_option==2)
																<small>Delivery By</small>
																<span>{{$c->delivery_by==1?"Chef":"Delivery Company"}}</span>
																@endif
																<small>Customer Name</small>
																<span><strong>{{$c->user->first_name  .' '.$c->user->last_name }}</strong></span>
																<small>Address</small>
																<span>{{$c->user->location->address}}</span>
															</div>
														</div>
														<div class="pending-order-box-right">
															<div class="pending-order-box-content">
																<small>Payment Status</small>
																<span>{{$c->payment_method==1?"Not Paid(COD)":"Paid"}}</span>
																<small>Payment Amount</small>
																<span>{{!empty($currency)?$currency->symbol:''}}{{$c->pay_total}}</span>
																
																@if($c->pick_del_option==2)
																<small>Delivery Amount</small>
																<span>{{!empty($currency)?$currency->symbol:''}}{{$c->delivery_fee}}</span>
																									
																<small>Tips Amount</small>
																<span>{{!empty($currency)?$currency->symbol:''}}{{$c->tip_fee}}</span>
																@endif	
															</div>
														</div>
													</div>
												</div>
												<div class="pending-order-box-wrap">
													<div class="order-details-sec">
														<h5>Order Details</h5>
														<div class="pending-order-box-table">
															<table>
																<thead>
																	<tr>
																		<th>Sr. No</th>
																		<th>Item</th>
																		<th>Qty</th>
																		<th>Special Instruction</th>
																	</tr>
																</thead>
																<tbody>
																	@if(!empty($c->orderItems))
																	@foreach($c->orderItems as $i)
																	<tr>
																		<td>1</td>
																		<td>
																			<div class="item-name">
																				<span>{{$i->menu->item_name}}</span>
																				<em>
																					@if(!empty($c->orderItems))
																					@foreach($i->orderItemOptions as $opt)
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
							@endforeach	
							@endif				
						</div>
					</div>
					<!-- End Delivered Order -->
					<!-- Cancel Order -->
					<div>
						<div class="user-order-list-wrap-main" id="completed-order">
							@if(!empty($cancelOrder))
							@foreach($cancelOrder as $c)
							<div class="user-order-list-wrap">
								<div class="user-order-list">
									<div class="user-order-list-top">
										<div class="user-order-list-top-left">
											<div class="user-img" style="background-image: url({{asset('public/frontend/images/daniel-john.png')}});"></div>
											<div class="order-chef-info">
												<span>Chef: {{$c->chef->first_name  .' '.$c->chef->last_name }}</span>
												<span>Order Id: #{{$c->id}}</span>
											</div>
										</div>
										<div class="user-order-list-top-right">
											<span><strong>Order Placed Date:</strong>  {{$c->created_at_timezone}}</span>
										</div>
									</div>
									<div class="user-order-list-middle">
										<div class="user-order-list-middle-left">
											<div class="order-heading">
												<h5>Items</h5>
												<h6>Qty</h6>
											</div>
											<div class="order-info-sec">
												<ul>
													@if(!empty($c->orderItems))
													@foreach($c->orderItems as $i)
													<li>
														<span>{{$i->menu->item_name}}</span>
														<span>{{$i->qty}}</span>
													</li>
													@endforeach
													@endif
												</ul>
											</div>
										</div>
										<div class="user-order-list-middle-right">
											<span><strong>Payment Status:</strong> {{$c->payment_method==1?"Not Paid(COD)":"Paid"}}</span>
											<span class="price">{{!empty($currency)?$currency->symbol:''}}{{$c->pay_total}}</strong></span>
										</div>
									</div>
									<div class="user-order-list-bottom">
										<span>Order Date: 21-03-2021</span>
										<span>Cancel Date: 21-03-2021</span>
										<span class="com-btn">Delivered</span>
									</div>
								</div>
								<div class="user-order-list-right">
									<a href="#order-details-popup{{$c->id}}" title="" class="popup-with-form">Order Details</a>
									
									@if($c->chefBusiness->messaging=='1')
									<a href="javascript:;" data-id="{{$c->chef_id}}" data-orderid="{{$c->id}}" title="" class="order-msg">Message To Chef <span> {{!empty($c->orderMessages)?$c->orderMessages->count():0}}</span></a>
									@else
									<a href="javascript:;" data-id="0" data-orderid="{{$c->id}}" title="" class="order-msg">Customer Support<span> {{!empty($c->orderMessages)?$c->orderMessages->count():0}}</span></a>
									@endif
								</div>
								<div id="order-details-popup{{$c->id}}" class="white-popup-block mfp-hide">
									<div class="pending-order-result">
										<input type="hidden" name="timezone" id="timezone">
												
											<div class="pending-order-box" data-source="{{$c->id}}" style="">
												
												<div class="pending-order-box-wrap">
													<div class="pending-order-box-top">
														<div class="order-id-sec">
															<small>Order</small>
															<span>#{{$c->id}}</span>
														</div>
														<div class="status-sec">
															<small>Order Date</small>
															<span>{{$c->delivery_date}}</span>
															<small>Delivery Time</small>
															<span>{{date('h:i A',strtotime($c->delivery_time))}}</span>
														</div>
													</div>
												</div>
												<div class="pending-order-box-wrap">
													<div class="pending-order-box-info">
														<div class="pending-order-box-left">
															<div class="pending-order-box-content">
																<small>Delivery / Pickup</small>
																<span>{{$c->pick_del_option==1?"Pickup":"Delivery"}}</span>
																@if($c->pick_del_option==2)
																<small>Delivery By</small>
																<span>{{$c->delivery_by==1?"Chef":"Delivery Company"}}</span>
																@endif
																<small>Customer Name</small>
																<span><strong>{{$c->user->first_name  .' '.$c->user->last_name }}</strong></span>
																<small>Address</small>
																<span>{{$c->user->location->address}}</span>
															</div>
														</div>
														<div class="pending-order-box-right">
															<div class="pending-order-box-content">
																<small>Payment Status</small>
																<span>{{$c->payment_method==1?"Not Paid(COD)":"Paid"}}</span>
																<small>Payment Amount</small>
																<span>{{!empty($currency)?$currency->symbol:''}}{{$c->pay_total}}</span>
																
																@if($c->pick_del_option==2)
																<small>Delivery Amount</small>
																<span>{{!empty($currency)?$currency->symbol:''}}{{$c->delivery_fee}}</span>
																									
																<small>Tips Amount</small>
																<span>{{!empty($currency)?$currency->symbol:''}}{{$c->tip_fee}}</span>
																@endif	
															</div>
														</div>
													</div>
												</div>
												<div class="pending-order-box-wrap">
													<div class="order-details-sec">
														<h5>Order Details</h5>
														<div class="pending-order-box-table">
															<table>
																<thead>
																	<tr>
																		<th>Sr. No</th>
																		<th>Item</th>
																		<th>Qty</th>
																		<th>Special Instruction</th>
																	</tr>
																</thead>
																<tbody>
																	@if(!empty($c->orderItems))
																	@foreach($c->orderItems as $i)
																	<tr>
																		<td>1</td>
																		<td>
																			<div class="item-name">
																				<span>{{$i->menu->item_name}}</span>
																				<em>
																					@if(!empty($c->orderItems))
																					@foreach($i->orderItemOptions as $opt)
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
							@endforeach	
							@endif			
						</div>
					</div>
					<!-- End Cancel Order -->
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Chat New -->
	<section class="avenue-messenger" id="chef-chat">
  		<div class="menu">
   			<div class="items">
   				<span class="">
     				<a href="#" title="Minimize">—</a><br>
     				<a href="#" id="close" title="End Chat">✕</a>
     			</span>
     		</div>
    		<div class="button">...</div>
  		</div>
  		<div class="agent-face">
    		<div class="half">
     			<img class="agent circle"  alt="Jesse Tino">
     		</div>
  		</div>
		<div class="chat">
			<div class="chat-title">
				<h2>CHEF</h2>
				<h1></h1>
				
			</div>
				
			<div class="messages" >
				@if($ticketCategory)
				<ul id="msg">
					
					@foreach($ticketCategory as $c)
					<li class="" value="{{$c->id}}">{{$c->name}}</li>
					@endforeach
    			</ul>
    			@endif
				<div class="messages-content" id="order-msg">
								
										
				</div>
			</div>
			<div class="message-box">
				<input type="hidden" name="order_id" id="order_id">
				<textarea type="text" class="message-input" id="mess" placeholder="Type message..."></textarea>
				<button type="submit" id="msgSubmit" class="message-submit">Send</button>
			</div>
		</div> 
	</section>
	
<!-- End Chat New -->
@endsection
@section('pagescript')
<!-- <script src="{{asset('public/backend/common/jquery.validate.js')}}"></script>
<script type="text/javascript" src="{{ asset('public/frontend/js/slick.min.js')}}"></script> -->
<script type="text/javascript" src="{{ asset('public/frontend/js/pages/cust-orders.js')}}"></script>
<script type="text/javascript" src="{{ asset('public/frontend/js/jquery.magnific-popup.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('public/frontend/js/easy-responsive-tabs.js')}}"></script>
<!-- <script type="text/javascript" src="{{ asset('public/frontend/js/jquery.mCustomScrollbar.min.js')}}"></script> -->

<script id="rendered-js">
	var msgg = $('#order-msg'),
	d,h,m,
	i = 0;

	$(window).load(function () 
	{
		
		msgg.mCustomScrollbar();	  	
	});
	
	function updateScrollbar1() 
	{
		msgg.mCustomScrollbar("update");
		msgg.mCustomScrollbar("scrollTo","bottom");
		
	}

	function setDate() 
	{
	  	d = new Date();
	  	if (m != d.getMinutes()) 
	  	{
	    	m = d.getMinutes();
	    	$('<div class="timestamp">' + d.getHours() + ':' + m + '</div>').appendTo($('.message:last'));
	    	
	  	}
	}

	function insertMessage1(msg) 
	{		
	  	$('<div class="message message-personal">' + msg + '</div>').appendTo($('.mCSB_container')).addClass('new');
	  	setDate();
	  	$('#mess').val(null);
	  	updateScrollbar1();	  	
	}
	
	$('#msgSubmit').click(function () {

		msg = $('#mess').val();
		if ($.trim(msg) == '') {
	    	return false;
	  	}
	   	order_id=$('input[name="order_id"]').val();
        $.ajax({
            type:"POST",
            url:BASEURL+"add-order-message",
            data:{message:msg,order_id:order_id},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success:function(res){
                if(res){
               		insertMessage1(msg);
                }else{
              
                }
            }
        });
	  	
		
	});

	$(window).on('keydown', function (e) {
	  	if (e.which == 13) {
	  		msg = $('#mess').val();
			if ($.trim(msg) == '') {
		    	return false;
		  	}
	  		order_id=$('input[name="order_id"]').val();
	        $.ajax({
	            type:"POST",
	            url:BASEURL+"add-order-message",
	            data:{message:msg,order_id:order_id},
	            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	            success:function(res){
	                if(res){
	               		insertMessage1(msg);
	                }else{
	              
	                }
	            }
	        });
	  	}
	});
	$("#msg").on('click','li',function (){
		$('#msg').hide();
   		$('.message-box').show();
    	msg=$(this).text();
    	catId=$(this).val();
   		order_id=$('#order_id').val();
   		$.ajax({
            type:"POST",
            url:BASEURL+"responder-message",
            data:{message:msg,order_id:order_id,cat_id:catId},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success:function(res){
                if(res){
               			insertMessage1(msg);
   						
                }else{
              
                }
            }
        });
	});
	$('.order-msg').on('click',function(){
		
		$('.items span').removeClass('active');
		$('.button').removeClass('active');
		 
		order_id=$(this).data("orderid");
		$('input[name="order_id"]').val(order_id);
        chef_id=$(this).data("id");

        $.ajax({
            type:"POST",
            url:BASEURL+"get-order-messages",
            data:{order_id:order_id,chef_id:chef_id},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success:function(res){
                if(res['output']){

                    $('.mCSB_container').empty();
                    $('.chat-title h1').text(res['display_name']);
                    $(".half img").attr("src",res['profile']);
                    $(".mCSB_container").append(res['output']);
                    $(".avenue-messenger").show();
                    $("#msg").hide();
                    $('.message-box').show();
                    updateScrollbar1();
                    
                }else{
                	$(".half img").attr("src",res['profile']);  
                    $(".avenue-messenger").show();
                    $('.mCSB_container').empty();
                    $("#msg").show();
                    $(".message-box").hide();
                  
                }
            }
        });
    });
	$('.button').click(function () {
	  	$('.menu .items span').toggleClass('active');
	  	$('.menu .button').toggleClass('active');
	});

	
	$('#close').click(function () {
		$('.avenue-messenger').hide();
		location.reload();
	
	});

</script>
@endsection

