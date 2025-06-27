@php
$schedule = new \App\Model\Schedule;
@endphp
@extends('frontend.layouts.app')

@section('pageCss')
<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend/css/magnific-popup.css')}}">
@endsection
@section('content')

<section class="chef-profile-sec">
    <div class="chef-profile-wrap">
        <div class="chef-profile-left">
            <div class="mob-chef-profile-btn">{{__('sentence.chefprofile') }}</div>
            <div class="chef-profile-sidebar">
                <div class="chef-profile-img"
                style="background-image: url('{{asset('public/frontend/images/users/'.$chefData->profile)}}');">
            </div>
            <div class="chef-profile-info">
                <h4>
                    {{!empty($chefData->display_name)?$chefData->display_name:''}}
                    @if(auth('front')->check() && auth('front')->user()->type == "Customer")
                    <a href="#message-popup" data-id="{{Crypt::encrypt($chefData->profile_id)}}" title="" class="message-modal"><i class="far fa-envelope"></i></a>
                    @endif
                </h4>
            </div>
            <div class="rating">
                <a href="#rating-popup" title="" class="popup-modal">

                    @for($i=1;$i<=5;$i++)
                        @if(round($chefAvgRating)>=$i)
                        <span class="fas fa-star checked"></span>
                        @else
                        <span class="far fa-star"></span>
                        @endif
                    @endfor

                    <h5>{{round($chefAvgRating)}} {{__('sentence.outof') }} <span>{{$chefNoOfRating}} {{__('sentence.ratings') }}</span></h5>
                    <small>{{__('sentence.ratingdesc') }}</small>
                </a>
            </div>
            <div class="chef-desc">
                <p>{{!empty($chefBusiness->description)?ucfirst($chefBusiness->description):''}}</p>
            </div>
            <div id="rating-popup" class="mfp-hide white-popup-block">
                <div class="rating-popup">
                    <div class="rating-popup-tab">
                        <ul class="resp-tabs-list hor_1">
                            <li class="resp-tab-active">{{__('sentence.topr') }}</li>
                            <li>{{__('sentence.mostr') }}</li>
                        </ul>
                        <div class="resp-tabs-container hor_1">
                            <div class="resp-tab-content-active">
                                <div class="review-list-box">
                                    <ul>
                                        @if(!$chefReview->isEmpty())
                                        @foreach($chefReview as $r)
                                        <li>
                                            <div class="autor-sec">
                                                <div class="autor-img" style="background-image: url('{{asset('public/frontend/images/users/'.$r->user->profile)}}');"></div>
                                                <div class="autor-title">
                                                    <h4>{{$r->user->display_name}}</h4>

                                                </div>
                                            </div>

                                            <div class="rating">
                                                @for($i=1;$i<=5;$i++)
                                                @if(round($r->chef_rating)>=$i)
                                                <span class="fas fa-star checked"></span>
                                                @else
                                                <span class="far fa-star"></span>
                                                @endif
                                                @endfor
                                            </div>
                                            <div class="reviewed-date">
                                                <span>{{__('sentence.reviewon') }} {{date('F d, Y',strtotime($r->updated_at))}}</span>
                                            </div>
                                            <div class="reviewed-content">
                                                <p>{{$r->chef_review}}</p>
                                            </div>
                                        </li>
                                        @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div>
                                <div class="review-list-box">
                                    <ul>
                                        @if(!$chefRecentReview->isEmpty())
                                        @foreach($chefRecentReview as $r)
                                        <li>
                                            <div class="autor-sec">
                                                <div class="autor-img" style="background-image: url('{{asset('public/frontend/images/users/'.$r->user->profile)}}');"></div>
                                                <div class="autor-title">
                                                    <h4>{{$r->user->display_name}}</h4>
                                                </div>
                                            </div>

                                            <div class="rating">
                                                @for($i=1;$i<=5;$i++)
                                                @if(round($r->chef_rating)>=$i)
                                                <span class="fas fa-star checked"></span>
                                                @else
                                                <span class="far fa-star"></span>
                                                @endif
                                                @endfor
                                            </div>
                                            <div class="reviewed-date">
                                                <span>{{__('sentence.reviewon') }} {{date('F d, Y',strtotime($r->created_at))}}</span>
                                            </div>
                                            <div class="reviewed-content">
                                                <p>{{$r->chef_review}}</p>
                                            </div>
                                        </li>
                                        @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="location-sec">
                <h5>{{__('sentence.location') }} </h5>
                @if(!empty($chefLocation))
                <span>{{$chefLocation->city->name}}, {{$chefLocation->state->name}}, {{$chefData->country->name}}
                </span>
                @endif
            </div>
            @if(!empty($chefPicDel))
            <div class="service-sec">
                <h5>{{__('sentence.services') }} </h5>
                {{-- <span>{{$chefPicDel->options==1?__('sentence.pickonly'):$chefPicDel->options==2?__('sentence.pickanddil'):__('sentence.delonly')}}
                </span> --}}
            </div>
            @endif
            @if(!$chefCuisine->isEmpty())
            <div class="chef-description">
                <h5>{{__('sentence.cuisines') }} </h5>
                <ul>
                    @foreach($chefCuisine as $value)
                    <li>{{$value->name}}</li>
                    @endforeach

                </ul>
            </div>
            @endif
            @if(!$chefMainCategory->isEmpty())
            <div class="chef-description services">
                <h5>{{__('sentence.category') }}</h5>
                <ul>
                 @foreach($chefMainCategory as $value)
                 <li>
                    {{$value->item_category}}
                </li>
                @endforeach
                </ul>
            </div>
            @endif
            @if(!$certiData->isEmpty())
            <div class="chef-certificate">
                <h5>{{__('sentence.certi') }}</h5>
                <div class="certificate-list">
                    <ul>
                        @foreach ($certiData as $value)
                        <li>
                            <h6>{{ucwords($value->certi_name)}}</h6>
                            <span>{{$value->certi_from}} - {{$value->certi_to}}</span>
                            @if(!empty($value->image))
                            <img src="{{asset('public/frontend/images/certificate/'.$value->image)}}">
                            @endif
                            <h6><br><span class="fa fa-certificate" aria-hidden="true"> Certificate URL: <a href="{{$value->certi_url}}" style="color:white;font-size: 12px">Click Here</a></span></h6>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
            <div class="page-link-btn">
                @if(!empty($chefData))
                @if($chefVideoCount > 0)
                <a href="{{ route('chef-profile.video',$chefData->profile_id) }}" title="">Videos</a>
                @endif
                @if($chefBlogCount > 0)
                <a href="{{ route('chef-profile.blog',$chefData->profile_id) }}" title="">{{__('sentence.readb') }}</a>
                @endif
                @endif
            </div>

        </div>
    </div>
    <div class="chef-profile-right">
        @if($gelleryData->isNotEmpty())
        <div class="gallery-slider">
            @foreach($gelleryData as $gData)
            <div>
                <a href="{{asset('public/frontend/images/gellery/'.$gData->filename)}}" title="">
                    <div class="gallery-img" style="background-image: url('{{asset('public/frontend/images/gellery/'.$gData->filename)}}');"></div>
                </a>
            </div>
            @endforeach
        </div>
        @endif
        <div class="chef-search-result">
            <div class="chef-search-menu" id="parentHorizontalTab">
                <ul class="resp-tabs-list hor_1">
                    @foreach($chefMainCategory as $value)
                    <li>
                        {{$value->item_category}}
                    </li>
                    @endforeach
                </ul>
                <div class="resp-tabs-container hor_1">
                    @foreach($mainCategory as $mainCat)
                    <div>
                        <div id="ChildVerticalTab_1" class="ChildVerticalTab_1">
                            <ul class="resp-tabs-list ver_1">
                                @foreach($mainCat['subcategory'] as $subCat)
                                <li>{{ucfirst($subCat)}}</li>
                                @endforeach

                            </ul>
                            <div class="resp-tabs-container ver_1">
                                @foreach($mainCat['items'] as $itm)
                                <div>
                                    <div class="search-result-list-main">
                                        @foreach($itm as $i)
                                        <div class="search-result-list">
                                            <!-- start item -->
                                            <div class="search-result-box chef-profile-box">
                                                <div class="search-result-img" style="background-image: url('{{asset('public/frontend/images/menu/'.$i->photo)}}');">
                                                </div>
                                                <div class="search-result-content">
                                                    <small>{{str_replace(["Blank,","Blank"],["",""],$i->dietary_restriction)}}</small>
                                                    <h5>{{$i->item_name}}</h5>
                                                    <span class="status-info">{{$i['status']=="1"?"Available":"Not Available"}} </span> <span class="status-date">{{$schedule::sch($i->id)}}</span>

                                                    @if($chefData->country_id==142)
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
                                                    </div>
                                                    <div class="cart-btn">
                                                        <a href="#cart-form{{$i['id']}}" option-id="{{$i['id']}}" id="item-option-data" title="" class="popup-with-form">{{__('sentence.select') }}</a>
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
                                                <!-- start add Cart  -->
                                                <div id="cart-form{{$i['id']}}"  class="white-popup-block mfp-hide">

                                                    <div class="popup-wrap">
                                                        <h5>{{$i['item_name']}}</h5>
                                                        <h6>{{$i['item_description']}}</h6>
                                                        <div class="popup-product-img-wrap">
                                                            <a href="#popup-product-img{{$i['id']}}" title="" class="popup-product-img popup-with-form" style="background-image: url('{{asset('public/frontend/images/menu/'.$i->photo)}}');"></a>
                                                        </div>
                                                        <div id="popup-product-img{{$i['id']}}" class="white-popup-block mfp-hide">
                                                            <img src="{{asset('public/frontend/images/menu/'.$i->photo)}}">
                                                        </div>

                                                        {{ Form::open(['url' => route('option-cart'), 'method'=>'POST', 'files'=>true, 'id' => 'cart-form'.$i->id,"autocomplete"=>"off"]) }}
                                                        <input type="hidden" name="menu_id" value="{{$i->id}}">
                                                        <div class="addon-sec">

                                                            @if($i->menuOptions->isNotEmpty())

                                                                @foreach($groups as $g)

                                                                <ul>
                                                                    @php $flag=1; @endphp
                                                                    @foreach($i->menuOptions as $opt)

                                                                        @if($g->id == $opt->group_id)

                                                                            @if($flag==1)

                                                                                <h6 >{{$g->group_name}}
                                                                                    {{(($g->option=='M' && $g->required=="1")or($g->option=='S' && $g->required=="1"))?"(Required)":""}}
                                                                                    <span class="msg"></span>
                                                                                </h6>
                                                                                @php $flag=0; @endphp
                                                                            @endif
                                                                            @if($g->option=='M' && $g->required=="1")
                                                                            <li>
                                                                                @if($chefData->country_id==142)
                                                                                   @php
                                                                                   $tax= $opt->rate * $taxes->service_fee_per /100 + $opt->rate;
                                                                                   $optionRate = $tax * $taxes->tax / 100 + $tax;
                                                                                   @endphp
                                                                                    <div class="checkbox-wrap">
                                                                                        <input type="checkbox" name="rcheckboxes{{$opt->group_id}}[]" class="checkbox price-field" data-price="{{$optionRate}}" value="{{$opt->id}}" required="">
                                                                                        <label>{{$opt->option}}</label>
                                                                                    </div>
                                                                                    <div class="offer-price">
                                                                                        <span>
                                                                                            @if($optionRate != 0)
                                                                                            {{!empty($currency)?$currency->symbol:''}} {{$optionRate}}</span>
                                                                                            @endif
                                                                                    </div>
                                                                                @else
                                                                                    <div class="checkbox-wrap">
                                                                                        <input type="checkbox" name="rcheckboxes{{$opt->group_id}}[]" class="checkbox price-field" data-price="{{$opt->rate}}" value="{{$opt->id}}" required="">
                                                                                        <label>{{$opt->option}}</label>
                                                                                    </div>
                                                                                    <div class="offer-price">
                                                                                        <span>
                                                                                            @if($opt->rate != 0)
                                                                                            {{!empty($currency)?$currency->symbol:''}} {{$opt->rate}}</span>
                                                                                            @endif
                                                                                    </div>
                                                                                @endif
                                                                            </li>
                                                                            @elseif($g->option=='S' && $g->required=="1")
                                                                            <li>
                                                                                @if($chefData->country_id==142)
                                                                                    @php
                                                                                        $tax= $opt->rate * $taxes->service_fee_per /100 + $opt->rate;
                                                                                        $optionRate = $tax * $taxes->tax / 100 + $tax;
                                                                                    @endphp
                                                                                    <div class="radiobox-wrap">
                                                                                        <input type="radio" name="rradio{{$opt->group_id}}[]" class="radiobox price-field" data-price="{{$optionRate}}" value="{{$opt->id}}" required="">
                                                                                        <label>{{$opt->option}}</label>
                                                                                    </div>
                                                                                    <div class="offer-price">
                                                                                        <span>
                                                                                            @if($optionRate != 0)
                                                                                            {{!empty($currency)?$currency->symbol:''}} {{$optionRate  }}</span>
                                                                                            @endif
                                                                                    </div>
                                                                                @else
                                                                                    <div class="radiobox-wrap">
                                                                                        <input type="radio" name="rradio{{$opt->group_id}}[]" class="radiobox price-field" data-price="{{$opt->rate}}" value="{{$opt->id}}" required="">
                                                                                        <label>{{$opt->option}}</label>
                                                                                    </div>
                                                                                    <div class="offer-price">
                                                                                        <span>
                                                                                            @if($opt->rate != 0)
                                                                                            {{!empty($currency)?$currency->symbol:''}} {{$opt->rate  }}</span>
                                                                                            @endif
                                                                                    </div>
                                                                                @endif
                                                                            </li>
                                                                            @elseif($g->option=='M' && $g->required=="0")
                                                                            <li>
                                                                                @if($chefData->country_id==142)
                                                                                    @php
                                                                                      $tax= $opt->rate * $taxes->service_fee_per /100 + $opt->rate;
                                                                                      $optionRate = $tax * $taxes->tax / 100 + $tax;
                                                                                    @endphp
                                                                                    <div class="checkbox-wrap">
                                                                                        <input type="checkbox" name="nrcheckboxes[]" class="checkbox price-field" data-price="{{$optionRate}}" value="{{$opt->id}}">
                                                                                        <label>{{$opt->option}}</label>
                                                                                    </div>
                                                                                    <div class="offer-price">
                                                                                        <span>
                                                                                         @if($optionRate != 0)
                                                                                         {{!empty($currency)?$currency->symbol:''}} {{$optionRate}}</span>
                                                                                         @endif
                                                                                     </div>
                                                                                @else
                                                                                    <div class="checkbox-wrap">
                                                                                        <input type="checkbox" name="nrcheckboxes[]" class="checkbox price-field" data-price="{{$opt->rate}}" value="{{$opt->id}}">
                                                                                        <label>{{$opt->option}}</label>
                                                                                    </div>
                                                                                    <div class="offer-price">
                                                                                        <span>
                                                                                         @if($opt->rate != 0)
                                                                                         {{!empty($currency)?$currency->symbol:''}} {{$opt->rate}}</span>
                                                                                         @endif
                                                                                     </div>
                                                                                @endif
                                                                            </li>
                                                                            @else
                                                                            <li>
                                                                                @if($chefData->country_id==142)
                                                                                    @php
                                                                                      $tax= $opt->rate * $taxes->service_fee_per /100 + $opt->rate;
                                                                                      $optionRate = $tax * $taxes->tax / 100 + $tax;
                                                                                    @endphp
                                                                                    <div class="radiobox-wrap">
                                                                                        <input type="radio" name="nrradio[]" class="radiobox price-field" data-price="{{$optionRate}}" value="{{$opt->id}}">
                                                                                        <label>{{$opt->option}}</label>
                                                                                    </div>
                                                                                    <div class="offer-price">
                                                                                        @if($opt->rate != 0)
                                                                                        <span>{{!empty($currency)?$currency->symbol:''}} {{$optionRate}}</span>
                                                                                        @endif
                                                                                @else
                                                                                    <div class="radiobox-wrap">
                                                                                        <input type="radio" name="nrradio[]" class="radiobox price-field" data-price="{{$opt->rate}}" value="{{$opt->id}}">
                                                                                        <label>{{$opt->option}}</label>
                                                                                    </div>
                                                                                    <div class="offer-price">
                                                                                        @if($opt->rate != 0)
                                                                                        <span>{{!empty($currency)?$currency->symbol:''}} {{$opt->rate}}</span>
                                                                                        @endif
                                                                                    </div>
                                                                                @endif
                                                                            </li>
                                                                            @endif
                                                                        @endif
                                                                    @endforeach
                                                                 </ul>
                                                                 @endforeach
                                                                 @endif
                                                                 <div class="date-time-sec">
                                                                    <div class="date-time-wrap">
                                                                        <h6>{{__('sentence.availd') }}</h6>
                                                                        <ul>
                                                                            <li>
                                                                                <input type="hidden" class="hidden-schedule" value="{{$i->menuSchedule}}">
                                                                                <input type="text" class="datepicker form-control" name="available_date" placeholder="{{__('sentence.selectd') }}" required="">
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                    <div class="date-time-wrap">
                                                                        <h6>{{__('sentence.availt') }}</h6>
                                                                        <ul>
                                                                            <li>
                                                                                <input type="text" class="time form-control" name="available_time" placeholder="{{__('sentence.availt') }}" readonly="">
                                                                                <input type="hidden" class="start-time" name="start_time">
                                                                                <input type="hidden" class="end-time" name="end_time">
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <div class="instructions-sec">
                                                                    <h6>{{__('sentence.speint') }}</h6>
                                                                    <ul>
                                                                        <li>
                                                                            <textarea placeholder="{{__('sentence.leavenote') }}" name="instruction"></textarea>
                                                                        </li>
                                                                    </ul>
                                                                </div>

                                                            </div>
                                                            <div class="addto-cart-bottom">
                                                                <div class="product-counter">
                                                                    <a href="javascript:void(0)" title="" class="minus">
                                                                        <i class="fas fa-minus"></i></a>
                                                                        <input type="hidden" class="hidden-count" value="{{$i->minimum_order}}" />
                                                                        <input type="hidden" class="qty" name="qty" value="{{$i->minimum_order}}">
                                                                        <span class="count">{{$i->minimum_order}}</span>
                                                                        <a href="javascript:void(0)" title="" class="plus">
                                                                            <i class="fas fa-plus"></i></a>
                                                                        </div>
                                                                        <div class="addto-cart-btn">
                                                                            <input type="submit" value="{{__('sentence.addtocart') }}" class="addto-cart" >
                                                                        </div>
                                                                        @if($chefData->country_id==142)
                                                                            <div class="cart-total">
                                                                                <input type="hidden" class="hidden-aggre" value="{{$rate}}" />
                                                                                <h6><span>{{__('sentence.total') }}:
                                                                                {{!empty($currency)?$currency->symbol:''}} <span class="aggre">{{$rate * $i->minimum_order}}</span></h6></span>
                                                                            </div>
                                                                        @else
                                                                            <div class="cart-total">
                                                                                <input type="hidden" class="hidden-aggre" value="{{$i->rate}}" />
                                                                                <h6><span>{{__('sentence.total') }}:
                                                                                {{!empty($currency)?$currency->symbol:''}} <span class="aggre">{{$i->rate*$i->minimum_order}}</span></h6></span>
                                                                            </div>
                                                                        @endif
                                                                       </div>
                                                                       {{ Form::close() }}
                                                                   </div>
                                                               </div>
                                                               <!-- end add Cart  -->
                                                           </div>
                                                           <!-- end item -->
                                                       </div>
                                                       @endforeach
                                                   </div>
                                               </div>
                                               @endforeach
                                           </div>
                                       </div>
                                   </div>
                                   @endforeach
                               </div>
                           </div>
                       </div>

                    </div>
                </div>
        </section>

        <div id="message-popup" class="mfp-hide white-popup-block">
            <div class="message-popup-wrap">
                <h4>Message to Chef</h4>
                <div class="form-main">
                    {{ Form::open(['url' => route('cust.message'), 'method'=>'POST', 'files'=>true, 'name' => 'frmMessage', 'id' => 'frmMessage','class'=>"form-main"]) }}
                    <label>Message</label>
                    <textarea name="message"></textarea>
                    <input type="hidden" id="profile_id" name="profile_id">
                    <button type="submit" id="btnSubmit" name="btnSubmit">Send</button>
                    {{ Form::close() }}<br>
                    <div class="alert display-none alert-danger"></div>
                    <div class="alert display-none alert-success"></div>
                </div>
            </div>
        </div>

        @endsection
        @section('pagescript')


        <script type="text/javascript" src="{{ asset('public/frontend/js/jquery.magnific-popup.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('public/frontend/js/easy-responsive-tabs.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('public/backend/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.css')}}">
        <script type="text/javascript" src="{{ asset('public/backend/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}"></script>
        <script type="text/javascript" src="{{ asset('public/frontend/js/pages/chef-profile.js')}}"></script>
        @endsection
