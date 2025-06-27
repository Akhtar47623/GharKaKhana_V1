$('.enumenu_ul').responsiveMenu({
        'menuIcon_text': '',
        onMenuopen: function () {}
    });
$(document).on('click','.okay-btn', function(e) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    e.preventDefault();
    $.ajax({
        method: 'POST',
        url: BASEURL+'cookie',
        data : {
            'name' : 'accept-cookie',
            'value' : true
        },
        success: function (response) {
            $('.cookies-block').hide();
        },
        error: function (error) {
            alert('Error: Please refresh the page');
        },
    });
});
$(document).on('click','.countrylocation', function() {
     var countryID =$(this).data('id');
 
     $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
    $.ajax({
        url:'save-location',
        method: 'POST',
        data : {
            countryID:countryID, 
        },
        success: function (res) {
            window.location = BASEURL;
        }
    });
});