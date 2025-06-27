

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<title>Home Chef</title>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<meta name="format-detection" content="telephone=no">
	<meta name="keywords" content="">
	<meta name="description" content="">	
	<style>
    .error-help-block{color:red;}
    .pending-order-sec {
    padding: 30px 10px 50px 10px;

}
    .pending-order-right {
    width: 100%;
    padding: 0 0 0 30px;
}
    .pending-order-box-wrap {
        width: 100%;
        box-shadow: 0px 0px 10px rgb(33 148 172 / 20%);
        border-radius: 10px;
        padding: 15px;
        margin: 0 0 50px 0;
        
        flex-wrap: wrap;
        
    }

    .pending-order-box-top {
        
        flex-wrap: wrap;
        justify-content: space-between;
        width: 100%;
    }
    .order-id-sec small {
        display: block;
        font-size: 14px;
        font-weight: 600;
        letter-spacing: 0.4px;
        color: #000000;
        margin: 0 0 3px 0;
    }
    .order-id-sec {
    	 width: 70%;
        display: inline-block;
	}
    .order-id-sec span {
        font-size: 14px;
        font-weight: 400;
        letter-spacing: 0.4px;
    }
    .order-track-sec ul {
        position: relative;
        display: flex;
        flex-wrap: wrap;
    }
    .order-track-sec ul li.active {
        font-weight: 600;
    }
    .order-track-sec ul li.active {
        background-color: #ffc200;
        border-color: #ffc200;
        color: #303030;
    }

    .order-track-sec ul li {
        position: relative;
        text-align: center;
        padding: 10px 10px 10px 10px;
        font-weight: 400;
        font-size: 14px;
        line-height: 18px;
        border: 2px solid #bebebe;
        margin: 0 10px 0 0;
        min-width: 160px;
        border-radius: 5px;
    }
    .order-track-sec ul li i {
        font-size: 16px;
    }
    .order-track-sec ul li span {
        display: block;
        padding: 5px 0 0 0;
    }
    .status-sec{
    	
        display: inline-block;
    }
    .status-sec small {
        display: block;
        font-size: 14px;
        font-weight: 600;
        letter-spacing: 0.4px;
        color: #000000;
    }
    .status-sec span {
        font-size: 14px;
        font-weight: 400;
        letter-spacing: 0.4px;
    }
    .pending-order-box-info {
        
        flex-wrap: wrap;
        justify-content: space-between;
        width: 100%;
    }
    .pending-order-box-left {
        width: 69%;
        display: inline-block;
    }
    .pending-order-box-content small {
        display: block;
        font-size: 14px;
        font-weight: 600;
        letter-spacing: 0.4px;
        color: #000000;
        margin: 0 0 3px 0;
    }
    .pending-order-box-content span {
        font-size: 14px;
        font-weight: 400;
        letter-spacing: 0.4px;
        display: block;
        margin: 0 0 20px 0;
    }
    .pending-order-box-right {
        width: 30%;
        display: inline-block;
    }
    .order-details-sec h5 {
        font-size: 20px;
        line-height: 26px;
        font-weight: 600;
        letter-spacing: 0.4px;
        color: #000000;
        margin: 0 0 20px 0;
        width: 100%;
    }
    .pending-order-box-table {
        width: 100%;
    }
    .pending-order-box-table table {
        width: 100%;
    }
    .pending-order-box-table table th {
        font-size: 14px;
        font-weight: 600;
        letter-spacing: 0.4px;
        color: #000000;
        padding: 0 0 10px 0;
    }
    .pending-order-box-table table td {
        padding: 0 0 20px 0;
    }
    .order-details-sec span {
        font-size: 14px;
        font-weight: 400;
        letter-spacing: 0.4px;
        display: block;
    }
    .order-details-sec em {
        font-size: 12px;
        font-weight: 400;
        letter-spacing: 0.4px;
        display: block;
        font-style: normal;
        color: #555555;
    }
    .pending-order-heading {
    text-align: center;
}

.pending-order-heading h3 {
    font-size: 30px;
    line-height: 35px;
    color: #303030;
    font-weight: 600;
    text-align: center;
    margin: 0 0 20px 0;
}
.pending-order-wrap {
    display: flex;
    flex-wrap: wrap;
}

.pending-order-result {
    padding: 40px 0 0 0;
}


	</style>


</head>
<body>
	<div class="wrapper">

         <img src="{{asset('public/frontend/images/logo.png')}}">
                           
		<section class="pending-order-sec">
			
			<div class="pending-order-heading">
				<h3>Order Details</h3>
			</div>
			<div class="pending-order-wrap">

				<div class="pending-order-right">
					<div class="pending-order-result">

						@if(!empty($order))

						<div class="pending-order-box-wrap">
							<div class="pending-order-box-top">
								<div class="order-id-sec">
									<small>Order</small>
									<span>#{{$order->id}}</span>
									<small>Chef Name</small>
									
								</div>

								<div class="status-sec">
									<small>Order Date</small>
									<span>{{$order->delivery_date}}</span>
									<small>Delivery Time</small>
									<span>{{date('h:i A',strtotime($order->delivery_time))}}</span>
								</div>
							</div>
						</div>
						
						<div class="pending-order-box-wrap">
							<div class="pending-order-box-info">
								<div class="pending-order-box-left">
									<div class="pending-order-box-content">
										<small>Delivery / Pickup</small>
										<span>{{$order->pick_del_option==1?"Pickup":"Delivery"}}</span>
										@if($order->pick_del_option==2)
										<small>Delivery By</small>
										<span>{{$order->delivery_by==1?"Chef":"Delivery Company"}}</span>
										@endif
										<small>Customer Name</small>
										<span><strong>{{$order->user->first_name  .' '.$order->user->last_name }}</strong></span>
										<small>Address</small>
										<span>{{$order->user->location->address}}</span>
									</div>
								</div>
								<div class="pending-order-box-right" >
									<div class="pending-order-box-content">
										<small>Payment Status</small>
										<span>{{$order->payment_method==1?"Not Paid(COD)":"Paid"}}</span>
										<small>Payment Amount</small>
										@if(!empty($currency) && $currency->id == 101)
											<span style="font-family: DejaVu Sans; sans-serif;">{{!empty($currency)?$currency->symbol:''}}{{$order->sub_total}}</span>
										@else
											<span>{{!empty($currency)?$currency->symbol:''}}{{$order->sub_total}}</span>
										@endif

										@if($order->pick_del_option==2)
											<small>Delivery Amount</small>
											@if(!empty($currency) && $currency->id == 101)
												<span style="font-family: DejaVu Sans; sans-serif;">{{!empty($currency)?$currency->symbol:''}}{{$order->delivery_fee}}</span>
											@else
												<span>{{!empty($currency)?$currency->symbol:''}}{{$order->delivery_fee}}</span>
											@endif
											<small>Tips Amount</small>
											@if(!empty($currency) && $currency->id == 101)
												<span style="font-family: DejaVu Sans;">{{!empty($currency)?$currency->symbol:''}}{{$order->tip_fee}}
												</span>
											@else
												<span>{{!empty($currency)?$currency->symbol:''}}{{$order->tip_fee}}</span>
											@endif
										@endif	
									</div>
								</div>
							</div>
						</div>
						<div class="pending-order-box-wrap">
							<div class="order-details-sec">
								<h5>Item Details</h5>
								<div class="pending-order-box-table">
									<table>
										<thead>
											<tr>
												<th>No.</th>
												<th>Item</th>
												<th>Qty</th>
												<th>Special Instructions</th>
											</tr>
										</thead>
										<tbody align=center>
											@if(!empty($order->orderItems))
                                            @php $c=1; @endphp 
											@foreach($order->orderItems as $i)
											<tr>
												<td>{{$c++}}</td>
												<td>
													<div class="item-name">
														<span>{{$i->menu->item_name}}</span>
														<em>
															@if(!empty($order->orderItems))
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


						@endif
					</div>
				</div>
			</div>
		</section>            
	</div>

</body>
</html>



