@extends('frontend.layouts.app')
@section('pageCss')

@endsection
@section('content')
<section class="blog-sec-wrap">
	<div class="recipe-slider">
		<h3>Blog</h3>
		@foreach($blogData as $d)
		<div class="recipe-box">
			<div class="recipe-img" style="background-image: url({{asset('public/frontend/images/blog/'.$d->image)}});"></div>
			
			<div class="recipe-content">
				<h5>{{$d->title}}</h5>
				<p>{!! $d->description !!}</p>
			</div>
		</div>
		@endforeach
	</div>
</section>

@endsection
@section('pagescript')        


@endsection