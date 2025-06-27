//new
$(function () { //must
    if($('html').attr('lang')=='es'){
        $.extend( $.validator.messages, {
            required: "Este campo es obligatorio.",
        } );
    }
    $("#frmCustomerLocation").validate({
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
            $btn.attr('disabled', true);
            $('.alert').hide();

            $.ajax({
                url: $('#frmCustomerLocation').attr('action'),
                type: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                success: function (res) {
                    var message = res.message;
                    if (res.status == 200) {
                        localStorage.setItem('message', message);
                          
                        window.location = BASEURL;
                        // $('#frmLocation')[0].reset();
                    } else {
                          
                        $('.alert-danger').show().html(message);
                        $btn.html($btn.data('text'));
                        $btn.attr('disabled', false);
                    }
                },
                error: function (err) {
                    console.log(err);
                     
                    $('.alert-danger').show().html('Ooops...Something went wrong. Please try again.');
                    $btn.html($btn.data('text'));
                    $btn.attr('disabled', false);
                }
            });
        }
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
