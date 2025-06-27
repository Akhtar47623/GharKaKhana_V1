var $ = jQuery.noConflict();


$(document).ready(function () {
    $('.edit-profile-tab').easyResponsiveTabs({
        type: 'default', //Types: default, vertical, accordion           
        width: 'auto', //auto or any width like 600px
        fit: true,   // 100% fit in a container
        tabidentify: 'hor_1',
        closed: 'accordion', // Start closed if in accordion view
        activate: function(event) { // Callback function if tab is switched
            var $tab = $(this);
            var $info = $('#tabInfo');
            var $name = $('span', $info);
            $name.text($tab.text());
            $info.show();
        }
    });
});


$(function () { //must
    $("#frmCustProfile").validate({
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
            var $btn = $('#btnProfile');
            $btn.html($btn.data('loading-text'));
            $btn.attr('disabled', true);
            $('.alert').hide();

            $.ajax({
                url: $('#frmCustProfile').attr('action'),
                type: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                success: function (res) {
                    var message = res.message;
                    if (res.status == 200) {
                        localStorage.setItem('message', message);
                          
                        window.location = BASEURL+'customer-profile';
                        // $('#frmLocation')[0].reset();
                    } else {
                         
                        $('.alert-danger').show().html(message);
                        $btn.html($btn.data('text'));
                        $btn.attr('disabled', false);
                    }
                },
                error: function (err) {
                    
                    $('.alert-danger').show().html('Ooops...Something went wrong. Please try again.');
                    $btn.html($btn.data('text'));
                    $btn.attr('disabled', false);
                }
            });
        }
    });    
});
$(function () { //must
    $("#frmCustChangePassword").validate({
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
                equalTo: "Your Passwords Must Match" // custom message for mismatched passwords
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
            var $btn = $('#btnChangePassword');
            $btn.html($btn.data('loading-text'));
            $btn.attr('disabled', true);
            $('.alert').hide();

            $.ajax({
                url: $('#frmCustChangePassword').attr('action'),
                type: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                success: function (res) {
                    var message = res.message;
                    if (res.status == 200) {
                        localStorage.setItem('message', message);
                          toastr.success(message, "Top Right", {
                        timeOut: 3000,closeButton: !0,
                        debug: !1,newestOnTop: !0,progressBar: !0,
                        positionClass: "toast-top-right",preventDuplicates: !0,onclick: null,showDuration: "500",
                        hideDuration: "2000",extendedTimeOut: "2000",showEasing: "swing",hideEasing: "linear",showMethod: "fadeIn", hideMethod: "fadeOut",
                        tapToDismiss: !1
                        })
                        window.location = BASEURL+'customer-profile';
                        // $('#frmLocation')[0].reset();
                    } else {
                         toastr.error(message, "Top Right", {
                        positionClass: "toast-top-center",timeOut: 3000,
                        closeButton: !0, debug: !1,newestOnTop: !0,
                        progressBar: !0,preventDuplicates: !0,onclick: null,showDuration: "500",hideDuration: "1000",
                        extendedTimeOut: "2000",showEasing: "swing", hideEasing: "linear",showMethod: "fadeIn",hideMethod: "fadeOut",
                        tapToDismiss: !1
                        })
                        $('.alert-danger').show().html(message);
                        $btn.html($btn.data('text'));
                        $btn.attr('disabled', false);
                    }
                },
                error: function (err) {
                    console.log(err);
                     toastr.error("'Ooops...Something went wrong. Please try again.'", "Top Right", {
                    positionClass: "toast-top-right",timeOut: 3000,closeButton: !0,
                    debug: !1,newestOnTop: !0,progressBar: !0,preventDuplicates: !0,
                    onclick: null,showDuration: "500", hideDuration: "1000",extendedTimeOut: "2000",
                    showEasing: "swing",hideEasing: "linear", showMethod: "fadeIn",hideMethod: "fadeOut",
                    tapToDismiss: !1
                    })
                    $('.alert-danger').show().html('Ooops...Something went wrong. Please try again.');
                    $btn.html($btn.data('text'));
                    $btn.attr('disabled', false);
                }
            });
        }
    });    
});

$(function () { //must
    $("#frmCustLocation").validate({
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
            var $btn = $('#btnChangeLocation');
            $btn.html($btn.data('loading-text'));
            $btn.attr('disabled', true);
            $('.alert').hide();

            $.ajax({
                url: $('#frmCustLocation').attr('action'),
                type: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                success: function (res) {
                    var message = res.message;
                    if (res.status == 200) {
                        localStorage.setItem('message', message);
                          toastr.success(message, "Top Right", {
                        timeOut: 3000,closeButton: !0,
                        debug: !1,newestOnTop: !0,progressBar: !0,
                        positionClass: "toast-top-right",preventDuplicates: !0,onclick: null,showDuration: "500",
                        hideDuration: "2000",extendedTimeOut: "2000",showEasing: "swing",hideEasing: "linear",showMethod: "fadeIn", hideMethod: "fadeOut",
                        tapToDismiss: !1
                        })
                        window.location = BASEURL+'customer-profile';
                        // $('#frmLocation')[0].reset();
                    } else {
                         toastr.error(message, "Top Right", {
                        positionClass: "toast-top-center",timeOut: 3000,
                        closeButton: !0, debug: !1,newestOnTop: !0,
                        progressBar: !0,preventDuplicates: !0,onclick: null,showDuration: "500",hideDuration: "1000",
                        extendedTimeOut: "2000",showEasing: "swing", hideEasing: "linear",showMethod: "fadeIn",hideMethod: "fadeOut",
                        tapToDismiss: !1
                        })
                        $('.alert-danger').show().html(message);
                        $btn.html($btn.data('text'));
                        $btn.attr('disabled', false);
                    }
                },
                error: function (err) {
                    console.log(err);
                     toastr.error("'Ooops...Something went wrong. Please try again.'", "Top Right", {
                    positionClass: "toast-top-right",timeOut: 3000,closeButton: !0,
                    debug: !1,newestOnTop: !0,progressBar: !0,preventDuplicates: !0,
                    onclick: null,showDuration: "500", hideDuration: "1000",extendedTimeOut: "2000",
                    showEasing: "swing",hideEasing: "linear", showMethod: "fadeIn",hideMethod: "fadeOut",
                    tapToDismiss: !1
                    })
                    $('.alert-danger').show().html('Ooops...Something went wrong. Please try again.');
                    $btn.html($btn.data('text'));
                    $btn.attr('disabled', false);
                }
            });
        }
    });    
});
$.validator.addMethod("noSpace", function(value, element) {
        return value.indexOf(" ") < 0 && value != "";
    }, "White space is not allowed"); 
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
    var custLocation = new google.maps.places.Autocomplete(document.getElementById('locationadd'));

    google.maps.event.addListener(custLocation, 'place_changed', function () {
        var custEventPlaceData = custLocation.getPlace();        
        CustMapAddressVarible(custEventPlaceData);
        
    }); 
        
});
function CustMapAddressVarible(mapAddress) {

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
    $('#locationadd').val(formatedAddress);
    $("#cust_city").val(city);
    $("#cust_state").val(state);
    $("#cust_log").val(longitude);
    $("#cust_lat").val(latitude);
    $("#cust_country").val(country);
    $('#cust_zipcode').val(postal_code);
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
