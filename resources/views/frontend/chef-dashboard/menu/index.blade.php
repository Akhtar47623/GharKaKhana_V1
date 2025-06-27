@extends('frontend.chef-dashboard.layouts.app')
@section('pageCss')
<style type="text/css">
	.fade:not(.show) {
	opacity: 0;
	display: none;
	}
.tab-content {
border-top: 1px solid #dee2e6;
width: 100%;
}
.togBtn
{
	width: 10%;
}

</style>
@endsection
@section('content')
<div class="content-body">
	<div class="container-fluid">
		@section('pageHeading')
		<h2>Menu</h2>
		@endsection 
		
		<div class="row">
			<div class="col-xl-12">
				<div class="card">
					@if($check == 1)
					<div class="card-header">
						<div class="card-title">
							<h4> {{__('sentence.menulist') }}</h4>
						</div>

						<a href="{{ route('menu.create') }}" class="btn btn-xs btn-warning" title="Add new">
							<i class="fa fa-plus-circle"></i>  {{__('sentence.addmenu') }}</a>
							
						</div>
					
						<div class="card-body">
						
							<div class="custom-tab-1">
								<ul class="nav nav-tabs">
									@empty($chefMainCategory)
										<li><i class="fad fa-telescope"></i>Menu Not Found</li>
									@else
										@foreach($chefMainCategory as $value)
										<li class="nav-item">
											<a class="{{ $loop->first ? 'nav-link active' : 'nav-link' }}" data-toggle="tab" href="#{{str_replace(' ', '-',$value->item_category )}}">{{$value->item_category}}</a>

										</li>
										@endforeach											
									@endempty
								</ul>
								@foreach($mainCategory as $mainCat)
								<ul  class="{{ $loop->first ? 'nav nav-tabs fade show active' : 'nav nav-tabs fade' }}" id="{{str_replace(' ', '-',$mainCat['maincategory'] )}}">
									
									@foreach($mainCat['subcategory'] as $subCat)
									<li class="nav-item">
										<a class="{{ $loop->first ? 'nav-link active' : 'nav-link' }}" data-toggle="tab" href="#{{str_replace(' ', '-',$subCat)}}">{{ucfirst($subCat)}}</a>
									</li>
									@endforeach
									
									<div class="tab-content">
										
										@foreach($mainCat['items'] as $itm)
										
										<div class="{{ $loop->first ? 'tab-pane fade show active' : 'tab-pane fade' }}" id="{{str_replace(' ', '-',$itm[0]['item_type'])}}" role="tabpanel">
											<div class="pt-4">
												<div class="row">
													<div class="col-xl-12">
														<div class="card">
															<div class="card-body">
																@foreach($itm as $i)
																<div class="sp15 row border-bottom favorites-items p-3 align-items-center p-sm-4">
																	<div class="col-xl-7 col-lg-6 col-sm-6 col-12 mb-3 mb-lg-0">
																	    <h4 class="mb-2">{{$i->item_name}}</h4>
																		<div class="media">
																			<img class="rounded mr-3" src="{{asset('public/frontend/images/menu/'.$i->photo)}}" alt="" style="width:70px">
																			<div class="media-body">
																				
																				<span class="text-dark"><small> 
																					<?php 
																					echo strlen($i->item_description)>50?
																						substr($i->item_description, 0, 50).'...':$i->item_description
																					?></small></span>
																			</div>
																		</div>
																	</div>
																	<div class="col-xl-2 col-lg-2 col-sm-2 col-4 ">
																		
																		<div class="media-body">
																			<label class="switch">
																							<input type="checkbox" class="changeBtn" name="item_visibility" data-id="{{$i->id}}" data-action="{{route('change-menu-visibility')}}" {{$i->item_visibility=="1"?'checked':''}}>
																							<div class="slider round">
																							<span class="on">{{__('sentence.on')}}</span><span class="off">{{__('sentence.off')}}</span>
																							</div>
																						</label>
																			<span class="text-warning " style="display: block;">{{__('sentence.visibilty') }}</span>
																		</div>
																	</div>
																	<div class="col-xl-2 col-lg-2 col-sm-2 col-5">
																		<div class="media-body ">
																			
																			<label class="switch ">
																							<input type="checkbox" class="togBtn" data-id="{{$i->id}}" data-action="{{route('change-menu-status')}}" {{$i->status=="1"?'checked':''}}>
																							<div class="slider round">
																							<span class="on">{{__('sentence.available')}}</span><span class="off">{{__('sentence.navailable')}}</span>
																							</div>
																						</label>
																		</div>
																		<span class="text-warning" style="display: block;">{{__('sentence.status') }}</span>
																	</div>
																	<div class="col-xl-1 col-lg-2 col-sm-1 col-3 text-right">
																		<div class="media-body"></div>
																		<span class="text-warning" style="display: block;">
																		<div class="dropdown" style="margin-top: 25px">
																			<button class="btn btn-warning tp-btn-light sharp" type="button" data-toggle="dropdown">
																				<span class="fs--1">
																					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg>
																				</span>
																			</button>
																			<div class="dropdown-menu dropdown-menu-right border py-0">
																				<div class="py-2">
																					<a href="{{route('menu.edit', $i->uuid)}}" class="dropdown-item">{{__('sentence.edit')}}</a>
																					<a id="item" type="delete" title="Delete" rel="tooltip" class="dropdown-item text-danger sharp remove delete"  data-id="{{($i->id)}}"  data-action="{{route('menu.destroy', $i->id)}}" data-message="{{__('validation.confirm')}}">{{__('sentence.delete')}}</a>
																				</div>
																			</div>
																		</div>
																		</span>	
																	</div>
																</div>
																@endforeach
																
															</div>
														</div>
													</div>
												</div>
											</div>
											
										</div>
										
										@endforeach
										
									</div>
									
								</ul>
								@endforeach
								
							</div>
						</div>
					</div>
					@else
						<span class="text-danger" style="padding: 20px;font-size: 14px"> {{__('sentence.add-menu-msg') }}</span>
					@endif 
				</div>
			</div>
		</div>
	</div>
	@endsection
	@section('pageScript')
	<script type="text/javascript" src="{{ asset('public/frontend/js/pages/toggle.js')}}"></script>
	<script src="{{asset('public/frontend/chef-dashboard/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
	{{-- <script>$('#menuList').DataTable({});</script> --}}
	@endsection

	