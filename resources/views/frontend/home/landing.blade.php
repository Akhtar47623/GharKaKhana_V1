<!DOCTYPE html>
<html lang="en">
<head>
    <title>Prep By Chef</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="format-detection" content="telephone=no">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('public/frontend/images/favicon.ico')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/css/responsive.css')}}" media="screen">
    <style>.error-help-block{color:red;}</style>
    <script> var BASEURL = '{{ url("/") }}/' </script>
</head>

<body>
    <header class="site-header">
        <div class="header-main">
            <div class="logo">
                <a href="{{ route('home') }}" title="">
                    <img src="{{asset('public/frontend/images/logo.png')}}" alt="">
                </a>
            </div>
            <div class="header-right">
                <div class="header-menu">
                    <div class="enumenu_ul">
                        <ul>
                            
                            <li>
                                <a href="javascript:;" title="">Sign in</a>
                                <ul>
                                    {{--<li>
                                        <a href="{{ route('customer-sign-in') }}" title="">Customer Sign In</a>
                                    </li> --}}
                                    <li>
                                        <a href="{{ route('chef-sign-in') }}" title="">Chef Sign In</a>                        
                                    </li>                                        
                                </ul>
                            </li>                        
                        </ul>                    
                    </div>
                </div>
                
            </div>
        </div>
    </header>
    <div class="wrapper">
        <section class="landing-sec" style="background-image: url({{asset('public/frontend/images/landing-page.jpg')}});">
            <div class="landing-top">
                <?php echo View::make('frontend.shared.glocation', ['displayLable' => true]) ?>
                <div class="location-link">
                <ul>
                    @if(!empty($countryName))
                    @foreach($countryName as $c)
                    <li>
                        <a href="javascript:void(0)" title="" class="countrylocation" data-id="{{$c->country_id}}">{{$c->country->name}}</a>
                    </li>
                    @endforeach
                    @endif
                </ul>
            </div>
            </div> 
            <!-- @if (!request()->cookie('accept-cookie')) 
            <div class="cookies-block">
                <div class="cookies-block-content">
                    <h5>This website uses cookies</h5>
                    <p>We use cookies to improve your experience and deliver personalised content. By using this website, you agree to our <a href="javascript:void()">Cookie Policy</a>.</p>
                    <button class="okay-btn">Allow Cookies</button>
                </div>
            </div>
            @endif -->    
                
        </section>
    </div>
    <script type="text/javascript" src="https://app.termly.io/embed.min.js" data-auto-block="on" data-website-uuid="90ac6305-05ab-4de0-91de-ecdb8728697d">
    </script>
    <script type="text/javascript" src="{{ asset('public/frontend/js/jquery.min.js')}}"></script>    
    <!-- <script type="text/javascript" src="{{ asset('public/frontend/js/general.js')}}"></script> -->
    <script type="text/javascript" src="{{ asset('public/frontend/js/menu.js')}}"></script>
    <script type="text/javascript" src="{{ asset('public/frontend/js/pages/landing.js')}}"></script>
    
</body>
</html>