@php
$schedule = new \App\Model\Schedule;
@endphp
@extends('frontend.layouts.app')
@section('content')
        <section class="banner-sec">
            @if(auth('front')->check() && auth('front')->user()->type == "Customer")
            <div class="banner-slider">
                <div>
                    <div class="banner-wrap">
                        <div class="banner-img" style="background-image: url('{{asset('public/frontend/images/first_slider.jpg')}}');"></div>
                        <div class="banner-content">
                            <h1>{{__('sentence.coming-soon-title') }}</h1>
                            <p>{{__('sentence.coming-soon-desc1') }}</p>

                           <p>{{__('sentence.coming-soon-desc2') }}</p>
                            
                            <a href="{{ route('mexico-more-info') }}" title="">{{__('sentence.moreinfo') }}</a>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="banner-wrap">
                        <div class="banner-img" style="background-image: url('{{asset('public/frontend/images/customer-registration-bg-img.jpg')}}');"></div>
                        <div class="banner-content">
                            <h1>{{__('sentence.localf') }}</h1>
                            <p>{{__('sentence.localfdesc') }}</p>
                            <a href="{{ route('local-fav')}}" title="">{{__('sentence.ordernow') }}</a>
                        </div>
                    </div>
                </div>
            </div>                
            @else 
            <div class="banner-slider">
                @if($countryId=='142')
                <div>
                    <div class="banner-wrap">
                        <div class="banner-img" style="background-image: url('{{asset('public/frontend/images/first_slider.jpg')}}');"></div>
                        <div class="banner-content">
                            <h1>{{__('sentence.coming-soon-title') }}</h1>
                            <p>{{__('sentence.coming-soon-desc1') }}</p>

                           <p>{{__('sentence.coming-soon-desc2') }}</p>
                            
                            <a href="{{ route('mexico-more-info') }}" title="">{{__('sentence.moreinfo') }}</a>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="banner-wrap">
                        <div class="banner-img" style="background-image: url('{{asset('public/frontend/images/more_info.jpg')}}');"></div>
                        <div class="banner-content">
                            <h1>{{__('sentence.banner-more-info-title') }}</h1>
                            <p>{{__('sentence.banner-more-info-desc') }}</p>
                            <a href="{{ route('mexico-more-info') }}" title="">{{__('sentence.moreinfo') }}</a>
                        </div>
                    </div>
                </div>              
                            
                <div>
                    <div class="banner-wrap">
                        <div class="banner-img" style="background-image: url('{{asset('public/frontend/images/chef-registration-bg-img.jpg')}}');"></div>
                        <div class="banner-content">
                            <h1>{{__('sentence.signtocook') }}</h1>
                            <p>{{__('sentence.signtocookdesc') }}</p>
                            <a href="{{ route('chef-sign-up') }}" title="">{{__('sentence.reg') }}</a>
                        </div>
                    </div>
                </div>
                 @endif                 
            </div>
            @endif
        </section>
        
        <section class="popular-sec">
            <div class="container">
                <div class="popular-wrap">                        
                    <div class="popular-heading">
                        <h2>Popular Near You</h2>
                    </div>                                   
                    <div class="popular-list-wrap">
                        @if(!$chefData->isEmpty())
                        @foreach ($chefData as $value)
                        @foreach($value->chefMenu as $m)                        
                        <div class="search-result-list">
                            <div class="search-result-box">                                
                                <span class="chef-name">{{$value->distance}} Miles</span>                                    
                                <div class="search-result-img-left">
                                    <a href="{{ route('chef-profile',$value->profile_id) }}">
                                        <div class="search-result-img" style="background-image: url('{{asset('public/frontend/images/menu/'.$m->photo)}}');">
                                        </div>
                                    </a>
                                </div>
                                <div class="search-result-content">
                                    <a href="{{ route('chef-profile',$value->profile_id) }}">
                                    <h5>{{$m->item_name}}</h5>  
                                    </a><br>                                    
                                    <span class="status-info">{{$m->status=='1'?"Available":"Not Available"}}</span>
                                    <span class="status-date">{{$schedule::sch($m->id)}}</span>
                                    @if($value->country_id==142)
                                    @php
                                    $tax= $m['rate'] * $taxes->service_fee_per /100 + $m['rate']; 
                                    $rate = $tax * $taxes->tax / 100 + $tax;
                                    @endphp
                                    <p class="price"><span class="price-val">{{!empty($currency)?$currency->symbol:''}}{{number_format($rate,2)}}</span></p>
                                    @else
                                    <p class="price"><span class="price-val">{{!empty($currency)?$currency->symbol:''}}{{$m->rate}}</span></p>
                                    @endif
                                </div>                                
                            </div>
                        </div>                    
                        @endforeach
                        @endforeach
                        @endif
                    </div>  
                    <div class="slider-nav"></div>
                    <div class="see-all">
                        <a href="{{url('search/menu/nearby/all')}}" title="">{{__('sentence.view-all')}}</a>
                    </div>                     
                </div>
            </div>
        </section>

         <section class="our-chef-sec">
            <div class="container">
                <div class="our-chef-wrap">
                    <div class="our-chef-heading">
                        <h2>{{__('sentence.our_chef') }}</h2>
                    </div>
                    <div class="our-chef-list-wrap">
                        @if(!$chefData->isEmpty())
                        @foreach ($chefData as $value)
                        <div class="our-chef-list">
                            <div class="our-chef-list-box">
                                <a href="{{ route('chef-profile',$value->profile_id) }}" title="">
                                <div class="our-chef-img" style="background-image: url('{{asset('public/frontend/images/users/'.$value->profile)}}');"></div>
                                </a>
                                <div class="our-chef-content">
                                    <h4>{{$value->display_name}}</h4>
                                    <span class='chef-cuisine'>{{__('sentence.cuisines')}}</span>
                                    @php
                                    $str = '';
                                    $myArray = explode(',', $value->chefBussiness->cuisine);
                                    foreach($cuisines as $c){
                                    if (in_array($c->id, $myArray)){
                                    $str=$str.$c->name;$str=$str.', ';
                                    }}                                    
                                    @endphp
                                    <span>{{rtrim($str,' ,')}}</span>
                                    <div class="rating">
                                    @for($i=1;$i<=5;$i++)
                                        @if(round($value->ratings->avg('chef_rating'))>=$i)
                                        <span class="fas fa-star checked"></span>
                                        @else
                                        <span class="far fa-star"></span>
                                        @endif
                                    @endfor
                                    </div>
                                    <a href="{{ route('chef-profile',$value->profile_id) }}" title="">{{__('sentence.viewprofile') }}</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                    {{ $chefData->links() }}
                </div>
            </div>
        </section>
        <section class="top-chef-sec">
            <div class="container">
                @if(!empty($topChef))
                <div class="top-chef-wrap">
                    <div class="top-chef-left">                     
                        <div class="top-chef-content">
                            <h3>{{__('sentence.topchef') }}</h3>
                            <h5>{{$topChef->display_name}}</h5>
                            <p>{{$topChef->chefBussiness->description}}</p>
                            <span class='chef-cuisine'>{{__('sentence.cuisines')}}</span>
                            @php
                            $str = '';
                            $myArray = explode(',', $topChef->chefBussiness->cuisine);
                            foreach($cuisines as $c){
                                if (in_array($c->id, $myArray)){
                                    $str=$str.$c->name;
                                    $str=$str.', ';
                                }
                            }                                    
                            @endphp
                            <span>{{rtrim($str,' ,')}}</span>
                            <div class="rating">
                            @for($i=1;$i<=5;$i++)
                                @if(round($topChef->ratings->avg('chef_rating'))>=$i)
                                    <span class="fas fa-star checked"></span>
                                @else
                                    <span class="far fa-star"></span>
                                @endif
                            @endfor
                            </div>
                            <a href="{{ route('chef-profile',$topChef->profile_id) }}" title="">{{__('sentence.viewprofile') }}</a>
                        </div>                        
                    </div>
                    <div class="top-chef-right">
                        @php $profile = $topChef['profile'] @endphp
                        <div class="top-chef-img" style="background-image: url({{asset('public/frontend/images/users/'.$profile)}});">
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </section>
        
       
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
                                        
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                        @endif
                    </div>   
                    <div class="all-categories-btn">
                        <a href="{{ route('all-category') }}" title="">{{__('sentence.view-all')}}</a>
                    </div>
                </div>
            </div>
        </section>
        <section class="oriental-taste-sec">
            <div class="container">
                <div class="oriental-taste-wrap">
                    <div class="oriental-taste-top">
                        <div class="oriental-taste-left">
                            <div class="oriental-taste-img">
                                <img src="{{asset('public/frontend/images/oriental-taste.png')}}" alt="">
                            </div>
                        </div>
                        <div class="oriental-taste-right">
                            <div class="oriental-taste-content">
                                <h2>{{__('sentence.orientaltest') }}</h2>
                                <p>{{__('sentence.orientaltestdesc') }} </p>
                                <a href="{{url('search/menu/Oriental/Oriental')}}" title="">{{__('sentence.ordernow') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="discover-sec">
                        <div class="discover-heading">
                            <h2>{{__('sentence.discover') }}</h2>
                            <p>{{__('sentence.discoverdesc') }} </p>
                        </div>
                        <div class="discover-step-sec">
                            <ul>
                                <li>
                                    <div class="discover-step-circle">
                                        <a href="#" title="">
                                            <div class="discover-step-content">
                                                <img src="{{asset('public/frontend/images/search-meal-icon.png')}}" alt="">
                                                <h4>{{__('sentence.searchnm') }}</h4>
                                                <span>{{__('sentence.meals') }}</span>
                                            </div>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <div class="discover-step-circle">
                                        <a href="#" title="">
                                            <div class="discover-step-content">
                                                <img src="{{asset('public/frontend/images/explore-chef-icon.png')}}" alt="">
                                                <h4>{{__('sentence.explore') }}</h4>
                                                <span>{{__('sentence.chef') }}</span>
                                            </div>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <div class="discover-step-circle">
                                        <a href="#" title="">
                                            <div class="discover-step-content">
                                                <img src="{{asset('public/frontend/images/order-favourite-icon.png')}}" alt="">
                                                <h4>{{__('sentence.order') }}</h4>
                                                <span>{{__('sentence.favorites') }}</span>
                                            </div>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <div class="discover-step-circle">
                                        <a href="#" title="">
                                            <div class="discover-step-content">
                                                <img src="{{asset('public/frontend/images/enjoy-order-icon.png')}}" alt="">
                                                <h4>{{__('sentence.enjoy') }}</h4>
                                                <span>{{__('sentence.order') }}</span>
                                            </div>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="advertise-sec" style="background-image: url('{{asset('public/frontend/images/app-advertisement.jpg')}}');">
            <div class="advertise-wrap">
                <div class="advertise-left">
                    <img src="{{asset('public/frontend/images/mobile-graphic.png')}}">
                </div>
                <div class="advertise-right">
                    <a href="https://play.google.com/store/apps/details?id=com.app.prepbychef1s" title="">
                        <img src="{{asset('public/frontend/images/google-play-icon.png')}}">
                    </a>
                    <a href="#" title="">
                        <img src="{{asset('public/frontend/images/app-store-icon.png')}}">
                    </a>
                </div>
            </div>
        </section>
        
@endsection
@section('pagescript')
    <script>
        document.addEventListener("DOMContentLoaded", function(event) { 
            var scrollpos = localStorage.getItem('scrollpos');
            if (scrollpos) window.scrollTo(0, scrollpos);
        });

        window.onbeforeunload = function(e) {
            localStorage.setItem('scrollpos', window.scrollY);
        };
    </script>
    
@endsection