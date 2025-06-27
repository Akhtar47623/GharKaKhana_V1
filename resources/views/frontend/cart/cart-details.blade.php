@extends('frontend.layouts.app')
@section('pageCss')
<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend/css/magnific-popup.css')}}">
@endsection
@section('content')

<section class="checkout-sec">
	<div class="container">
		<div class="checkout-wrap">
			<?php 
				$st=[];
				$et=[];
			?>
			@if(!empty($subCart))
				@foreach($subCart as $s)													
					<?php 
						array_push($st, strtotime($s['start_time']));
						array_push($et, strtotime($s['end_time']));
					?>									
				@endforeach
				<?php 
					$start_time=max($st);
					$end_time=max($et);
				?>
			@endif
			
			<div class="checkout-right">
				<span>{{__('sentence.chooseop') }}</span>
				<div class="location-tab-sec">
					<ul class="resp-tabs-list hor_1">

						@if(!empty($pickupDeliveryDetails))
							@if($pickupDeliveryDetails->options == 1)
								<li class="pickup-link" tab="pickup">Pickup</li>
							@elseif($pickupDeliveryDetails->options == 2)
								<li class="pickup-link" tab="pickup">Pickup</li>
								<li class="delivery-link" tab="delivery">Delivery</li>
							@elseif($pickupDeliveryDetails->options == 3)
								<li class="delivery-link" tab="delivery">Delivery</li>
							@endif							
						@endif
					</ul>
					<div class="resp-tabs-container hor_1">
					@if(!empty($pickupDeliveryDetails))
						@if($pickupDeliveryDetails->options == 1 || $pickupDeliveryDetails->options == 2)
						<div>
							<div class="checkout-location-sec">
								<div class="checkout-location-form">
									<form class="form-main">
										<ul>						
											<li>
						                        <div class="form-wrap">
						                        	<label for="">{{__('sentence.pickupt') }}</label>
						                            <select name="pic_time" class="time-picker">
						                            	@if(!empty($start_time)&&!empty($end_time))
						                            	@for($i=$start_time+1800;$i<=$end_time;$i+=1800)
						                            		<option value="{{date('H:i', $i)}}">{{date('H:i', $i)}}</option>
						                            	@endfor
						                            	@endif
						                            </select>
						                        </div>
						                    </li>
											<li>
						                        <div class="form-wrap">
						                        	<label for="">{{__('sentence.address') }}</label>
						                            <input type="text" name="pic_address" id="pic_address" value="{{$pickupDeliveryDetails->pickupDetails->address}}" disabled>
						                        </div>
						                    </li>
						                    <li class="half-field">
						                        <div class="form-wrap">
						                        	<label for="">{{__('sentence.city') }}</label>
						                        	{{ Form::select('pic_city',!empty($cities) ? $cities : [], $pickupDeliveryDetails->pickupDetails->city_id,["required","id"=>"pic_city","name"=>"pic_city","class"=>"remove-arrow",'disabled']) }}				                            
						                        </div>
						                    </li>
						                    <li class="half-field">
						                        <div class="form-wrap">
						                        	<label for="">{{__('sentence.state') }}</label>
						                            {{ Form::select('state',!empty($states) ? $states : [], $pickupDeliveryDetails->pickupDetails->state_id,["required","id"=>"pic_state","name"=>"pic_state","class"=>"remove-arrow",'disabled' ]) }}	
						                        </div>
						                    </li>					                    
						                    <li class="half-field">
						                        <div class="form-wrap">
						                        	<label for="">{{__('sentence.zipcode') }}</label>
						                            <input type="text" name="pic_zipcode" value="{{$pickupDeliveryDetails->pickupDetails->zipcode}}" id="pic_zipcode" disabled>
						                        </div>
						                    </li>
						                    <li class="half-field">
						                        <div class="form-wrap">
						                        	<label for="">{{__('sentence.mobile') }}</label>
						                            <input type="text" name="pic_mobile" value="{{$pickupDeliveryDetails->pickupDetails->mobile}}"  id="pic_mobile" disabled>
						                        </div>
						                    </li>
						                    <li>
						                        <div class="col-md-12">
						                            <div class="alert display-none alert-danger"></div>
						                        </div>
                    						</li>
						                </ul>
									</form>
								</div>
							</div>
						</div>
						@endif
						@if($pickupDeliveryDetails->options == 2 || $pickupDeliveryDetails->options == 3)	
						<div>
							<div class="checkout-location-sec">
								<div class="checkout-location-form">
									{{ Form::open(['url' => route('save-delivery-address'),'class'=>'form-main', 'method'=>'POST', 'files'=>true, 'name' => 'frmDelivery', 'id' => 'frmDelivery',"autocomplete"=>"off"]) }}	
									<input type="hidden" name="chef_id" id="chef_id" value="{{!empty($chefLoc)?Crypt::encrypt($chefLoc->chef_id):''}}"> 
									
										<ul>
											<li>
						                        <div class="form-wrap">
						                        	<label for="">{{__('sentence.delt') }}</label>
						                            <select name="pic_time" class="time-picker">
						                            	@if(!empty($start_time)&&!empty($end_time))
						                            	@for($i=$start_time+1800;$i<=$end_time;$i+=1800)
						                            		<option value="{{date('H:i', $i)}}">{{date('H:i', $i)}}</option>
						                            	@endfor
						                            	@endif
						                            </select>
						                        </div>
						                    </li>
											<li>
						                        <div class="form-wrap">
						                            <label for="">{{__('sentence.location') }}</label>
						                            <input type="text" name="new_location" id="new_location" placeholder="Enter New Address" class="time-picker">
						                            <input type="hidden" name="cust_id" id="cust_id" value="{{!empty($currentLocation)?Crypt::encrypt($currentLocation->cust_id):''}}">
						                            <input type="hidden" name="pic_del_id" id="pic_del_id" value="{{!empty($pickupDeliveryDetails)?$pickupDeliveryDetails->id:''}}">
						                            <input type="hidden" name="del_lat" id="del_lat">
									                <input type="hidden" name="del_log" id="del_log">
									                <input type="hidden" name="del_country" id="del_country">
									                
									                @if(!empty($pickupDeliveryDetails->pickupDetails->address))
									                <input type="hidden" name="chef_add" id="chef_add" value="{{$pickupDeliveryDetails->pickupDetails->address}}"> 
									                @else
									                <input type="hidden" name="chef_add" id="chef_add" value="{{!empty($chefLoc)?$chefLoc->address:''}}"> 
									                @endif 

						                        </div>
						                    </li>						                    
											<li>
						                        <div class="form-wrap">
						                            <label for="">{{__('sentence.address') }}</label>
						                            <input type="text" name="del_address" id="del_address" value="{{!empty($currentLocation)?$currentLocation->address:''}}" readonly="">
						                        </div>
						                    </li>						                                       
						                    <li class="half-field">
						                        <div class="form-wrap">
						                            <label for="">{{__('sentence.city') }}</label>
						                            <input type="text" name="del_city" id="del_city" value="{{!empty($currentLocation)?$currentLocation->city:''}}" readonly="">
						                        </div>
						                    </li>
						                    <li class="half-field">
						                        <div class="form-wrap">
						                            <label for="">{{__('sentence.state') }}</label>
						                            <input type="text" name="del_state" id="del_state" value="{{!empty($currentLocation)?$currentLocation->state:''}}" readonly="">
						                        </div>
						                    </li>
						                    <li class="half-field">
						                        <div class="form-wrap">
						                            <label for="">{{__('sentence.country') }}</label>
						                            <input type="text" name="del_cntry" id="del_cntry" value="{{!empty($currentLocation)?$currentLocation->country:''}}" readonly="">
						                        </div>
						                    </li>
						                    <li class="half-field">
						                        <div class="form-wrap">
						                            <label for="">{{__('sentence.zipcode') }}</label>
						                            <input type="text" name="del_zip_code" id="del_zip_code" value="{{!empty($currentLocation)?$currentLocation->zipcode:''}}" readonly="">
						                        </div>
						                    </li>   
						                    <li>
						                    	<div class="form-wrap">
						                    		<button type="button" name="btnSubmit" value="{{__('sentence.savec') }}" id="btnSubmit" data-loading-text="<i class='fa fa-spinner fa-spin'></i>">{{__('sentence.savec') }}</button>
						                    		
						                        </div>
						                    </li>
						                    <li>
						                        <div class="col-md-12">
						                            <div class="alert display-none alert-danger"></div>
						                        </div>
                    						</li>
						                </ul>
									{{ Form::close() }}

								</div>
							</div>
						</div>
						@endif
					@endif	
					</div>
				</div>
			</div>
			
			<div class="checkout-center">
				<img src="{{ asset('public/frontend/images/googl-ad.jpg')}}" alt="">
			</div>
			
			<div class="checkout-left">
				@if(!empty($subCart))
				<div class="order-from">
					<span>{{__('sentence.orderf') }}</span>
					@foreach($subCart as $c)
					<h5>{{ucwords($c['chef_nm'])}}</h5>
					<span>{{__('sentence.date') }}</span>
					<h5>{{ \Carbon\Carbon::parse($c['available_date'])->format('l d M, Y')}}<br></h5>
					@break
					@endforeach
				</div>
				@endif
				<div class="promocode-sec">
					{{ Form::open(['url' => route('add-discount'), 'method'=>'POST', 'files'=>true, 'name' => 'frmDiscount', 'id' => 'frmDiscount',"autocomplete"=>"off"]) }}	
						<input type="text" name="promo_code" placeholder="{{__('sentence.couponc') }}" required="">
						<button type="submit" name="btnDisSubmit" id="btnDisSubmit">{{__('sentence.apply') }}</button>
					{{ Form::close() }}
				</div>
			
				<div class="checkout-price-sec">
					<ul>
						
						<li>
							<span>{{__('sentence.subtotal') }}</span>
							<span id="subtotal">
									
            						{{sprintf('%0.2f',session()->get('order')['orderData']['sub_total'])}}
							</span>
						</li>
						<li>
							<span>{{__('sentence.discount') }}</span>
							<?php $discount = session()->get('order')['orderData']['chef_discount']+session()->get('order')['orderData']['house_discount']+session()->get('order')['orderData']['makem_discount'] ?>
							<span id='discount'>{{sprintf('%0.2f',$discount)}}</span>
						</li>
						@if(!empty($taxes) && $currency->id!=142)
						<li>
							<span>{{__('sentence.servicefee') }}</span>							
							<span id="ser_fee">{{sprintf('%0.2f',session()->get('order')['orderData']['service_fee'])}}</span>
						</li>
						@endif
						<li>
							<span>{{__('sentence.delfee') }}<span  id="del_fee_title"></span></span>
							
							<span id="del_fee">{{sprintf('%0.2f',session()->get('order')['orderData']['delivery_fee'])}}</span>
						</li>
						@if(!empty($taxes) && $currency->id!=142)
							@if(!empty($taxes->tax))
							<li>
								
								<span>{{__('sentence.tax') }} @ {{$taxes->tax}}%</span>
								<span id="taxes">{{sprintf('%0.2f',session()->get('order')['orderData']['tax_fee'])}}</span>
							</li>
							@endif
						@endif
						
						
					</ul>
					<div class="checkout-total">
							<span>{{__('sentence.total') }}</span>
							@if($currency->id==142)
								<?php $total = (session()->get('order')['orderData']['sub_total']  + session()->get('order')['orderData']['delivery_fee'])- $discount;?>
							@else
								<?php $total = (session()->get('order')['orderData']['sub_total'] + session()->get('order')['orderData']['service_fee'] + session()->get('order')['orderData']['delivery_fee'] + session()->get('order')['orderData']['tax_fee'])- $discount;?>
							@endif	
							
							<span>
								{{!empty($currency)?$currency->symbol:''}}
								<span id="total" class="total-amt">{{sprintf('%0.2f',$total)}}</span>
							</span>
						</div>
				</div>
				<div class="tips-sec">
					<h4>{{__('sentence.addt') }}</h4>
					<form>
						<ul>
							<li>
								<input type="radio" name="tips" value="0">
								<span>0%</span>
							</li>
							<li>
								<input type="radio" name="tips" value="15">
								<span>15%</span>
							</li>
							<li>
								<input type="radio" name="tips" value="18">
								<span>18%</span>
							</li>
							<li>
								<input type="radio" name="tips" value="20">
								<span>20%</span>
							</li>
							<li style="display: none;" class="custom-tip" >
								<input type="radio" name="tips" value="24">
								<span>24%</span>
							</li>
							<?php $tips=0.00 ?>
						</ul>
						<div class="custom-btn">
							<button type="button" id="cust">{{__('sentence.addct') }}</button>								
						</div>
						<div class="promocode-sec" id="cust-sec" style="display: none">							
							<input type="number" name="cust" min="0" max="100" onchange="handleChange(this);"  id="txtCust" placeholder="Tips Persontage" onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57">
							<button type="button" id="btnCust">{{__('sentence.add') }}</button>							
						</div>
						
					</form>
				</div>
				
				<div class="place-order">
					<div class="final-price">
						<span>{{__('sentence.gtotal') }}</span>						
						<span>
							
							{{!empty($currency)?$currency->symbol:''}}
							@if($currency->id==142)
								<?php $gtotal = (session()->get('order')['orderData']['sub_total']  + session()->get('order')['orderData']['delivery_fee'])- $discount;?>
							@else
								<?php $gtotal = (session()->get('order')['orderData']['sub_total'] + session()->get('order')['orderData']['service_fee'] + session()->get('order')['orderData']['delivery_fee'] + session()->get('order')['orderData']['tax_fee'])- $discount;?>
							@endif	
							
							<span id="grandtotal" class="total-amt">{{sprintf('%0.2f',$gtotal)}}</span>
						</span>
					</div>
					
						@if(!empty($pickupDeliveryDetails))
							@if($pickupDeliveryDetails->options == 1 || $pickupDeliveryDetails->options == 2)						
								<a href="{{route('stripe.create')}}" class="place-order-btn active" >{{__('sentence.porder') }}</a>
							@else
								<a href="{{route('stripe.create')}}" class="place-order-btn" >{{__('sentence.porder') }}</a>
							@endif
						@endif
					
				</div>
				
			</div>
		</div>
	</div>
</section>

@endsection
@section('pagescript')
<script src="{{asset('public/backend/common/jquery.validate.js')}}"></script>
<script type="text/javascript" src="{{ asset('public/frontend/js/easy-responsive-tabs.js')}}"></script>
<script type="text/javascript" src="{{ asset('public/frontend/js/jquery.magnific-popup.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('public/frontend/js/pages/checkout.js')}}"></script>
@endsection
