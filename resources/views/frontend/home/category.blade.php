@extends('frontend.layouts.app')
@section('content')
<section class="food-categories-sec">
	<div class="container">
		<div class="food-categories-wrap">
			<div class="food-categories-heading">
				<h2>{{__('sentence.foodcat') }}</h2>
			</div>                   
			<div class="categories-list-wrap">
				@if(!$categories->isEmpty())
				@foreach ($categories as $cat)
				<div class="categories-list">
					<a href="{{url('search/menu/'.$cat->name.'/'.$cat->name)}}">
						<div class="categories-box">
							<div class="categories-img" style="background-image: url('{{asset('public/backend/images/category/'.$cat->image)}}');"></div>
							<div class="categories-content">
								<h4>{{$cat->name}}</h4>
								<p>{{$cat->description}}</p>
							</div>
						</div>
					</a>
				</div>
				@endforeach
				@endif
			</div>   
			
		</div>
	</div>
</section>
@endsection
