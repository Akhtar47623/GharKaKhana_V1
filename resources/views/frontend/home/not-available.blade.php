@extends('frontend.layouts.app')
@section('content')

<section class="not-found-sec">
    <div class="not-found-wrap">
        <img src="{{asset('public/frontend/images/food-graphic.png')}}" alt="">
        <h6>{{__('sentence.unavailable-area1') }}</h6>
        <p>{{__('sentence.unavailable-area2') }} <br>{{__('sentence.unavailable-area3') }}</p>
    </div>
</section>

@endsection