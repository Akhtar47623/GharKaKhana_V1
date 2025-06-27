@extends('frontend.layouts.app')
@section('pageCss')

@endsection
@section('content')

<section class="video-sec-wrap">
	<div class="container">
		@if(!$videoData->isEmpty())
		<div class="sharing-media">
			<h3>Videos</h3>
			<ul>                            
				@foreach ($videoData as $value)
				<li>
					<iframe src="https://www.youtube.com/embed/{{substr($value->video_link, -11)}}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					<div class="video-description">
						<h4>{{$value->title}}</h4>
						<p>{!! substr($value->description, 0, 60) !!}</p>
						
						<span>{{$value->created_at->diffForHumans()}}</span>
					</div>
				</li>
				@endforeach                           
			</ul>
		</div>
		@endif
	</div>

</section>

@endsection
@section('pagescript')        

@endsection
