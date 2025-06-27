
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
                        <li class="only-mob">
                            <a href="{{ route('customer-sign-in') }}" title="">{{__('sentence.custsignin') }}</a>
                        </li>
                        <li class="only-mob">
                            <a href="{{ route('customer-sign-up') }}" title="">{{__('sentence.custsignup') }}</a>            
                        </li>
                        @if(session()->has('type')!='Chef')                                
                        <li class="only-desktop">
                            <a href="javascript:;" title="">{{__('sentence.signin') }}</a>
                            <ul>
                               {{--  <li>
                                    <a href="{{ route('customer-sign-in') }}" title="">{{__('sentence.custsignin') }}</a>
                                </li> --}}
                                <li>
                                    <a href="{{ route('chef-sign-in') }}" title="">{{__('sentence.chefsignin') }}</a>                        
                                </li>                                        
                            </ul>
                        </li>
                        <li class="only-desktop">
                            <a href="javascript:;" title="">{{__('sentence.signup') }}</a>
                            <ul>
                                {{-- <li>
                                    <a href="{{ route('customer-sign-up') }}" title="">{{__('sentence.custsignup') }}</a>            
                                </li> --}}
                                <li>
                                    <a href="{{ route('chef-sign-up') }}" title="">{{__('sentence.chefsignup') }}</a>
                                </li>
                            </ul>
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
                        @endif
                        @if(session()->has('type')=='Chef')
                        <li>
                            <a href="{{ route('chef-dashboard') }}" title="">{{__('sentence.dashboard') }}</a>
                        </li> 
                        <li>
                            <a href="{{ route('clogout') }}" title="">{{__('sentence.logout') }}</a>
                        </li> 
                        @endif                              
                        <li>
                            <select onchange="location = this.options[this.selectedIndex].value;" class="selectbox">
                                <option value="{{ url('locale/en') }}" {{ session()->get('locale') == 'en' ? 'selected' : ''}}>English</option>
                                <option value="{{ url('locale/es') }}" {{ session()->get('locale') == 'es' ? 'selected' : '' }}>Espanol</option>                                 
                            </select>
                        </li>
                    </ul>   
                    <div class="header-location-wrap-mob"></div>                 
                </div>
            </div>
            

        </div>
    </div>
</div>
</header>


