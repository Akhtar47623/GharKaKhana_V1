var $ = jQuery.noConflict();


$(document).ready(function () {
    $('.user-order-list-tab').easyResponsiveTabs({
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
            var uri = window.location.toString();
            if (uri.indexOf("?") > 0) {
                var clean_uri = uri.substring(0, uri.indexOf("?"));
                window.history.replaceState({}, document.title, clean_uri);
                location.reload();
            }
        }
    });

    // $(".mCustomScrollbar").mCustomScrollbar({
    //     theme:"light-thick"
    //     //scrollbarPosition:"outside"
    // });
    
    $('.popup-with-form').magnificPopup({
        type: 'inline',
        preloader: false,
        focus: '#name',
    });

    
    $('#txtSearch').on('keyup', function(){
        var text = $('#txtSearch').val();
        var qs="text="+text;
        if (history.pushState) {
                var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?'+ qs;
                window.history.pushState({path:newurl},'',newurl);
            }
        $.ajax({
            type:"GET",
            data: qs,
            success: function(res) {               
                $("#completed-order").load(" #completed-order > *");               
            }
        });
    });
});



$(function () { //must
    $("#frmCustMessage").validate({
        errorElement: 'span',
        errorClass: 'help-block error-help-block',
        errorPlacement: function (error, element) {
            return false;
        },
        focusInvalid: true,
        submitHandler: function (form) {
            var $btn = $('#btnSubmit');
            $.ajax({
                url: $('#frmCustMessage').attr('action'),
                type: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                success: function (res) {
                    var message = res.message;
                    if (res.status == 200) {
                       
                        $('#frmCustMessage')[0].reset();
                        $("#msg-data").append(res.msg);
                        $(".mCustomScrollbar").mCustomScrollbar("update");
                        $(".mCustomScrollbar").mCustomScrollbar("scrollTo", "bottom");
                    } 
                },
            });
        }
    });
});
