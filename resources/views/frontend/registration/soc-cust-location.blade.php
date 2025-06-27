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
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/css/responsive.css')}}" media="screen">
    <style>.error-help-block{color:red;} #step2{display:none;}</style>
    <script> var BASEURL = '{{ url("/") }}/' </script>
</head>
<body>
    <div class="wrapper">
        <section class="login-sec">
            <div class="login-wrap">
                <div class="login-left" style="background-image: url({{asset('public/frontend/images/location-bg-img.jpg')}})"></div>
                <div class="login-right">
                    <div class="login-right-wrap">
                        <div class="login-logo">
                            <a href="#" title="">
                                <img src="{{asset('public/frontend/images/white-logo.png')}}">
                            </a>
                        </div>
                        <div class="login-title">
                            <h1>Location</h1>
                        </div>
                        <div class="login-top">
                            <div class="login-form-sec">
                                {{ Form::open(['url' => route('save-customer-location'), 'method'=>'POST', 'files'=>true, 'name' => 'frmCustomerLocation', 'id' => 'frmCustomerLocation','class'=>"form-main"]) }}
                                <span class="note"><em>*</em> Fields Required.</span>
                                <fieldset id="step1">
                                    <ul>
                                        <li>
                                            <div class="form-wrap">
                                                <label for="">Location<em>*</em></label>
                                                <input type="text" name="location" id="location" value="" required="">
                                                <input type="hidden" name="uuid" id="uuid" value="{{$uuid}}">
                                                <input type="hidden" name="lat" id="lat">
                                                <input type="hidden" name="log" id="log">
                                                <input type="hidden" name="country" id="country">
                                                <input type="hidden" name="state" id="state">
                                                <input type="hidden" name="city" id="city">
                                                <input type="hidden" name="address" id="address">
                                                <input type="hidden" name="zipcode" id="zipcode">
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-wrap">
                                                <button type="button" class="next" id="next">Next</button>
                                            </div>
                                        </li>
                                    </ul>
                                </fieldset>
                                <fieldset id="step2">
                                    <ul>
                                        <li>
                                            <div class="form-wrap">
                                                <label for="">Password<em>*</em></label>
                                                <input type="password" name="password" id="password" required="">
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-wrap">
                                                <label for="">Confirm Password<em>*</em></label>
                                                <input type="password" name="confirm_password" id="confirm_password" required="">
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-wrap">
                                                 <button type="button" class="next" id="next3">Save</button>
                                                
                                                <img id="loader" src="{{ asset('public/frontend/images/loader.gif')}}" alt="" />
                                            </div>
                                        </li>
                                    </ul>
                                </fieldset>
                                {{ Form::close() }}                                
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
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&key=<?php echo config('view.google_api_key'); ?>"></script>
    <script type="text/javascript">
$(function () { //must
    $(".next").click(function(){
        
        var form = $("#frmCustomerLocation");

        form.validate({
            errorElement: 'span',
            errorClass: 'help-block error-help-block',
            errorPlacement: function (error, element) {
                if (element.hasClass('select2')) {
                    error.insertAfter(element.parent().find('span.select2'));
                } else if (element.parent('.input-group').length ||
                    element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
                    error.insertAfter(element.parent());
                    // else just place the validation message immediatly after the input
                } else {
                    error.insertAfter(element);
                }
            },
            rules: {
                password: {
                    minlength: 6,
                    noSpace: true
                },
                confirm_password: {
                    minlength: 6,
                    equalTo: "#password",
                    noSpace: true
                }
            },
            messages: {
                password: {
                    minlength: "Your password must contain more than 6 characters",
                },
                confirm_password: {
                    minlength: "Your password must contain more than 6 characters",
                    equalTo: "Your Passwords Must Match" 
                }
            },
            highlight: function (element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
            },

            success: function (element) {
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); 
            },                       
        });
        if (form.valid() === true){
            console.log("valid");
            if ($('#step1').is(":visible")){
                console.log("if");
                current_fs = $('#step1');
                next_fs = $('#step2');
            }else if($('#step2').is(":visible")){
                $("#loader").show();
                 console.log("else");
                 
                $.ajax({
                    url: $('#frmCustomerLocation').attr('action'),
                    type: "POST",
                    data: new FormData($('form#frmCustomerLocation')[0]),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (res) {
                        var message = res.message;
                        
                        if (res.status == 200) {
                            $("#loader").hide();
                            localStorage.setItem('message', message);
                            window.location = BASEURL;
                            $('#frmCustomerLocation')[0].reset();
                        } else {
                            $("#loader").hide();
                            $('.alert-danger').show().html(message);                            
                        }
                    },
                    error: function (err) {
                        $("#loader").hide();
                        $('.alert-danger').show().html('Ooops...Something went wrong. Please try again.');
                       
                    }
                });
            }
            next_fs.show();
            current_fs.hide();
        }
    });

    $.validator.addMethod("noSpace", function(value, element) {
        return value.indexOf(" ") < 0 && value != "";
    }, "White space is not allowed");   

    
});
var street_number = "";
var city = "";
var state = "";
var postal_code = "";
var country = "";
var street_name = "";
var addressFor = "";
var latitude = "";
var longitude = "";
var formatedAddress = "";
var intersection = "";
var country = "";
google.maps.event.addDomListener(window, 'load', function () {
    var location = new google.maps.places.Autocomplete(document.getElementById('location'));

    google.maps.event.addListener(location, 'place_changed', function () {
        var eventPlaceData = location.getPlace();        
        mapAddressVarible(eventPlaceData);
        
    }); 
        
});
function mapAddressVarible(mapAddress) {

    $.each(mapAddress.address_components, function (i, address) {

        //New field added for the address
        if (address.types[0] == "intersection") {
            intersection = address.short_name;
        }
        if (address.types[0] == "route") {
            street_name = address.short_name;
        }
        if (address.types[0] == "locality") {
            city = address.long_name;
        }
        if (address.types[0] == "administrative_area_level_1") {
            state = address.long_name;
        }
        if (address.types[0] == "country") {
            country = address.short_name;
        }
        if (address.types[0] == "postal_code") {
            postal_code = address.short_name;
        }
        if (address.types[0] == "street_number") {
            street_number = address.long_name;
        }
        if (address.types[0] == "country") {
            country = address.long_name;
        }
    });
    
    var addressContent = "";
    if (street_name == "" && street_number == "") {
        addressContent = intersection;
        street_name = addressContent;
    } else {
        addressContent = street_number + ' ' + street_name;
    }
    var latitude = mapAddress.geometry.location.lat();
    var longitude = mapAddress.geometry.location.lng();
    var formatedAddress = mapAddress.formatted_address;
    $('#address').val(formatedAddress);
    $("#city").val(city);
    $("#state").val(state);
    $("#log").val(longitude);
    $("#lat").val(latitude);
    $("#country").val(country);
    $('#zipcode').val(postal_code);
    emptyVariable();
}

function emptyVariable() {
    street_number = "";
    city = "";
    state = "";
    postal_code = "";
    country = "";
    street_name = "";
    addressFor = "";
    latitude = "";
    longitude = "";
    formatedAddress = "";
    intersection = "";
}
    </script>
    <!--scripts ends here-->
</body>
</html>