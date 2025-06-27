<section class="mini-cart-sec">
    <div class="mini-cart-wrap">
        <div class="mini-cart-top active">
            <div class="mini-cart-expand-top">
                <h3>{{__('sentence.yourorder') }}</h3>
                <a href="javascript:;" title="" class="cart-close"><i class="fas fa-times"></i></a>
            </div>           
            <div class="cart-item-wrap">
                @if(session()->has('cart'))                         
                <div class="cart-items">
                    <?php $count = 1; ?>                
                    @foreach(session('cart') as $k=>$date)
                    <?php $i=1; $stotal=0;?>
                    <table>
                        <thead>
                            <tr>
                                <th></th>
                                <th>{{__('sentence.itemn') }}</th>
                                <th>{{__('sentence.availt') }}</th>                                
                                <th>{{__('sentence.qt') }}</th>
                                <th>{{__('sentence.rate') }}</th>
                                <th>{{__('sentence.itemt') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                         
                            @foreach($date as $id => $details)
                            @if($i==1)
                            <tr class="full-width">
                                <div class="cart-items-top-wrap">
                                    <span>{{__('sentence.order') }}: {{$count}}</span>
                                    <span>{{__('sentence.chefnm') }}: {{$details['chef_nm']}}</span>
                                    <span>{{ \Carbon\Carbon::parse($details['available_date'])->format('l d M, Y')}}</span>
                                </div>
                            </tr>
                            <?php $i=0; $count++;?> 
                            @endif 
                            <tr>                                
                                <td>
                                    <div class="cart-item-img">
                                        <img src="{{asset('public/frontend/images/menu/'.$details['photo'])}}" alt="">
                                    </div>
                                </td>
                                <td>
                                    <div class="cart-item-name">
                                        <h6>{{$details['item_name']}}</h6>
                                        <span>
                                            <?php $optionTotal=0; ?>
                                            @if($details['option']!=NULL)                                            
                                            @foreach($details['option'] as $option)
                                            <b>{{$option['group_name']}}:</b> {{$option['option']}}<br>
                                            <?php $optionTotal += $option['rate']?>
                                            @endforeach
                                            <br>{{__('sentence.adtotal') }}:  
                                            {{!empty($currency)?$currency->symbol:''}} {{$optionTotal}}    
                                            @endif
                                        </span>
                                    </div>
                                </td>
                                <td>{{$details['available_time']}}</td>                                
                                <td>
                                    <div class="cart-item-qty">                                        
                                        <select name="quantity" class="quantity" data-id="{{$id}}" onchange="changeQuantity(this,'{{$id}}');">
                                            @for($i=$details['minimum_order'];$i<=30;$i++)
                                            <option value={{$i}} 
                                            {{$i==$details['quantity']?"selected":""}}>{{$i}}</option>
                                            @endfor                                                
                                        </select>                                        
                                    </div>
                                </td>
                                <td>
                                   {{!empty($currency)?$currency->symbol:''}} {{$details['price']}}
                               </td>
                               <td>
                                <div class="cart-item-total">
                                    <span class="price"> 
                                        {{!empty($currency)?$currency->symbol:''}}
                                        
                                        {{number_format($details['quantity']*($details['price']+$optionTotal),2)}}
                                    </span>
                                    <?php $stotal+=$details['quantity']*($details['price']+$optionTotal) ?>
                                </div>
                            </td>
                            <td>
                                <div class="cart-item-edit">
                                    <a id="item" type="delete" title="Delete" rel="tooltip" class="remove delete"  data-id="{{ $id }}"  data-action="{{route('remove-from-cart')}}" data-message="{{Config::get('constants.message.confirm')}}"><i class="fas fa-times-circle"></i></a>
                                </div>
                            </td>
                        </tr>
                        
                        @endforeach
                        <tr>
                            <td colspan="5" class="align-right">{{__('sentence.subtotal') }}:</td>
                            <td colspan="1" style="border: 0;">
                                <h6>  
                                    {{!empty($currency)?$currency->symbol:''}} {{number_format($stotal,2)}}
                                </h6>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" class="align-right mini-cart-btn">
                                <a href="{{ route('clear-cart',date('m-d-Y', strtotime($k))) }}" title="">{{__('sentence.clearc') }}</a>
                                <!--<a href="{{ route('continue-cart',date('m-d-Y', strtotime($k))) }}" title="">{{__('sentence.conti') }}</a>-->
                            </td>
                        </tr>
                    </tbody>
                </table>
                @endforeach  
            </div>           
            @endif
            
        </div>
    </div>
    <div class="mini-cart-bottom">
        <div class="mini-cart-bottom-left">
            <a href="javascript:;" title="" class="expand-cart active"></a>
            <h4>{{__('sentence.yourorder') }} (<?php 
                $count = 0;
                if(session('cart')){
                    echo count(session('cart'));
                }else{
                    echo $count;
                }
                ?>)</h4>
            </div>
            <div class="mini-cart-bottom-right">
                <?php $subTotal=0.00; ?>                
                @if(session('cart'))
                @foreach(session('cart') as $date)
                @foreach($date as $id => $details)
                <?php $optionTotal=0; ?>
                @if($details['option']!=NULL)
                @foreach($details['option'] as $option)                    
                <?php $optionTotal += $option['rate']?>
                @endforeach    
                @endif
                <?php $subTotal += $details['quantity']*($details['price']+$optionTotal) ?>
                @endforeach
                @endforeach
                @endif
                <span>{{__('sentence.cartt') }}:
                    {{!empty($currency)?$currency->symbol:''}}
                {{number_format($subTotal,2)}}</span>
                <!--  <a href="{{ route('clear-cart','all') }}" title="">Clear Cart</a> -->
            </div>
        </div>
    </div>
</section>

@if(!empty($review))
<div class="review-rating-popup">
    <div class="review-rating-popup-wrap">
        <div class="review-rating-popup-heading">
            <center><h2>{{__('sentence.order') }}</h2></center>
        </div>
        <div class="order-info">
            <span>{{__('sentence.order') }} #{{$review->order_id}}</span>
            <!-- <h4>Pizza, Burger</h4> -->
        </div>

        <div class="order-info">
            <h4>{{__('sentence.hwym') }}</h4>
        </div>
        {{ Form::open(['url' => route('review.store'), 'method'=>'POST', 'files'=>true, 'name' => 'frmReview', 'id' => 'frmReview','class'=>"form-main"]) }}
        <input type="hidden" name="review_uuid" id="review_uuid" value="{{$review->uuid}}">
        <div class="order-rating">
            <span>{{__('sentence.rate') }}</span><span>{{$review->user->display_name}}</span>
            <div id="chef"></div>
        </div>
        <div class="review-info">
            <span>{{__('sentence.writer') }}</span>
            <textarea name="chef_review"></textarea>
        </div>

        @if($review->pick_del_option==2)
        <div class="order-info">
            <h4>{{__('sentence.hwad') }}</h4>
        </div>
        
        <div class="order-rating">
            <span>{{__('sentence.ratetd') }}</span>
            <div id="del"></div>
        </div>
        <div class="review-info">
            <span>{{__('sentence.writer') }}</span>
            <textarea name="del_review"></textarea>
        </div>
        @endif
        <div class="rating-btn">
            <button id="btnSubmit" type="submit">{{__('sentence.submit') }}</button>
            <button id="btnSkip" type="button" data-action="{{route('review.skip')}}">{{__('sentence.skip') }}</button>            
        </div>
        {{ Form::close() }}
    </div>
</div>
@endif

<footer class="footer-main">
    <div class="container">

                            
        <div class="footer-wrap">
            <div class="footer-top">
                <div class="footer-country footer-select">
                    @if(!empty(\App\Model\Helper::countryList()))
                    <select id="drpdwn-countrynm" class="selectbox">
                        @foreach(\App\Model\Helper::countryList() as $c)
                        <option value="{{$c->country_id}}" {{ session()->get('country_id') == $c->country_id ? 'selected' : ''}}>{{$c->country->name}}</option>
                        @endforeach
                    </select>
                    @endif       
                </div>
                
                <div class="footer-language footer-select">
                    <select class="selectbox" onchange="location = this.options[this.selectedIndex].value;">
                        <option value="{{ url('locale/en') }}" {{ session()->get('locale') == 'en' ? 'selected' : ''}}>English</option>
                        <option value="{{ url('locale/es') }}" {{ session()->get('locale') == 'es' ? 'selected' : '' }}>Español</option>                                 
                    </select>
                </div>
            </div>
            <div class="footer-left">
                <div class="footer-info">

                    <h3>Prep By Chef</h3>
                    <p>{{__('sentence.prepbychefdesc') }}</p>
                    <div class="footer-social">
                        <ul>
                            <li>
                                <a href="https://www.instagram.com/prepbychef_mexico/" title="" target="_blank">
                                    <img src="{{asset('public/frontend/images/instagram-icon.png')}}"  alt="">
                                </a>
                            </li>
                            <li>
                                <a href="https://www.facebook.com/Prep-By-Chef-Mexico-100972015670641" title="" target="_blank">
                                    <img src="{{asset('public/frontend/images/facebook-icon.png')}}" alt="">
                                </a>
                            </li>
                            {{-- <li>
                                <a href="#" title="">
                                    <img src="{{asset('public/frontend/images/twitter-icon.png')}}" alt="">
                                </a>
                            </li>
                            <li>
                                <a href="#" title="">
                                    <img src="{{asset('public/frontend/images/whatsapp-icon.png')}}" alt="">
                                </a>
                            </li> --}}
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer-right">
                <div class="footer-menu menu-one">
                    <h6>{{__('sentence.about') }}</h6>
                    <ul>
                        <!-- <li>
                            <a href="#" title="">{{__('sentence.history') }}</a>
                        </li>-->
                        <li>
                            <a href="{{ route('mexico-more-info') }}" title="">{{__('sentence.mexico-chef-reg-info')}}</a>
                        </li>
                        <li>
                            <a href="{{route('terms-condition')}}" title="">{{__('sentence.tandc') }}</a>
                        </li>
                        <li>
                            <a href="{{route('privacy')}}" title="">{{__('sentence.privacyp') }}</a>
                        </li>
                    </ul>
                </div>
                <!-- <div class="footer-menu menu-two">
                    <h6>{{__('sentence.services') }}</h6>
                    <ul>
                        <li>
                            <a href="#" title="">{{__('sentence.hto') }}</a>
                        </li>
                        <li>
                            <a href="#" title="">{{__('sentence.ourc') }}</a>
                        </li>                       
                    </ul>
                </div> -->
                <div class="footer-menu menu-two">
                    <h6>{{__('sentence.other') }}</h6>
                    <ul>
                        <li>
                            <a href="{{route('contactus')}}" title="">{{__('sentence.contactus') }}</a>
                        </li>
                        <li>
                            <a href="{{route('disclaimer')}}" title="">{{__('sentence.disclaimer') }}</a>
                        </li>                        
                    </ul>
                </div>
                
            </div>
        </div>
    </div>
</footer>


   
