@extends('frontend.layouts.app')
@section('pageCss')
<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend/css/magnific-popup.css')}}">
@endsection
@section('content')


<section class="search-result-sec">
    <div class="search-result-sec-wrap">
        <div class="search-result-left">
            <div class="search-result-sidebar">
                <div class="search-sidebar-list">
                    <h6>Sort by</h6>
                    <ul>
                        <li>
                            <a href="#" title="">Popularity</a>
                        </li>
                        <li>
                            <a href="#" title="">Rating</a>
                        </li>
                        <li>
                            <a href="#" title="">Cost</a>
                        </li>
                        <li>
                            <a href="#" title="">Recently Added</a>
                        </li>
                    </ul>
                </div>
                <div class="search-sidebar-list">
                    <h6>Sort by</h6>
                    <ul>
                        <li>
                            <a href="#" title="">Popularity</a>
                        </li>
                        <li>
                            <a href="#" title="">Rating</a>
                        </li>
                        <li>
                            <a href="#" title="">Cost</a>
                        </li>
                        <li>
                            <a href="#" title="">Recently Added</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="search-result-right">
            <div class="search-result-top">
                <h4>Search Result For : test</h4>
            </div>
            <div class="search-result-list-wrap">
                <div class="search-result-list">
                    <div class="search-result-box">
                        <div class="search-result-img" style="background-image: url('{{asset('public/frontend/images/daniel-john.png')}}');"></div>
                        <div class="search-result-content">
                            <small>Fast Food</small>
                            <h5>Corn Pizza</h5>
                            <span class="status-info">Available</span>
                            <p class="price"> 
                                <span class="price-val">₹5.00</span>
                                <span class="min-order">Mini. Order:3</span>
                            </p>
                            <div class="link-btn-wrap">
                                <div class="nutrition-link">
                                    <a href="#nutrition-popup1" class="popup-with-form nutrition-link">View Nutrition</a>
                                </div>
                                <div class="menu-label-popup">
                                    <a href="http://localhost/homechef/public/frontend/images/menu/81539.jpg" title="" class="popup-with-form">Menu Label</a>
                                </div>
                            </div>
                            <div class="cart-btn">
                                <a href="#cart-form1" option-id="1" id="item-option-data" title="" class="popup-with-form">Add to Cart</a>
                            </div>                                       
                        </div>
                    </div>
                </div>
                <div class="search-result-list">
                    <div class="search-result-box">
                        <div class="search-result-img" style="background-image: url('{{asset('public/frontend/images/daniel-john.png')}}');"></div>
                        <div class="search-result-content">
                            <small>Fast Food</small>
                            <h5>Corn Pizza</h5>
                            <span class="status-info">Available</span>
                            <p class="price"> 
                                <span class="price-val">₹5.00</span>
                                <span class="min-order">Mini. Order:3</span>
                            </p>
                            <div class="link-btn-wrap">
                                <div class="nutrition-link">
                                    <a href="#nutrition-popup1" class="popup-with-form nutrition-link">View Nutrition</a>
                                </div>
                                <div class="menu-label-popup">
                                    <a href="http://localhost/homechef/public/frontend/images/menu/81539.jpg" title="" class="popup-with-form">Menu Label</a>
                                </div>
                            </div>
                            <div class="cart-btn">
                                <a href="#cart-form1" option-id="1" id="item-option-data" title="" class="popup-with-form">Add to Cart</a>
                            </div>                                       
                        </div>
                    </div>
                </div>
                <div class="search-result-list">
                    <div class="search-result-box">
                        <div class="search-result-img" style="background-image: url('{{asset('public/frontend/images/daniel-john.png')}}');"></div>
                        <div class="search-result-content">
                            <small>Fast Food</small>
                            <h5>Corn Pizza</h5>
                            <span class="status-info">Available</span>
                            <p class="price"> 
                                <span class="price-val">₹5.00</span>
                                <span class="min-order">Mini. Order:3</span>
                            </p>
                            <div class="link-btn-wrap">
                                <div class="nutrition-link">
                                    <a href="#nutrition-popup1" class="popup-with-form nutrition-link">View Nutrition</a>
                                </div>
                                <div class="menu-label-popup">
                                    <a href="http://localhost/homechef/public/frontend/images/menu/81539.jpg" title="" class="popup-with-form">Menu Label</a>
                                </div>
                            </div>
                            <div class="cart-btn">
                                <a href="#cart-form1" option-id="1" id="item-option-data" title="" class="popup-with-form">Add to Cart</a>
                            </div>                                       
                        </div>
                    </div>
                </div>
                <div class="search-result-list">
                    <div class="search-result-box">
                        <div class="search-result-img" style="background-image: url('{{asset('public/frontend/images/daniel-john.png')}}');"></div>
                        <div class="search-result-content">
                            <small>Fast Food</small>
                            <h5>Corn Pizza</h5>
                            <span class="status-info">Available</span>
                            <p class="price"> 
                                <span class="price-val">₹5.00</span>
                                <span class="min-order">Mini. Order:3</span>
                            </p>
                            <div class="link-btn-wrap">
                                <div class="nutrition-link">
                                    <a href="#nutrition-popup1" class="popup-with-form nutrition-link">View Nutrition</a>
                                </div>
                                <div class="menu-label-popup">
                                    <a href="http://localhost/homechef/public/frontend/images/menu/81539.jpg" title="" class="popup-with-form">Menu Label</a>
                                </div>
                            </div>
                            <div class="cart-btn">
                                <a href="#cart-form1" option-id="1" id="item-option-data" title="" class="popup-with-form">Add to Cart</a>
                            </div>                                       
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('pagescript')
<script src="{{asset('public/backend/common/jquery.validate.js')}}"></script>
<script type="text/javascript" src="{{ asset('public/frontend/js/pages/chef-profile.js')}}"></script>
<script type="text/javascript" src="{{ asset('public/frontend/js/jquery.magnific-popup.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('public/frontend/js/easy-responsive-tabs.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('public/backend/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.css')}}">    
<script type="text/javascript" src="{{ asset('public/backend/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}"></script>
@endsection
