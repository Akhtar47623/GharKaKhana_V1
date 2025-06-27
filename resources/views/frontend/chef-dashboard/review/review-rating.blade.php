@extends('frontend.chef-dashboard.layouts.app')
@section('content')
<div class="content-body">
	<!-- row -->
	<div class="container-fluid">
		@section('pageHeading')
		<h2>{{__('sentence.review') }}</h2>
		@endsection
		
		<div class="row">
			<div class="col-xl-12">
				<div class="card-header">
					<div class="card-title">
						<h4>{{__('sentence.customerreview') }}</h4>
					</div>
				</div>
				<div class="card review-table p-0 border-0">
					@if(!$review->isEmpty())
					@foreach($review as $r)
					<div class="row align-items-center p-4  border-bottom">
						<div class="col-xl-4 col-xxl-4 col-lg-5 col-md-12">
							<div class="media align-items-center">
								
								<img class="mr-3 img-fluid rounded-circle" width="100" src="{{asset('public/frontend/images/users')}}/{{$r->profile}}">
								<div class="card-body p-0">
									<!-- <p class="text-primary fs-14 mb-0">#C01234</p> -->
									<h3 class="fs-20 text-black font-w600 mb-2">{{$r->cust_id}}</h3>
									<span class="text-dark">{{date('F d, Y',strtotime($r->updated_at))}}</span>
								</div>
							</div>
						</div>
						<div class="col-xl-5 col-xxl-4 col-lg-7 col-md-12 mt-3 mt-lg-0">
							<p class="mb-0 text-dark">{{$r->chef_review}}</p>
						</div>
						<div class="col-xl-3 col-xxl-4 col-lg-7 col-md-12 offset-lg-5 offset-xl-0 media-footer mt-xl-0 mt-3">
							<div class="row">
								<div class="text-xl-center col-xl-7 col-sm-9 col-lg-8 col-6">
									<h3 class="text-black font-w600">{{$r->chef_rating}}</h3>
									<span class="star-review d-inline-block">
									@for($i=1;$i<=5;$i++) 
                                    @if(round($r->chef_rating)>=$i)                           
                                   	<i class="fa fa-star text-orange"></i>
                                    @else
                                   	<i class="fa fa-star text-gray"></i>
                                    @endif
                                    @endfor
									</span>
								</div>
							</div>

						</div>
						@endforeach
						@endif
					</div>
					<div class="row">
						<div class="col-8"></div>
						<div class="col-4">{{$review->links()}}</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
