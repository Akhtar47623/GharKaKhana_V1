// JavaScript Document
var $ = jQuery.noConflict();

$(document).ready(function () {
    $.ajax({  
            url:BASEURL+"remove-del-charge",  
            type: "POST",
            dataType: "json",
            cache:false,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success:function(data){
                $(".checkout-price-sec").load(" .checkout-price-sec > *");
                    $(".place-order").load(" .place-order > *");
            }  
        });
    
	$('.location-tab-sec').easyResponsiveTabs({
	    type: 'default', //Types: default, vertical, accordion           
	    width: 'auto', //auto or any width like 600px
	    fit: true,   // 100% fit in a container
	    tabidentify: 'hor_1',
        activate: function () {
            var tab=$(this).attr("tab");
            if(tab=='delivery'){
                $('.place-order-btn').removeClass("active");
                $("input:radio").attr("checked", false);
                       
            }
            if(tab=='pickup'){
                $('.place-order-btn').addClass("active");
                location.reload();                
            }
        }
	});

    $(".resp-tab-item.delivery-link").click(function(){
        $(".tips-sec").show();

    });

    $(".resp-tab-item.pickup-link").click(function(){
        
        $(".tips-sec").hide();
        $.ajax({  
            url:BASEURL+"remove-del-charge",  
            type: "POST",
            dataType: "json",
            cache:false,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success:function(data){
                $(".checkout-price-sec").load(" .checkout-price-sec > *");
            }  
        });
    });
    $(document).on('click', '#cust', function(){
        $('#cust-sec').show();
    })
    $(document).on('click', '#btnCust', function(){
	    $v=$('#txtCust').val();
		$(".custom-tip span").text($v+'%');
        $(".custom-tip input").val($v);
		$(".custom-tip").show();
		$('#cust-sec').hide();
	});    
});

$(document).ready(function() {

    $("#frmDiscount").validate({
        errorElement: 'span',
        errorClass: 'help-block error-help-block',
        highlight: function (element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error'); // add the Bootstrap error class to the control group
        },
        success: function (element) {
            $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // remove the Boostrap error class from the control group
        },
        rules: {
            coupon: {
                required:true
            }
        },
        messages: {
            coupon: {
                required: "Promocode is required",
            }
        },
        focusInvalid: true,
        submitHandler: function (form) { 
            var $btn = $('#btnDisSubmit');
            $('.alert').hide();
            $.ajax({
                url: $('#frmDiscount').attr('action'),
                type: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                success: function (res) {
                    var message = res.message;
                    if (res.status == 200) {
                        localStorage.setItem('message', message);  
                        var discount=parseFloat(res.discount);  
                        $('#discount').text(discount.toFixed(2));
                        tot = parseFloat($('#total').text())-discount;
                        $('#total').text(tot.toFixed(2));
                        $('#grandtotal').text(tot.toFixed(2));
                        $('.promocode-sec').hide();
                    } else {
                        $('.alert-danger').show().html(message);
                    }                   
                },
                error: function (err) {
                    $('.alert-danger').show().html('Ooops...Something went wrong. Please try again.');
                }
            });
        }
    });

    $("#frmDelivery").validate({
        errorElement: 'span',
        errorClass: 'help-block error-help-block',
        errorPlacement: function (error, element) {
            if (element.hasClass('select2')) {
                error.insertAfter(element.parent().find('span.select2'));
            } else if (element.parent('.input-group').length ||
                element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }, 
        highlight: function (element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error'); // add the Bootstrap error class to the control group
        },
        success: function (element) {
            $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // remove the Boostrap error class from the control group
        },
        focusInvalid: true,
        submitHandler: function (form) { 
            var $btn = $('#btnSubmit');
            $btn.html($btn.data('loading-text'));
            $('.alert').hide();
            $.ajax({
                url: $('#frmDelivery').attr('action'),
                type: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                success: function (res) {
                    var message = res.message;
                    if (res.status == 200) {

                        localStorage.setItem('message', message);                   
                        var del_change=parseFloat(res.del_charge);
                        var miles=parseFloat(res.miles);
                        $('#del_fee_title').text(' ('+miles+' Miles)');
                        $('#del_fee').text(del_change.toFixed(2));
                        tot = parseFloat($('#total').text())+del_change;
                        $('#total').text(tot);
                        $('#grandtotal').text(tot);
                        $(".tips-sec").show();
                        $('.place-order-btn').addClass("active");
                         
                    } else {
                        var status = navigator.onLine ? 1 : 0;
                        if(status!=0){
                            $('.alert-danger').show().html(message);
                        }else{
                            $('.alert-danger').show().html("No internet connectivity. Please check your network");
                        }
                    }
                    $btn.html($btn.val());

                },
                error: function (err) {
                    
                    var status = navigator.onLine ? 1 : 0;                        
                    if(status!=0){
                        $('.alert-danger').show().html('Ooops...Something went wrong. Please try again.');
                    }else{
                        $('.alert-danger').show().html("No internet connectivity. Please check your network");
                    }                 
                    
                }
            });
        }
    });

    $(document.body).on('click', '#btnSubmit', function() {
        $("#frmDelivery").submit();
    });
    
    $(document).on('click', 'input[type=radio]', function(e){
        var val = $(this).val();
        var stotal = parseFloat($('#subtotal').text());
        var country_id =$('#country_id').val();
        var tips = stotal*val/100;
        var gtotal = parseFloat($('#total').text());
        var grandtotal = gtotal+tips
        $('#grandtotal').text(grandtotal.toFixed(2));
        $('#paynow').text(grandtotal.toFixed(2));
            $.ajax({  
                url:BASEURL+"add-tips",  
                type: "POST",
                dataType: "json",
                cache:false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data:{tips:val},  
                success:function(data){  
                    
                }  
           });     
    });
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
    var location = new google.maps.places.Autocomplete(document.getElementById('new_location'));

    google.maps.event.addListener(location, 'place_changed', function () {
        var eventPlaceData = location.getPlace();        
        mapDelAddressVarible(eventPlaceData);
        
    }); 
        
});
function mapDelAddressVarible(mapAddress) {
    
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

    $('#del_address').val(formatedAddress);
    $("#del_city").val(city);
    $("#del_state").val(state);
    $("#del_log").val(longitude);
    $("#del_lat").val(latitude);
    $("#del_cntry").val(country);
    $('#del_zipcode').val(postal_code);   
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


 $(document).on("click", "#new_location", function (e) {
        $('#new_location').val('');
 });
  function handleChange(input) {
    if (input.value < 0) input.value = 0;
    if (input.value > 100) input.value = 100;
  }