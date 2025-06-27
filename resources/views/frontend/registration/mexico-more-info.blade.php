
@extends('frontend.layouts.app')
@section('content')    
<div class="wrapper">
        <section class="welcome-sec">
            <div class="welcome-wrap">
                <div class="welcome-left">
                    <div class="welcome-content">
                        <h1><span>{{__('sentence.welcome-to') }}</span> {{__('sentence.prep-by-chef') }} </h1>
                        <h6><span>{{__('sentence.PBC') }}</span> {{__('sentence.pbc-one') }} <br><br>{{__('sentence.pbc-two') }} <i>{{__('sentence.pbc-three') }}</i> {{__('sentence.pbc-four') }} <i>{{__('sentence.pbc-five') }}</i>{{__('sentence.pbc-six') }} {{__('sentence.pbc-seven') }} <span>{{__('sentence.pbc-eight') }}</span> {{__('sentence.pbc-nine') }}</h6>
                        <p>{{__('sentence.welcome-desc-two') }}</p><br>
                        <p>{{__('sentence.welcome-desc-three') }}</p><br>
                        <p>{{__('sentence.welcome-desc-four') }}</p>
                    </div>
                </div>
                <div class="welcome-right">
                    <img src="{{asset('public/frontend/images/welcome-graphic.png')}}" alt="">
                </div>
            </div>
        </section>

        <section class="four-box-sec">
            <div class="four-box-wrap">
                <div class="four-box-list-wrap">
                    <div class="four-box-list">
                        <div class="four-box-main">
                            <div class="four-box-icon">
                                <img src="{{asset('public/frontend/images/cooking-icon.svg')}}" alt="">
                            </div>
                            <h4>{{__('sentence.cooking-one') }}<br>{{__('sentence.cooking-two') }}</h4>
                        </div>
                    </div>
                    <div class="four-box-list">
                        <div class="four-box-main">
                            <div class="four-box-icon">
                                <img src="{{asset('public/frontend/images/own-boss-icon.svg')}}" alt="">
                            </div>
                            <h4>{{__('sentence.own-boss-one') }}<br>{{__('sentence.own-boss-two') }}</h4>
                        </div>
                    </div>
                    <div class="four-box-list">
                        <div class="four-box-main">
                            <div class="four-box-icon">
                                <img src="{{asset('public/frontend/images/earn-icon.svg')}}" alt="">
                            </div>
                            <h4>{{__('sentence.extra-inc-one') }}<br>{{__('sentence.extra-inc-two') }}</h4>
                        </div>
                    </div>
                    <div class="four-box-list">
                        <div class="four-box-main">
                            <div class="four-box-icon">
                                <img src="{{asset('public/frontend/images/process-icon.svg')}}" alt="">
                            </div>
                            <h4>{{__('sentence.order-pro-one') }}<br>{{__('sentence.order-pro-two') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <section class="benefits-sec">
            <div class="benefits-wrap">
                <div class="benefits-heading">
                    <h2>{{__('sentence.bene-of-joining') }}</h2>
                </div>
                <div class="benefits-list">
                    <ul>
                        <li>
                            <div class="benefits-icon">
                                <img src="{{asset('public/frontend/images/create-icon.svg')}}" alt="">
                            </div>
                            <h6>{{__('sentence.create-cust-menu-one') }}<br>{{__('sentence.create-cust-menu-two') }}</h6>
                        </li>
                        <li>
                            <div class="benefits-icon">
                                <img src="{{asset('public/frontend/images/own-business-icon.svg')}}" alt="">
                            </div>
                            <h6>{{__('sentence.run-ur-buss-one') }}<br>{{__('sentence.run-ur-buss-two') }}</h6>
                        </li>
                        <li>
                            <div class="benefits-icon">
                                <img src="{{asset('public/frontend/images/income-icon.svg')}}" alt="">
                            </div>
                            <h6>{{__('sentence.earn-extra-income-one') }}<br>{{__('sentence.earn-extra-income-two') }}</h6>
                        </li>
                        <li>
                            <div class="benefits-icon">
                                <img src="{{asset('public/frontend/images/new-people-icon.svg')}}" alt="">
                            </div>
                            <h6>{{__('sentence.conn-with-new-pep-one') }}<br>{{__('sentence.conn-with-new-pep-two') }}</h6>
                        </li>
                    </ul>
                </div>
            </div>
        </section>
        
        <section class="get-started-sec">
            <div class="get-started-wrap">
                <div class="get-started-heading">
                    <h2>{{__('sentence.get-started') }}</h2>
                    <h4>{{__('sentence.following') }}</h4>
                </div>
                <div class="get-started-list-wrap">
                    <div class="get-started-list">
                        <div class="get-started-box">
                            <div class="get-started-icon">
                                <img src="{{asset('public/frontend/images/rfc-icon.svg')}}" alt="">
                            </div>
                            <div class="get-started-content">
                                <h5>{{__('sentence.rfc-no') }}</h5>
                                <p>{{__('sentence.rfc-desc-one') }}<br>{{__('sentence.rfc-desc-two') }} <br>{{__('sentence.rfc-desc-three') }} <br>{{__('sentence.rfc-desc-four') }} <br>{{__('sentence.rfc-desc-five') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="get-started-list">
                        <div class="get-started-box">
                            <div class="get-started-icon">
                                <img src="{{asset('public/frontend/images/bank-icon.svg')}}" alt="">
                            </div>
                            <div class="get-started-content">
                                <h5>{{__('sentence.bank-acc') }}</h5>
                                <p>{{__('sentence.bank-acc-desc-one') }} <br>{{__('sentence.bank-acc-desc-two') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="get-started-list">
                        <div class="get-started-box">
                            <div class="get-started-icon">
                                <img src="{{asset('public/frontend/images/identification-icon.svg')}}" alt="">
                            </div>

                            <div class="get-started-content">
                                <h5>{{__('sentence.id-card') }}</h5>
                                <p>{{__('sentence.id-card-desc') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="more-info-sec">
                    <h5>{{__('sentence.more-info-contact') }}</h5>
                    <a href="mailto:Mexico@prepbychef.com" title="">Mexico@prepbychef.com</a>
                </div>
            </div>
        </section>

        <section class="welcome-signup-sec">
            <div class="welcome-signup-wrap">
                <div class="welcome-signup-content">
                    <h2>{{__('sentence.ready-for-signup') }}</h2>
                    <a href="{{ route('chef-sign-up') }}" title="">{{__('sentence.continue') }}</a>
                </div>
            </div>
        </section>
    </div>
@endsection

