@extends('frontend.layouts.app')
@section('pageCss')
<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend/css/magnific-popup.css')}}">

@endsection
@section('content')

<section class="search-result-sec">
    
    <div class="search-result-sec-wrap">
        
        <div class="search-result-top">
            <h4>{{__('sentence.searchrf') }}: {{!empty($search)?$search:"N/A"}}</h4>
            <div class="search-top-right">
                <h5>{{__('sentence.displayb') }}:</h5>
                {{ Form::select('sortby',['0'=>'Menu','1'=>'Chef'], $displayby,["required","id"=>"sortby","name"=>"sortby","onchange"=>"displayBy(this)"]) }}
            </div>
        </div>
        <div class="search-result-left">
            <div class="search-result-mob">Filter</div>
            <div class="search-result-mob-wrap">
                <div class="search-result-sidebar" id="menu-filter">
                    <div class="search-sidebar-list">
                        <h6>{{__('sentence.sortb') }}</h6>
                        <ul>
                            <li>
                                <a class="price" href="javascript:0"  data-href="{{ url()->current().'?'}}" data-order="asc"title="">{{__('sentence.pricelth') }}</a>
                            </li>
                            <li>
                                <a class="price" href="javascript:0"  data-href="{{ url()->current().'?'}}" data-order="desc" title="">{{__('sentence.pricehtl') }}</a>
                            </li>

                            <li>
                                <a class="recently" href="javascript:0" data-href="{{ url()->current().'?'}}" title="">{{__('sentence.recentlyadd') }}</a>
                            </li>
                             <li>
                                <a class="availability" href="javascript:0" data-href="{{ url()->current().'?'}}" title="">{{__('sentence.avail') }}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="clear-filter"><span >{{__('sentence.clearall') }}</span></div> 
                    <div class="search-sidebar-list price-range">
                        <h6>{{__('sentence.filter') }}</h6>
                        <ul>
                            <li class="sub-filter">
                                <span>{{__('sentence.price') }} :</span> <br><input type="text" id="amount" readonly>
                                <input type="hidden" id="currency" value="{{!empty($currency)?$currency->symbol:''}}">                         
                                <div id="slider-range"></div>

                            </li>
                            
                            <li class="categories-filter sub-filter">
                                <span>{{__('sentence.services') }}</span>
                                <ul>                               
                                    <li><a class="service" href="javascript:0"  data-href="{{ url()->current().'?'}}" data-service="pickup" title="">{{__('sentence.pick') }}</a></li>
                                    <li><a class="service" href="javascript:0"  data-href="{{ url()->current().'?'}}" data-service="delivery" title="">{{__('sentence.del') }}</a></li>                               
                                </ul>
                            </li>
                           
                            <li class="sub-filter">
                                <span>{{__('sentence.dist') }} :</span> <input type="text" id="miles" readonly>
                                                    
                                <div id="slider-range1"></div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="search-result-sidebar" id="chef-filter">
                <div class="search-sidebar-list">
                    <h6>{{__('sentence.sortb') }}</h6>
                    <ul>
                        <li>
                            <a class="popularity" href="javascript:0" data-href="{{ url()->current().'?'}}" title="">{{__('sentence.popularity') }}</a>
                        </li>

                        <li>
                            <a class="new-chef" href="javascript:0" data-href="{{ url()->current().'?'}}" title="">{{__('sentence.newc') }}</a>
                        </li>
                    </ul>
                </div>
                <div class="clear-filter"><span >{{__('sentence.clearall') }}</span></div> 
                <div class="search-sidebar-list">
                    <h6>{{__('sentence.filter') }}</h6>
                    <ul>

                        <li class="sub-filter">
                            <span class="sub-heading">{{__('sentence.rating') }}</span>
                            <a class="rate" href="javascript:0" data-href="{{ url()->current()}}" data-id="1">
                                <div class="rating">
                                    <span class="fas fa-star checked"></span>
                                    <span class="far fa-star"></span>
                                    <span class="far fa-star"></span>
                                    <span class="far fa-star"></span>
                                    <span class="far fa-star"></span> {{__('sentence.amore') }}
                                </div>
                            </a>
                            <a class="rate" href="javascript:0" data-href="{{ url()->current()}}" data-id="2">
                                <div class="rating">
                                    <span class="fas fa-star checked"></span>
                                    <span class="fas fa-star checked"></span>
                                    <span class="far fa-star"></span>
                                    <span class="far fa-star"></span>
                                    <span class="far fa-star"></span>  {{__('sentence.amore') }}
                                </div>
                            </a>
                            <a class="rate" href="javascript:0" data-href="{{ url()->current()}}" data-id="3">
                                <div class="rating">
                                    <span class="fas fa-star checked"></span>
                                    <span class="fas fa-star checked"></span>
                                    <span class="fas fa-star checked"></span>
                                    <span class="far fa-star"></span>
                                    <span class="far fa-star"></span>  {{__('sentence.amore') }}
                                </div>
                            </a>
                            <a class="rate" href="javascript:0" data-href="{{ url()->current()}}" data-id="4">
                                <div class="rating">
                                    <span class="fas fa-star checked"></span>
                                    <span class="fas fa-star checked"></span>
                                    <span class="fas fa-star checked"></span>
                                    <span class="fas fa-star checked"></span>
                                    <span class="far fa-star"></span>  {{__('sentence.amore') }}                                    
                                </div>
                            </a>

                        </li>
                        
                    </ul>
                </div>
            </div>
        </div>
        <div class="search-result-right">
             <div class="category-wrap">
                                                        
                    <div class="category-list-wrap">
                       @if(!$categories->isEmpty())
                       @foreach ($categories as $cat)
                        <div class="category-list">
                            <a href="{{url('search/menu/'.$cat->name.'/'.$cat->name)}}">
                                <div class="category-box">
                                    <div class="category-img" style="background-image: url('{{asset('public/backend/images/category/'.$cat->image)}}');"></div>
                                    <div class="category-content">
                                        <h4>{{$cat->name}}</h4>
                                                                                           
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                        @endif
                    </div>   
                    
                </div>
            <div class="search-result-list-wrap" id="menu-data">
                @forelse($menu as $i)
                <div class="search-result-list">
                    <div class="search-result-box">
                        <span class="chef-name"> {{__('sentence.chefnm') }} : {{$i->user->display_name}}</span>
                        <div class="search-result-img-left">
                            <div class="search-result-img" style="background-image: url('{{asset('public/frontend/images/menu/'.$i->photo)}}');"></div>
                            <span class="cat-name desk">{{$i->item_category}} > {{$i->item_type}}</span>
                            <div class="distance-val desk">
                                <span>{{isset($i['distance'])?$i['distance'].' Miles':''}}</span>
                            </div>
                        </div>
                        <div class="search-result-content">
                            <small>{{str_replace(["Blank,","Blank"],["",""],$i->dietary_restriction)}}</small>
                            <h5>{{$i->item_name}}</h5>
                            <span class="status-info">
                            {{$i['status']=="1"?"Available":"Not Available"}}</span>
                            <span class="status-date">{{date('M d, Y',strtotime($i->avilable_date))}}</span>
                            @if($i->user->country_id==142)
                                                     @php
                                                      $tax= $i['rate'] * $taxes->service_fee_per /100 + $i['rate']; 
                                                      $rate = $tax * $taxes->tax / 100 + $tax;
                                                    @endphp
                                                    <p class="price"> 
                                                        <span class="price-val">{{!empty($currency)?$currency->symbol:''}}{{number_format($rate,2)}}</span>
                                                        <span class="min-order">{{__('sentence.minio') }}: {{$i->minimum_order}}</span>
                                                    </p>
                                                    @else
                                                     <p class="price"> 
                                                        <span class="price-val">{{!empty($currency)?$currency->symbol:''}}{{$i['rate']}}</span>
                                                        <span class="min-order">{{__('sentence.minio') }}:{{$i->minimum_order}}</span>
                                                    </p>
                                                    @endif
                            
                            <div class="cart-btn">
                                
                                <a href="{{ route('chef-profile',$i->user->profile_id) }}" id="item-option-data" title="">{{__('sentence.view') }}</a>
                            </div>
                            <div class="link-btn-wrap">
                                @if(!empty($i->menuNutrition))
                                <div class="nutrition-link">
                                    <a href="#nutrition-popup{{$i['id']}}" class="popup-with-form nutrition-link">{{__('sentence.viewn') }}</a>
                                </div>
                                @endif
                                @if(!empty($i->label_photo))
                                <div class="menu-label-popup">
                                    <a href="{{asset('public/frontend/images/menu/'.$i['label_photo'])}}" title="" class="popup-with-form">{{__('sentence.menul') }}</a>
                                </div>
                                @endif
                                <span class="cat-name mob">{{$i->item_category}} > {{$i->item_type}}</span>
                                <div class="distance-val mob">
                                    <span>{{isset($i['distance'])?$i['distance'].' Miles':''}}</span>
                                </div>

                            </div>

                            @if(!empty($i->menuNutrition))
                            <div id="nutrition-popup{{$i['id']}}" class="nutrition-popup white-popup-block mfp-hide">
                                <div class="nutrition-wrap">
                                    <div class="nutrition-heading">
                                        <h4>Nutrition Facts</h4>
                                    </div>
                                    <div class="nutrition-contents">
                                        <ul>
                                            <li>
                                                <span>{{!empty($i->menuNutrition->service_per_container)?$i->menuNutrition->service_per_container:0}} Serving Per Container</span>
                                            </li>
                                            <li>
                                                <span><strong>Serving Size</strong></span>
                                                <span>
                                                    {{!empty($i->menuNutrition->quantity)?round($i->menuNutrition->quantity):0}} 
                                                    {{!empty($i->menuNutrition->units)?$i->menuNutrition->units:0}}
                                                    ({{!empty($i->menuNutrition->serving_size)?$i->menuNutrition->serving_size:0}} {{!empty($i->menuNutrition->serving_size_unit)?$i->menuNutrition->serving_size_unit:''}})
                                                </span>
                                            </li>
                                        </ul>
                                        <ul>
                                            <li>
                                                <span>Amount Per Services</span>
                                            </li>
                                            <li>
                                                <span style="font-size: 22px"><strong>
                                                Calories</strong></span>
                                                <span style="font-size: 22px">
                                                    {{!empty($i->menuNutrition->calories)?$i->menuNutrition->calories:0}}
                                                </span>
                                            </li>
                                        </ul>
                                        <ul>
                                            <li>
                                                <span></span>
                                                <span>% Daily Value*</span>
                                            </li>
                                            <li>
                                                <span><strong>Total Fat {{!empty($i->menuNutrition->total_fat)?$i->menuNutrition->total_fat.'g':'0g'}}</strong></span>
                                                <span>{{round($i->menuNutrition->total_fat*100/78) }}%</span>
                                            </li>
                                            <li>
                                                <span>Saturated Fat {{!empty($i->menuNutrition->saturated_fat)?$i->menuNutrition->saturated_fat.'g':'0g'}}</span>
                                                <span>{{round($i->menuNutrition->saturated_fat*100/20) }}%</span>
                                            </li>
                                            <li>
                                                <span>Trans Fat {{!empty($i->menuNutrition->trans_fat)?$i->menuNutrition->trans_fat.'g':'0g'}}</span>
                                                <span></span>
                                            </li>
                                            <li>
                                                <span><strong>Cholesterol</strong> {{!empty($i->menuNutrition->cholesterol)?$i->menuNutrition->cholesterol.'mg':'0mg'}}</span>
                                                <span>{{round($i->menuNutrition->cholesterol*100/300) }}%</span>
                                            </li>
                                            <li>
                                                <span><strong>Sodium </strong>{{!empty($i->menuNutrition->sodium)?$i->menuNutrition->sodium.'mg':'0mg'}}</span>
                                                <span>{{round($i->menuNutrition->sodium*100/2300) }}%</span>
                                            </li>
                                            <li>
                                                <span><strong>Total Carbohydrates</strong> {{!empty($i->menuNutrition->total_carbohydrates)?$i->menuNutrition->total_carbohydrates.'g':'0g'}}</span>
                                                <span>{{round($i->menuNutrition->total_carbohydrates*100/275) }}%</span>
                                            </li>
                                            <li>
                                                <span>Dietary Fiber {{!empty($i->menuNutrition->dietry_fiber)?$i->menuNutrition->dietry_fiber.'g':'0g'}}</span>
                                                <span>{{round($i->menuNutrition->dietry_fiber*100/28) }}%</span>
                                            </li>
                                            <li>
                                                <span>Total Sugars {{!empty($i->menuNutrition->sugars)?$i->menuNutrition->sugars.'g':'0g'}}</span>
                                                <span></span>
                                            </li>
                                            <li>
                                                <span>Added Sugar {{!empty($i->menuNutrition->added_sugar)?$i->menuNutrition->added_sugar.'g':'0g'}}</span>
                                                <span>{{round($i->menuNutrition->added_sugar*100/50) }}%</span>
                                            </li>
                                            <li>
                                                <span><strong>Protein</strong> {{!empty($i->menuNutrition->protein)?$i->menuNutrition->protein.'g':'0g'}}</span>
                                                <span>{{round($i->menuNutrition->protein*100/50) }}%</span>
                                            </li>
                                            <li>
                                                <span>Not significant source of cholesterol, vitamin D, calcium, iron, and potassium</span>
                                                <span>- The % Daily Value tells you how much a nutrient in a serving of food contributes to a daily diet. 2,000 calories a day is used for gneral nutrition advice.</span>

                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @endif                                      
                        </div>
                    </div>
                </div>
                
                @empty
                <h5><i class="fas fa-search"></i> No Result Found</h5>
                @endforelse
            </div>
            <div class="search-result-chef" id="chef-data">
                @if(!$chefData->isEmpty())
                @foreach ($chefData as $value)
                <div class="search-result-chef-list">
                    <a href="{{ route('chef-profile',$value->profile_id) }}" title="">
                        <div class="search-result-chef-img" style="background-image: url('{{asset('public/frontend/images/users/'.$value->profile)}}');"></div>
                    </a>
                    <div class="search-result-chef-content">
                        <h4>{{$value->display_name}}</h4>
                        @php
                        $str = '';
                        $myArray = explode(',', $value->chefBussiness->cuisine);
                        foreach($cuisines as $c){
                        if (in_array($c->id, $myArray)){
                        $str=$str.$c->name;$str=$str.', ';
                    }
                }                                    
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
        @endforeach
        @else
        <h5><i class="fas fa-search"></i> {{__('sentence.chefdn') }}</h5>
        @endif
    </div>
</div>
</div>
</section>

@endsection
@section('pagescript')
<script type="text/javascript" src="{{ asset('public/frontend/js/pages/search.js')}}"></script>
<script type="text/javascript" src="{{ asset('public/frontend/js/jquery.magnific-popup.min.js')}}"></script>
<script>
    
    $('.category-list-wrap').slick({
        slidesToShow: 10,
        slidesToScroll: 1,
        infinite: true,
        prevArrow: false,
    nextArrow: false,
        speed: 1200,
        autoplay: true,
        autoplaySpeed: 5000,
        responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 5,
            slidesToScroll: 1,
          }
        },
        {
          breakpoint: 640,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 1
          }
        }
      ]
    });
</script>
@endsection
