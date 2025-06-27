
<header class="site-header">
            <div class="header-main">
                <div class="logo">
                    <a href="{{ route('home') }}" title="">
                        <img src="{{asset('public/frontend/images/logo.png')}}" alt="">
                    </a>
                </div>
                <div class="header-location-wrap">
                    <div class="header-location">
                    @php echo View::make('frontend.shared.glocation', ['displayLable' => false]) @endphp
                    </div>
                </div>
                <div class="header-right">
                    <div class="header-search">
                        <a href="javascript:;" title="">
                            <img src="{{asset('public/frontend/images/search-icon.png')}}" alt="">
                        </a>
                        <div class="header-search-wrap">
                            
                            <input type="text" autocomplete="off" id="search" class="form-control input-lg" style="background: url({{asset('public/frontend/images/favicon.ico')}}) no-repeat scroll 12px 11px; padding-left:40px;" placeholder="{{__('sentence.search') }}">
                        </div>
                                        
                    </div>
                    <div class="header-menu">
                        <div class="enumenu_ul">
                            <ul>
                                <li>
                                    <a href="{{ route('home') }}" title="">{{__('sentence.home') }}</a>
                                </li>          
                                
                                <li>                                   
                                    <a href="javascript:;" title="" class="cart-icon">{{__('sentence.cart') }} <span>
                                        <?php 
                                        $count = 0;
                                        if(session('cart')){
                                            foreach( session('cart') as $value){
                                                $count += count( $value);
                                            }
                                            echo $count;
                                        }else{
                                            echo $count;
                                        }
                                       ?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="" class="user-icon">
                                        <i class="fas fa-user-circle"></i>
                                        {{auth('front')->user()->display_name}}
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="{{route('customer.profile')}}" title="">{{__('sentence.mypro') }}</a>
                                        </li>
                                        <li>
                                            <a href="{{route('your.order')}}" title="">{{__('sentence.yourorder') }}</a>
                                        </li>   
                                        <li>
                                           <a href="javascript:;" title=""  class="messages-btn">{{__('sentence.msg') }}<span style="margin-left:3px;">{{ \App\Model\Helper::unreadOrderConversation()}}</span></a>
                                        </li>                                    
                                        <li>
                                            <a href="{{ route('wlogout') }}" title="">{{__('sentence.logout') }}</a>
                                        </li>                                        
                                    </ul>
                                </li>
                                <li>
                                    <select class="selectbox" onchange="location = this.options[this.selectedIndex].value;">
                                        <option value="{{ url('locale/en') }}" {{ session()->get('locale') == 'en' ? 'selected' : ''}}>English</option>
                                        <option value="{{ url('locale/es') }}" {{ session()->get('locale') == 'es' ? 'selected' : '' }}>Español</option>                                 
                                    </select>
                                </li>
                                
                            </ul>
                        </div>
                    </div>
                    {{-- <div class="header-search">
                        <a href="javascript:;" title="">
                            <img src="{{asset('public/frontend/images/search-icon.png')}}" alt="">
                        </a>
                        <div class="header-search-wrap">
                            
                            <input type="text" autocomplete="off" id="search" class="form-control input-lg" placeholder="{{__('sentence.search') }}">
                        </div>
                        <!-- <input type="search" placeholder="Search for chef, food, etc." name="search" id="search"> -->
                        <!-- <button type="submit" name="btnSubmit" id="btnSubmit"><img src="{{asset('public/frontend/images/search-icon.png')}}" alt=""></button> -->
                        
                    </div> --}}

                </div>
                </div>
    </div>
</header>
<section class="header-location-wrap-mob"></section>
@include('frontend.layouts.customer-chat') 

