@extends('frontend.layouts.app')
@section('content')
    @if(!empty($menu))
    <section class="related-items">
        <div class="container">
            <div class="related-wrap">
                <div class="related-heading">
                    <h2>{{$menu[0]['item_category']}}</h2>
                </div>
                <div class="related-item-list-wrap">
                    @foreach($menu as $item)
                    <div class="related-item-list">
                        <a href="{{ route('chef-profile',$item['chef_id']) }}" title="">
                            <div class="related-item-list-img" style="background-image: url('{{asset('public/frontend/images/menu/'.$item['photo'])}}');"></div>
                            <div class="related-item-list-content">
                                <small>Vishal Patel</small>
                                <h5>{{$item['item_name']}}</h5>
                                <p>${{$item['rate']}}</p>
                                <div class="rating">
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star"></span>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach                    
                </div>
            </div>
        </div>
    </section>            
    @endif
               
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