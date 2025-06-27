<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>Prep By Chef</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="format-detection" content="telephone=no">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--css styles starts-->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('public/frontend/images/favicon.ico')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/css/all.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/css/responsive.css')}}" media="screen">
    <style>.error-help-block{color:red;}</style>
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/css/magnific-popup.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/css/jquery.mCustomScrollbar.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/css/chef_reg.css')}}">
    <script> var BASEURL = '{{ url("/") }}/' </script>
    <link href="http://fonts.cdnfonts.com/css/brittany-signature" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .Iframe-content-97a9de img {display: none;}
        .no-js #loader { display: none;  }
        .js #loader { display: block; position: absolute; left: 100px; top: 0; }


        #experties-input {
        padding: 8px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .chip-list {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        margin-top: 5px;
    }

    .chip {
        background-color: #e0e0e0;
        border-radius: 15px;
        padding: 5px 10px;
        display: flex;
        align-items: center;
        font-size: 14px;
    }

    .chip span {
        margin-left: 8px;
        cursor: pointer;
        font-weight: bold;
    }
    .form-wrap {
        display: flex;
        gap: 5px;
    }

    .chef-register-option {
    /* Add any necessary styling for the container */
}

.chef-option {
    position: relative; /* Needed for absolute positioning of pseudo-elements */
    margin-bottom: 10px; /* Add spacing between options */
}

.checkbox-tools {
    display: none; /* Hide the default radio button */
}

.for-checkbox-tools {
    display: flex;
    align-items: center; /* Align icon and text vertically */
    padding-left: 40px; /* Increased padding-left to create space */
    position: relative; /* Needed for absolute positioning of pseudo-elements */
    cursor: pointer; /* Change cursor to pointer on hover */
}

.for-checkbox-tools::before {
    content: '';
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 2px solid #ccc;
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
}

.for-checkbox-tools::after {
    content: '';
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background-color: #007bff;
    position: absolute;
    left: 5px;
    top: 50%;
    transform: translateY(-50%);
    display: none; /* Initially hidden */
}

.checkbox-tools:checked + .for-checkbox-tools::after {
    display: block; /* Show the dot when the radio button is checked */
}

.for-checkbox-tools i {
    margin-right: 10px; /* Add spacing between icon and text */
}

    </style>
</head>

<body>
    <div class="wrapper">
        <section class="login-sec registration-sec">
            <div class="login-wrap">
                <div class="login-left" style="background-image: url({{asset('public/frontend/images/chef-registration-bg-img1.jpg')}})"></div>
                <div class="login-right">
                    <div class="login-right-wrap">
                        <div class="login-logo">
                            <a href="{{ route('home') }}" title="">
                                <img src="{{asset('public/frontend/images/white-logo.png')}}">
                            </a>
                        </div>
                        <div class="login-title">
                            <h1>{{__('sentence.chefr') }}</h1>
                        </div>
                        <div class="login-top">
                            <div class="login-form-sec">
                                {{ Form::open(['url' => route('save-chef-registration'), 'method'=>'POST', 'files'=>true, 'name' => 'chefRegistration', 'id' => 'chefRegistration','class'=>"form-main"]) }}

                                <fieldset id="step1">
                                    <div class="note-content">
                                        <p>{{__('sentence.content-one')}}</p>
                                        <p>{{__('sentence.content-two')}}</p>
                                        <p>{{__('sentence.content-three-one')}}<br>
                                            {{__('sentence.content-three-two')}}<br>
                                            {{__('sentence.content-three-three')}}<br>
                                            {{__('sentence.content-three-four')}}<br>
                                            {{__('sentence.content-three-five')}}<br>
                                        </p>
                                    </div><br>
                                    <ul>
                                        <li>
                                            <div class="form-wrap">
                                                <label for="">{{__('sentence.country') }}<em>*</em></label>
                                                {{ Form::select('country',!empty($countries) ? $countries : [], old('country'),["required","class"=>"select2","placeholder"=>__('sentence.selcntry'),"id"=>"country","name"=>"country","style"=>"width:100%"]) }}
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-wrap">
                                                <label for="">{{__('sentence.state') }}<em>*</em></label>
                                                <select id="chef_state" name="chef_state" class="form-control select2" style="width:100%" required="">
                                                <option value="">{{__('sentence.selectstate') }}</option>
                                                </select>

                                            </div>
                                        </li>
                                        <li class="full-width">
                                            <div class="form-wrap">
                                                <button type="button" class="next" id="next">{{__('sentence.next') }}</button>
                                            </div>
                                        </li>
                                    </ul>
                                </fieldset>
                                <fieldset id="step2">
                                    <ul>
                                        <li class="">
                                            <div class="chef-register-option" id="typechef">
                                                <label for="">{{ __('sentence.typechef') }}</label>

                                                <div class="chef-option">
                                                    <input class="checkbox-tools" type="radio" name="user_type" id="tool-1" value="1" checked>
                                                    <label class="for-checkbox-tools" for="tool-1">
                                                        <i class="fa fa-home"></i>
                                                        {{ __('sentence.homec') }}
                                                    </label>
                                                </div>

                                                <div class="chef-option">
                                                    <input class="checkbox-tools" type="radio" name="user_type" id="tool-2" value="2">
                                                    <label class="for-checkbox-tools" for="tool-2">
                                                        <i class="fas fa-utensils"></i>
                                                        {{ __('sentence.catering') }}
                                                    </label>
                                                </div>

                                                <div class="chef-option">
                                                    <input class="checkbox-tools" type="radio" name="user_type" id="tool-3" value="3">
                                                    <label class="for-checkbox-tools" for="tool-3">
                                                        <i class="fa fa-truck"></i>
                                                        {{ __('sentence.foodt') }}
                                                    </label>
                                                </div>

                                                <div class="chef-option">
                                                    <input class="checkbox-tools" type="radio" name="user_type" id="tool-4" value="4">
                                                    <label class="for-checkbox-tools" for="tool-4">
                                                        <i class="fas fa-utensils"></i>
                                                        {{ __('sentence.rest') }}
                                                    </label>
                                                </div>
                                            </div>




                                            <div class="form-wrap" id="municipalitydropd">
                                            </div>

                                        </li>
                                        <li class="full-width">
                                            <div class="form-wrap">
                                                 <button type="button" class="prev" id="prev1"> {{__('sentence.back')}}</button>
                                                <button type="button" class="next" id="next1"> {{__('sentence.next') }}</button>
                                            </div>
                                        </li>
                                    </ul>
                                </fieldset>

                                <fieldset id="step3">
                                    <span class="note"><em>*</em> {{__('sentence.fieldr') }}</span>
                                    <ul>
                                        <li>
                                            <div class="form-wrap">
                                                <label for=""> {{__('sentence.firstname') }}<em>*</em></label>
                                                <input type="text" name="first_name" required="">
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-wrap">
                                                <label for="">{{__('sentence.lastname') }}<em>*</em></label>
                                                <input type="text" name="last_name" required="">
                                            </div>
                                        </li>

                                        <li>
                                            <div class="form-wrap">
                                                <label for="">{{__('sentence.mobile') }}<em>*</em></label>
                                                <input type="text" name="mobile"  id="mobile" required="">
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-wrap">
                                                <label for="">{{__('sentence.email') }}<em>*</em></label>
                                                <input type="email" name="email" required="">
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-wrap">
                                                <label for="">{{__('sentence.pass') }}<em>*</em></label>
                                                <input type="password" name="password" id="password" required="">
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-wrap">
                                                <label for="">{{__('sentence.cpass') }}<em>*</em></label>
                                                <input type="password" name="confirm_password" id="confirm_password" required="">
                                            </div>
                                        </li>
                                         <li class="full-width">
                                            <div class="form-wrap">
                                                <label for="">{{__('sentence.address') }}<em>*</em></label>
                                                <input type="text" name="address" id="address" required="">
                                            </div>
                                        </li>
                                        <div  id="city_or_minicipa">
                                        </div>
                                        <li id="citydropd">
                                            <div class="form-wrap" >
                                                <label for="">{{__('sentence.city') }}<em>*</em></label>
                                                <select name="chef_city" id="chef_city" required="">
                                                    <option value="" selected="">{{__('sentence.selectcity') }}</option>
                                                </select>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-wrap">
                                                <label for="">{{__('sentence.state') }}</label>
                                                <input type="text" id="statedes" disabled>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-wrap">
                                                <label for="">{{__('sentence.country') }}</label>
                                                <input type="text" id="counrtydes" disabled>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-wrap">
                                                <label for="">{{__('sentence.zipcode') }}<em>*</em></label>
                                                <input type="text" name="zipcode" required="">
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-wrap">
                                                <label for="">{{__('sentence.profile') }}<em>*</em></label>
                                                <span >{{__('sentence.profile-note')}}</span>
                                                 {{ Form::file('profile', ["class"=>"form-control","placeholder"=>"Profile","id"=>"profile","name"=>"profile","onchange"=>"previewImage(this)", "accept"=>"image/*"]) }}
                                                 <input type="hidden" id="profile-avtr" name="profile_avtr" value="image-3.png">
                                                 <br>
                                                <div id="previewImage" class="m-t-20" style="padding: 10px;">
                                                    <img src="{{asset('public/frontend/images/users/image-3.png')}}" class="img-thumbnail" height="100px" width="100px"/>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-wrap">
                                                <label>{{__('sentence.use-default-image')}}</label>
                                                <div id="avtarImage" class="default-img">
                                                    <img id="image-1.png" src="{{asset('public/frontend/images/users/image-1.png')}}" height='70px' width='70px' onclick="previewAvatar(this)">
                                                    <img id="image-2.png" src="{{asset('public/frontend/images/users/image-2.png')}}" height='70px' width='70px' onclick="previewAvatar(this)">
                                                    <img id="image-5.png" src="{{asset('public/frontend/images/users/image-5.png')}}" height='70px' width='70px' onclick="previewAvatar(this)">
                                                    <img id="image-7.png" src="{{asset('public/frontend/images/users/image-7.png')}}" height='70px' width='70px' onclick="previewAvatar(this)">
                                                    <img id="image-4.png" src="{{asset('public/frontend/images/users/image-4.png')}}" height='70px' width='70px' onclick="previewAvatar(this)">
                                                    <img id="image-6.png" src="{{asset('public/frontend/images/users/image-6.png')}}" height='70px' width='70px' onclick="previewAvatar(this)">
                                                    <img id="image-8.png" src="{{asset('public/frontend/images/users/image-8.png')}}" height='70px' width='70px' onclick="previewAvatar(this)">
                                                    <img id="image-9.png" src="{{asset('public/frontend/images/users/image-9.png')}}" height='70px' width='70px' onclick="previewAvatar(this)">
                                                </div>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="form-wrap">
                                                <label for="experties-input">Experties<em>*</em></label>

                                                <!-- Input Field -->
                                                <input type="text" id="experties-input" placeholder="Press Enter to add experties" />

                                                <!-- Chips List -->
                                                <div id="experties-chips" class="chip-list"></div>

                                                <!-- Hidden Input to Store Comma-Separated String -->
                                                <input type="hidden" name="experties" id="experties-hidden" required />
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-wrap">
                                                <label for="nic">NIC#<em>*</em></label>
                                                <input type="text" name="nic" id="nic" required>
                                            </div>
                                        </li>

                                        <li class="full-width">
                                            <div class="form-wrap">
                                                <div class="checkbox">
                                                    <input type="checkbox" name="acknowledgement" required="">
                                                    <label for="Acknowledgement">{{__('sentence.ackn') }}</label>
                                                    <a href="#content-popup" title="" class="popup-modal link-text">{{__('sentence.contract-term') }}</a>
                                                    <div id="content-popup" class="content-popup white-popup-block mfp-hide">
                                                        <div class="popup-content-main mCustomScrollbar">
                                                            @include('frontend.policy.mexico-contract')
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="full-width">
                                            <div class="form-wrap">
                                                <div class="checkbox">
                                                    <input type="checkbox" name="privacy_policy" required="">
                                                    <label for="Privacy Policy">{{__('sentence.privacy-policy') }}</label>
                                                    <a href="{{route('privacy')}}" target="_blank" title="" class="link-text">{{__('sentence.privacy-policy-link') }}</a>
                                                    {{-- <a href="#pp-content-popup" title="" class="popup-modal link-text">{{__('sentence.privacy-policy-link') }}</a> --}}


                                                    {{-- <div id="pp-content-popup" class="content-popup white-popup-block mfp-hide">
                                                        <div>
                                                            <p>&nbsp;</p>
                                                            <div name="termly-embed" data-id="b31595b5-a73e-40a9-96ec-b0cd8fc786bf" data-type="iframe">
                                                            </div>
                                                        </div>
                                                    </div> --}}
                                                </div>
                                            </div>
                                        </li>
                                        <li class="full-width">
                                            <div class="form-wrap">
                                                <button type="button" class="prev" id="prev3">{{__('sentence.back') }}</button>
                                                <button type="button" class="next" id="next3">{{__('sentence.next') }}</button>
                                            </div>
                                        </li>
                                    </ul>
                                </fieldset>

                                <fieldset id="step4">
                                    <div class="card bg-transparent">
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h4>{{__('sentence.addpickup') }}</h4>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="basic-form">

                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="">{{__('sentence.picdel') }}<span class="text-danger">*</span></label>
                                                        <select  name="options" id="pickup_delivery" required="" class="form-control">
                                                            <option value="" selected="">{{__('sentence.pso') }}</option>
                                                            <option value="1">{{__('sentence.piconly') }}</option>
                                                            <option value="2">{{__('sentence.picdelb') }}</option>
                                                            <option value="3">{{__('sentence.delonly') }} </option>
                                                        </select>
                                                        <input type="hidden" id="optionCount" value={{!empty($count)?$count:0}}>
                                                    </div>
                                                </div>
                                                <div id="pickup" style="display: none">
                                                    <br>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label >{{__('sentence.state') }}<span class="text-danger">*</span></label>
                                                            {{ Form::select('state',!empty($states) ? $states : [], old(),["required","placeholder"=>'Select State',"id"=>"state","name"=>"state","class"=>"form-control"]) }}
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>{{__('sentence.city') }}<span class="text-danger">*</span></label>
                                                            <select name="city" id="city" class="form-control" required="">
                                                                <option>{{__('sentence.selectcity') }}</option>
                                                            </select>
                                                        </div>

                                                    </div>

                                                </div>

                                                <div id="delivery" style="display: none">
                                                    <br>
                                                    <h4 style=" font-weight: 600;font-size: 20px;line-height: 24px;color: black;padding: 0 0 10px 0;margin: 0 0 0 0;">{{__('sentence.deld') }}</h4>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-4">
                                                            <label>{{__('sentence.delo') }}</label>
                                                            <select name="delivery_by" required="">
                                                                <option value="1">{{__('sentence.chefnm') }}</option>
                                                                {{-- <option value="2">{{__('sentence.delcom') }}</option> --}}
                                                            </select>

                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="distance-sec">
                                                        <div id="inc">
                                                            <div id="option">

                                                                <h6>{{__('sentence.dist') }}</h6>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md-4">
                                                                        <label class="col-lg-4 col-form-label" >{{__('sentence.from') }}
                                                                        </label>
                                                                        <div class="input-group mb-2">
                                                                            <input type="number" class="form-control" name="addmore[0][min_miles]" id="miles0" class="miles-input" required="" value="0" readonly>
                                                                            <div class="input-group-append">
                                                                                <div class="input-group-text">{{__('sentence.miles') }}</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group col-md-4">
                                                                        <label class="col-lg-4 col-form-label" >{{__('sentence.to') }}
                                                                        </label>
                                                                        <div class="input-group mb-2">
                                                                            <input type="number" class="form-control" name="addmore[0][max_miles]" id="mmiles0" class="miles-input" required="" min='0'>
                                                                            <div class="input-group-append">
                                                                                <div class="input-group-text">{{__('sentence.miles') }}</div>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="form-group col-md-4">
                                                                        <label class="col-lg-4 col-form-label" >{{__('sentence.rate') }}
                                                                        </label>
                                                                        <div class="input-group mb-2">
                                                                            <div class="input-group-prepend">
                                                                                <div class="input-group-text">{{!empty($currency)?$currency->symbol:''}}</div>
                                                                            </div>
                                                                            <input type="number" name="addmore[0][min_miles_rate]" class="form-control"class="dollar-sign" id="rate" required="">

                                                                        </div>
                                                                        <input type="hidden" id="currency" value="{{!empty($currency)?$currency->symbol:''}}">
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="add-remove-btn">
                                                            <a href="javascript:;" title="" class="add-distance" style="color: black;"><i class="fas fa-plus"></i> {{__('sentence.addmo') }}</a>
                                                            <a href="javascript:;" title="" class="remove-distance" style="display:none;float: right;color: black;"><i class="fas fa-minus"></i> {{__('sentence.removeo') }}</a>
                                                        </div>
                                                    </div>

                                                </div> <br><br>
                                                <button type="button" class="prev" id="prev4"> {{__('sentence.back')}}</button>
                                                <button type="button" class="next" id="next4">{{__('sentence.next') }}</button>

                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset id="step5">
                                    <div class="card bg-transparent">
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h4> {{__('sentence.addcerti') }}</h4>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="basic-form">
                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <div class="form-group row">
                                                                <label class="col-sm-4 col-form-label"> {{__('sentence.certinam') }}
                                                                    <span class="text-danger">*</span></label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control" name="certi_name" id="certi_name" placeholder="{{__('sentence.entcertnm') }}" required="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <div class="form-group row">
                                                                <label class="col-sm-4 col-form-label"> {{__('sentence.certiurl') }}
                                                                            <span class="text-danger">*</span></label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control" name="certi_url" id="certi_url" placeholder="{{__('sentence.entcertiurl') }}" required="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <div class="form-group row">
                                                                <label class="col-sm-4 col-form-label"> {{__('sentence.from') }}
                                                                            <span class="text-danger">*</span></label>
                                                                <div class="col-sm-8">
                                                                    <input type="month" class="form-control" name="certi_from" id="from" autocomplete="off" required="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <div class="form-group row">
                                                                <label class="col-sm-4 col-form-label"> {{__('sentence.to') }}
                                                                            <span class="text-danger">*</span></label>
                                                                <div class="col-sm-8">
                                                                    <input type="month" class="form-control" name="certi_to" id="to"  required="" autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <div class="form-group row">
                                                                <label class="col-sm-4 col-form-label"> {{__('sentence.certiauth') }}
                                                                            <span class="text-danger">*</span></label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control" name="certi_authority" id="certi_authority" placeholder="{{__('sentence.entcertauth') }}" required="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <div class="form-group row">
                                                                <label class="col-sm-4 col-form-label">{{__('sentence.img') }}
                                                                <span class="text-danger">*</span></label>
                                                                <div class="col-sm-8">
                                                                {{ Form::file('profile', ["class"=>"form-control","placeholder"=>"image","id"=>"image","name"=>"image","onchange"=>"previewImage(this)"]) }}

                                                                <div id="previewImage" class="m-t-20" style="padding: 10px;">
                                                                </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-10">
                                                        <button type="submit" name="btnCancel" class="btn btn-warning" onclick=" window.history.back()">{{__('sentence.cancel') }}</button>
                                                        <button type="button" class="prev" id="prev5"> {{__('sentence.back')}}</button>
                                                        <button type="button" class="next" id="next5">{{__('sentence.reg') }}</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="form-wrap">
                                            <div class="loader-btn">
                                                <div class="sk-three-bounce">
                                                    <div class="sk-child sk-bounce1"></div>
                                                    <div class="sk-child sk-bounce2"></div>
                                                    <div class="sk-child sk-bounce3"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </fieldset>

                                {{ Form::close() }}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert display-none alert-success"></div>
                                        <div class="alert display-none alert-danger"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
    <!--scripts starts here-->
    <script type="text/javascript" src="{{ asset('public/frontend/js/jquery.min.js')}}"></script>
    <script src="{{asset('public/backend/common/jquery.validate.js')}}"></script>
    <script type="text/javascript" src="{{ asset('public/frontend/js/jquery.magnific-popup.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('public/frontend/js/jquery.mCustomScrollbar.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('public/frontend/js/pages/chef-regi.js')}}"></script>
    <script type="text/javascript" src="{{ asset('public/frontend/js/pages/pickup-delivery.js')}}"></script>


    <script type="text/javascript">
    $(".form-wrap a.link-text").click(function(){
        (function(d, s, id) {
            var js, tjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "https://app.termly.io/embed-policy.min.js";
            tjs.parentNode.insertBefore(js, tjs);
        }(document, 'script', 'termly-jssdk'));
    });


    const chipInput = document.getElementById("experties-input");
    const chipContainer = document.getElementById("experties-chips");
    const hiddenInput = document.getElementById("experties-hidden");

    let chips = [];

    chipInput.addEventListener("keydown", function (event) {
        if (event.key === "Enter" && chipInput.value.trim() !== "") {
            event.preventDefault();
            addChip(chipInput.value.trim());
            chipInput.value = "";
        }
    });

    function addChip(value) {
        if (chips.includes(value)) return;

        chips.push(value);
        updateHiddenInput();

        const chip = document.createElement("div");
        chip.classList.add("chip");
        chip.innerHTML = `${value} <span onclick="removeChip('${value}', this)">×</span>`;
        chipContainer.appendChild(chip);
    }

    function removeChip(value, el) {
        chips = chips.filter(v => v !== value);
        el.parentElement.remove();
        updateHiddenInput();
    }

    function updateHiddenInput() {
        hiddenInput.value = chips.join(",");
    }


    jQuery(document).ready( function () {
    var count=$("#optionCount").val();
    var cnt=count!=0?count-1:0;
    var cityId='';
    $(".add-distance").click( function(e) {
        var m = $("#mmiles"+cnt).val();

        if(m==''){
            return false;
        }
        $("#mmiles"+cnt).attr('readonly', true);
        cnt++;
        e.preventDefault();

        $("#inc").append('<div id="option'+cnt+'">\
            <div class="form-row">\
            <br>\
            <div class="form-group col-md-4">\
            <label>{{__("sentence.gthan")}}\
            </label>\
            <div class="input-group mb-2">\
            <input type="number" class="form-control" name="addmore['+cnt+'][min_miles]" id="miles'+cnt+'" value="'+m+'" class="miles-input" required="" value="0" readonly>\
            <div class="input-group-append">\
            <div class="input-group-text">Miles</div></div></div></div>\
            <div class="form-group col-md-4">\
            <label >{{__('sentence.to') }}\
            </label>\
            <div class="input-group mb-2">\
            <input type="number" class="form-control" name="addmore['+cnt+'][max_miles]" id="mmiles'+cnt+'" min="'+m+'" class="miles-input" required="">\
            <div class="input-group-append">\
            <div class="input-group-text">Miles</div>\
            </div></div></div>\
            <div class="form-group col-md-4">\
            <label>{{__('sentence.rate') }}\
            </label>\
            <div class="input-group mb-2">\
            <div class="input-group-prepend">\
            <div class="input-group-text">'+$('#currency').val()+'</div>\
            </div>\
            <input type="number" name="addmore['+cnt+'][min_miles_rate]" class="form-control"class="dollar-sign" id="rate" required="">\
            </div>\
            </div>\
            </div>\
            </div>');
        if(cnt>0){
            $(".remove-distance").show();
        }
        return false;
    });
    $(".remove-distance").click( function(e) {
        $( "#option"+cnt ).remove();

        if(cnt==1){
            cnt=0;
            $("#mmiles"+cnt).attr('readonly', false);
            $(this).hide();
        }else{
            cnt--;
            $("#mmiles"+cnt).attr('readonly', false);
        }
        return false;
    });
    if(cnt>0){
            $(".remove-distance").show();
        }


});
</script>
</body>
</html>

