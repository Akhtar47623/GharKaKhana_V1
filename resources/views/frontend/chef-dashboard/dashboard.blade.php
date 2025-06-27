@extends('frontend.chef-dashboard.layouts.app')
@section('content')
<div class="content-body">
            <!-- row -->
			<div class="container-fluid">
				@if($check==0)
				<div class="row">
					<div class="col-lg-12 col-sm-12">
						<div id="accordion-two" class="accordion accordion-danger-solid">
							<div class="accordion__item">
								<div class="accordion__header collapsed" data-toggle="collapse" data-target="#bordered_collapseTwo" > <span class="accordion__header--text"><h4 style="color: white;">{{__('sentence.process') }}</h4></span>
									<span class="accordion__header--indicator"></span>
								</div>
								<div id="bordered_collapseTwo" class="collapse accordion__body" data-parent="#accordion-two">
									<div class="accordion__body--text">
										<section class="our-blog p-0 m-0 bg-silver">
										    <div class="container work-process  pb-1 pt-1">
										        <!-- ============ step 1 =========== -->
										        <div class="row">
										            <div class="col-md-5">
										                <div class="process-box process-left" data-aos="fade-right" data-aos-duration="1000">
										                    <div class="row">
										                        <div class="col-md-5">
										                            <div class="process-step">
										                                <p class="m-0 p-0">{{__('sentence.step') }}</p>
										                                <h3 class="m-0 p-0">01</h3>
										                                @if($checkBunssinessDetail>0)
										                                <i class="fas fa-check-circle fa-2x" style="color: white;"></i>
										                                <h6>{{__('sentence.done') }}</h6>
										                                @endif
										                            </div>
										                        </div>
										                        <div class="col-md-7">
										                            <p><h4>{{__('sentence.bussinessdetail') }}</h4></p>
										                              @if(empty($checkBunssinessDetail))
										                                <a href="{{route('chef-dashboard-profile')}}">{{__('sentence.clickh') }}</a>
										                              @endif
										                        </div>
										                    </div>
										                    <div class="process-line-l"></div>
										                </div>
										            </div>
										            <div class="col-md-2"></div>
										            <div class="col-md-5">
										                <div class="process-point-right"></div>
										            </div>
										        </div>
										        <!-- ============ step 2 =========== -->
										        <div class="row">
										            
										            <div class="col-md-5">
										                <div class="process-point-left"></div>
										            </div>
										            <div class="col-md-2"></div>
										            <div class="col-md-5">
										                <div class="process-box process-right" data-aos="fade-left" data-aos-duration="1000">
										                    <div class="row">
										                        <div class="col-md-5">
										                            <div class="process-step">
										                                <p class="m-0 p-0">{{__('sentence.step') }}</p>
										                                <h3 class="m-0 p-0">02</h3>
										                                   	@if($checkTaxDetail>0)
										                               <i class="fas fa-check-circle fa-2x" style="color: white;"></i>
										                                <h6>{{__('sentence.done') }}</h6>
										                                @endif
										                            </div>
										                        </div>
										                        <div class="col-md-7">
										                        	@if($currency->id==142)
										                            <p><h4>{{__('sentence.rfcnumr') }}</h4></p>
										                            @else
										                            <p><h4>{{__('sentence.taxdetail') }}</h4></p>
										                            @endif
										                            @if(empty($checkTaxDetail))
										                                <a href="{{route('chef-dashboard-profile')}}">{{__('sentence.clickh') }}</a>
										                            @endif
										                        </div>
										                        
										                    </div>
										                    <div class="process-line-r"></div>
										                </div>
										            </div>

										        </div>
										        <!-- ============ step 3 =========== -->
										        <div class="row">
										            <div class="col-md-5">
										                <div class="process-box process-left" data-aos="fade-right" data-aos-duration="1000">
										                    <div class="row">
										                        <div class="col-md-5">
										                            <div class="process-step">
										                                <p class="m-0 p-0">{{__('sentence.step') }}</p>
										                                <h3 class="m-0 p-0">03</h3>
										                               @if($checkStripeDetail > 0)
										                                <i class="fas fa-check-circle fa-2x" style="color: white;"></i>
										                                <h6 >{{__('sentence.done') }}</h6>
										                                @endif
										                            </div>
										                        </div>
										                        <div class="col-md-7">
										                            <p><h4>{{__('sentence.bankingdetail') }}</h4></p>
										                             
										                             @if(!empty($accountLink))
										                             	<a href="{{$accountLink}}">{{__('sentence.create-stripe-acc')}}</a>
										                             @endif
										                            {{--  <a id="stripe" href="javascript:;">Basic modal</a> --}}
										                             
										                        </div>
										                        
										                    </div>
										                    <div class="process-line-l"></div>
										                </div>
										            </div>
										            <div class="col-md-2"></div>
										            <div class="col-md-5">
										                <div class="process-point-right"></div>
										            </div>
										        </div>
										        <!-- ============ step 4 =========== -->
										        <div class="row">
										            <div class="col-md-5">
										                <div class="process-point-left process-last"></div>
										            </div>
										            <div class="col-md-2"></div>
										            <div class="col-md-5">
										                <div class="process-box process-right" data-aos="fade-left" data-aos-duration="1000">
										                    <div class="row">
										                        <div class="col-md-5">
										                            <div class="process-step">
										                                <p class="m-0 p-0">{{__('sentence.step') }}</p>
										                                <h3 class="m-0 p-0">04</h3>
										                                @if($chekPickDel > 0)
												                           <i class="fas fa-check-circle fa-2x" style="color: white;"></i>
										                                	<h6>{{__('sentence.done') }}</h6>
												                        @endif
										                            </div>
										                        </div>
										                        <div class="col-md-7">
										                            <p><h4>{{__('sentence.setpd') }}</h4></p>
										                             @if($chekPickDel == 0)
										                                <a href="{{ route('pickup-delivery.create') }}">{{__('sentence.clickh') }}</a>
										                              @endif
										                        </div>
										                    </div>
										                    <div class="process-line-r"></div>
										                </div>
										            </div>
										        </div>
										       
										    </div>
										</section>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				@endif
				
				<div class="row">
					@section('pageHeading')
						<h2>{{ __('sentence.dashboard') }}</h2>
					@endsection
					<div class="col-xl-3 col-lg-6 col-sm-6 col-6">
						<div class="widget-stat card bg-danger ">
							<div class="card-body  p-4">
								<div class="media">
									<span class="mr-3 mob-none">
										<i class="fa fa-bars"></i>
									</span>
									<div class="media-body text-white text-right">
										<p class="mb-1">Menu</p>
										<h3 class="text-white">{{$totalMenu}}</h3>
									</div>
								</div>
							</div>
						</div>
                    </div>
					<div class="col-xl-3 col-lg-6 col-sm-6 col-6">
						<div class="widget-stat card bg-success">
							<div class="card-body p-4">
								<div class="media">
									<span class="mr-3 mob-none">
										<i class="fa fa-shopping-cart"></i>
									</span>
									<div class="media-body text-white text-right">
										<p class="mb-1">{{ __('sentence.order') }}</p>
										<h3 class="text-white">{{$unCompletedOrder}}</h3>
									</div>
								</div>
							</div>
						</div>
                    </div>
					
                    <div class="col-xl-3 col-lg-6 col-sm-6 col-6">
						<div class="widget-stat card bg-primary">
							<div class="card-body p-4">
								<div class="media">
									<span class="mr-3 mob-none">
										<i class="fa fa-user"></i>
									</span>
									<div class="media-body text-white text-right">
										<p class="mb-1">{{ __('sentence.customer') }}</p>
										<h3 class="text-white">{{count($customers)}}</h3>
									</div>
								</div>
							</div>
						</div>
                    </div>
					 <div class="col-xl-3 col-lg-6 col-sm-6 col-6">
						<div class="widget-stat card bg-warning">
							<div class="card-body p-4">
								<div class="media">
									<span class="mr-3 mob-none">
										{{!empty($currency)?$currency->symbol:''}} 
									</span>
									<div class="media-body text-white text-right">
										<p class="mb-1">{{ __('sentence.tincome') }}</p>
										<h3 class="text-white">{{round($todayIncome)}}</h3>
									</div>
								</div>
							</div>
						</div>
                    </div>
					<div class="col-xl-12 col-xxl-12 col-lg-12 col-sm-12">
						<div class="card">
							<div class="card-header">
								<div>
									<h4 class="card-title">{{ __('sentence.recentor') }}</h4>
								</div>
							</div>
                            <div class="card-body p-0">
                                @foreach($orderListPen as $ol)
								<?php 
								$str=''; 
								foreach($ol->orderItems as $i){
									$str .= $i->menu->item_name.', ' ;
								}
								$str = rtrim($str, ', ');
								?>
                                <div class="sp15 row border-bottom favorites-items p-3 align-items-center">
                                    <div class="col-xl-6 col-lg-6 col-sm-6 col-12 mb-3 mb-lg-0">
                                        <div class="media align-items-center">
                                            <img class="rounded mr-3" src="{{asset('public/frontend/images/users')}}/{{$ol->user->profile}}" alt="" style="width:80px">
                                            <div class="media-body">
                                                <small class="mt-0 mb-1 font-w500">MAIN COURSE</small>
                                                <h5 class="mb-2">{{$str}}</h5>
                                                <h5 class="mb-2"><span class="text-warning">{{__('sentence.by')}}</span> {{$ol->user->display_name}}</h5>
                                                <p class="mb-0 fs-12">{{$ol->user->location->address}}</p>                                              
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-sm-3 col-6 media text-center">

                                        <div class="media-body">
                                            <span class="text-black">{{__('sentence.amount') }}</span>
                                            <h5 class="text-black font-w600 mb-1">{{!empty($currency)?$currency->symbol:''}} {{$ol->pay_total}}</h5>                                       
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-sm-3 col-6 media text-center">

                                        <div class="media-body">
                                            <a class="btn btn-xs bgl-warning text-warning" href="javascript:;">{{ __('sentence.pen') }}</a>                                    
                                        </div>
                                    </div>
                                    
                                </div>
                               
                               	@endforeach
								
                            </div>
                            @if(count($orderListPen)>5)
							<div class="card-footer border-0 pt-0 text-center">
                            	<a href="{{route('order.view')}}" class="btn-link">{{ __('sentence.viewmore') }} &gt;&gt;</a>
                            </div>
							@endif 
                        </div>
						
					</div>
				</div>
            </div>
        </div>

@endsection
@section('pageScript')
<script>AOS.init();</script>

<script type="text/javascript">
    //order status change
    $('.change-status').click(function(event) {
        var id = $(this).data('id');
        var action = $(this).attr('data-action');
        var status = $(this).attr('data-status');
        var timezone = $('#timezone').val();
        $.ajax({
            url: action,
            type: 'post',
            dataType: 'json',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {id: id,status:status,timezone:timezone},
            success: function (res) { // What to do if we succeed
                toastr.options = {'positionClass': "toast-bottom-left"}
                if (res.status === 'success') {
                    toastr.success(res.msg);
                    location.reload();
                } else {
                    toastr.error(res.msg);
                }
            }
        });
              
    });
    $( ".accordion__header" ).trigger( "click" );
</script>
@endsection
