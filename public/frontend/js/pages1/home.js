
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
$('#frmLocation').submit(function (event) {
    
    event.preventDefault();
    let form = $("#frmLocation")[0]; 
    $.ajax({
            url: $('#frmLocation').attr('action'),
            type: "POST",
            data: new FormData(form),
            contentType: false,
            cache: false,
            processData: false,
            dataType:'json',
            success: function (res) {

                var message = res.message;
                if (res.status == 200) {

                    localStorage.setItem('message', message);
                    window.location = BASEURL;

                            // $('#frmLocation')[0].reset();
                } else {
                    $('.alert-danger').show().html(message);
                    
                }
            },
            error: function (err) {            
                $('.alert-danger').show().html('Sorry, location not available right now');            
            }
        });
 });
//try
$('.location-link a').click(function() {
     
});

//try end
google.maps.event.addDomListener(window, 'load', function () {
    var location = new google.maps.places.Autocomplete(document.getElementById('location'));

    google.maps.event.addListener(location, 'place_changed', function () {
        var eventPlaceData = location.getPlace(); 
              
        mapAddressVarible(eventPlaceData);        
    }); 
});
 
function getLocation(){
     navigator.geolocation.getCurrentPosition(function (position) {
            getUserAddressBy(position.coords.latitude, position.coords.longitude)
        },
        function (error) {
            console.log("The Locator was denied :(")
        })
}
function getUserAddressBy(lat, long) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var address = JSON.parse(this.responseText);
                document.getElementById('location').value=address.results[0].formatted_address
                $('#address').val(address.results[0].formatted_address);
            }
        };
        xhttp.open("GET", "https://maps.googleapis.com/maps/api/geocode/json?latlng="+lat+","+long+"&key=AIzaSyDlkfpkyKX2wb_cRMmqVWthoadHuegCdoc", true);
        xhttp.send();
    } 

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
    alert("here");
    let form = $("#frmLocation")[0];
    if(formatedAddress !='' && city!='' && state!='' && longitude!='' && latitude!='' && country!=''){
        $.ajax({
            url: $('#frmLocation').attr('action'),
            type: "POST",
            data: new FormData(form),
            contentType: false,
            cache: false,
            processData: false,
            dataType:'json',
            success: function (res) {

                var message = res.message;
                if (res.status == 200) {
                    localStorage.setItem('message', message);
                    window.location = BASEURL;
                            // $('#frmLocation')[0].reset();
                } else {
                    $('.alert-danger').show().html(message);                    
                }
            },
            error: function (err) {            
                $('.alert-danger').show().html('Sorry, location not available right now');            
            }
        });
    }
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

$(document).on("click", ".delete", function (e) {
    var id = $(this).attr('data-id');
    var pagerefresh = ($(this).data("pagerefresh")) ? $(this).data("pagerefresh") : 0;
    var action = $(this).data("action");       
    e.preventDefault();     
    $.ajax({
        url: action,
        type: 'DELETE',
        dataType: "json",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {id:id},
        success: function (res) { // What to do if we succeed
            toastr.options = {'positionClass': "toast-bottom-left"}
            if (res.status == 'success') {
                toastr.success(res.msg);
                if (pagerefresh == 0) {
                    $(".cart-item-wrap").load(" .cart-item-wrap > *");
                    $(".mini-cart-bottom").load(" .mini-cart-bottom > *");
                }
            } else {
                toastr.error(res.msg);
            }
        }
    });
});
function changeQuantity(sel,id)
{
    
    var qty = sel.value;
    var id = id;
        $.ajax({
            url: BASEURL+'change-cart-qty',
            type: "POST",
            dataType: "json",
            cache:false,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {"id":id,"qty":qty},
            success:function(data) {
                if(data.status=='success'){
                    $(".cart-item-wrap").load(" .cart-item-wrap > *");
                    $(".mini-cart-bottom-right").load(" .mini-cart-bottom-right > *");
                   // window.location.reload();
                }
            }
        });
}




