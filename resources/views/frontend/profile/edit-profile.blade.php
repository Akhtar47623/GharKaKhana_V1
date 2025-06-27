@extends('frontend.layouts.app')
@section('content')

<section class="edit-profile-sec">
	<div class="container">
		<div class="edit-profile-wrap">
			<div class="edit-profile-tab">
				<ul class="resp-tabs-list hor_1">
					<li>
						{{__('sentence.basicinfo')}}
					</li>
					<li>
						{{__('sentence.changepass')}}
					</li>
					<li>
						{{__('sentence.location')}}
					</li>
				</ul>
				<div class="resp-tabs-container hor_1">
					<div>
						<div class="basic-detail-sec edit-profile-form form-main">
							{{ Form::open(['url' => route('update.profile', $custProfile->uuid), 'method'=>'PUT', 'files'=>true, 'name' => 'frmCustProfile', 'id' => 'frmCustProfile','class'=>"form-main"]) }}
								<ul>
									<?php
										if(!empty($custProfile)){
											if(!empty($custProfile->first_name) && !empty($custProfile->last_name)){
												$first_name = $custProfile->first_name;
												$last_name = $custProfile->last_name;
											}
											else{
												$first_name=strtok($custProfile->display_name,' ');
												$last_name = strstr($custProfile->display_name, ' ');
											}
										}
									?>
									<li>
										<div class="form-wrap">
											<label for="">{{__('sentence.firstname')}}<em>*</em></label>
											<input type="text" name="first_name" required="" 
											value="{{$first_name}}">
										</div>
									</li>
									<li>
										<div class="form-wrap">
											<label for="">{{__('sentence.lastname')}}<em>*</em></label>
											<input type="text" name="last_name" required="" value="{{$last_name}}">
										</div>
									</li>
									<li>
										<div class="form-wrap">
											<label for="">{{__('sentence.mobile')}}<em>*</em></label>
											<input type="text" name="mobile" required="" value="{{!empty($custProfile)?$custProfile->mobile:''}}">
										</div>
									</li>
									<li>
										<div class="form-wrap">
											<label for="">{{__('sentence.profile')}}<em>*</em></label>							
			                                {{ Form::file('profile', ["class"=>"form-control","placeholder"=>"Profile","id"=>"profile","name"=>"profile","onchange"=>"previewImage(this)", "accept"=>"image/*"]) }}
			                                <div id="previewImage" style="padding:10px">
			                                    @if(isset($custProfile))
			                                        <img src="{{ asset('public/frontend/images/users/'.$custProfile->profile) }}" height="100px" width="100px"
			                                             alt="User profile picture">
			                                    @endif
			                                </div>
			                                {{ Form::hidden('oldImage', $custProfile->profile) }}
										</div>
									</li>
									<li class="full-width">
										<div class="form-wrap">
											<button type="submit" class="" id="btnProfile">{{__('sentence.uptbasicinfo')}}</button>
											<img id="loader" src="{{ asset('public/frontend/images/loader.gif')}}" alt="" />
										</div>
									</li>
								</ul>
								
							{{ Form::close() }}
						</div>
					</div>
					<div>
						<div class="change-password-sec edit-profile-form form-main">
							{{ Form::open(['url' => route('update.password', $custProfile->uuid), 'method'=>'PUT', 'files'=>true, 'name' => 'frmCustChangePassword', 'id' => 'frmCustChangePassword','class'=>"form-main"]) }}
								<ul>
									<li>
										<div class="form-wrap">
											<label for="">{{__('sentence.email')}}<em>*</em></label>
											<input type="email" name="email" required="">
										</div>
									</li>
									<li>
										<div class="form-wrap">
											<label for="">{{__('sentence.pass')}}<em>*</em></label>
											<input type="password" name="password" id="password" required="">
										</div>
									</li>
									<li>
										<div class="form-wrap">
											<label for="">{{__('sentence.npass')}}<em>*</em></label>
											<input type="password" name="confirm_password" id="confirm_password" required="">
										</div>
									</li>
									<li class="full-width">
										<div class="form-wrap">
											<button type="submit" class="" id="btnChangePassword">{{__('sentence.uptpass')}}</button>
											<img id="loader" src="{{ asset('public/frontend/images/loader.gif')}}" alt="" />
										</div>
									</li>
								</ul>
							{{ Form::close() }}
						</div>
					</div>
					<div>
						<div class="change-location-sec edit-profile-form form-main">
							{{ Form::open(['url' => route('update.location', $custProfile->id), 'method'=>'PUT', 'files'=>true, 'name' => 'frmCustLocation', 'id' => 'frmCustLocation','class'=>"form-main"]) }}
								<ul>
									<li>
										<div class="form-wrap">
											<label for="">{{__('sentence.location')}}</label>
											<input type="text" name="locationadd" id="locationadd" required="" value="{{!empty($custProfile->location->address)?$custProfile->location->address:''}}" >
											<input type="hidden" name="cust_lat" id="cust_lat">
									        <input type="hidden" name="cust_log" id="cust_log">
									        <input type="hidden" name="cust_city" id="cust_city">
									        <input type="hidden" name="cust_state" id="cust_state">
									        <input type="hidden" name="cust_country" id="cust_country">
									    </div>
									</li>
									<li class="full-width">
										<div class="form-wrap">
											<button type="submit" class="" id="btnChangeLocation">{{__('sentence.uptlocation')}}</button>
											<img id="loader" src="{{ asset('public/frontend/images/loader.gif')}}" alt="" />
										</div>
									</li>
								</ul>
							{{ Form::close() }}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

@endsection
@section('pagescript')
<script src="{{asset('public/backend/common/jquery.validate.js')}}"></script>
<script type="text/javascript" src="{{ asset('public/frontend/js/pages/cust-profile.js')}}"></script>
<script type="text/javascript" src="{{ asset('public/frontend/js/easy-responsive-tabs.js')}}"></script>

@endsection
