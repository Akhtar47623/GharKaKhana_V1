// JavaScript Document
var $ = jQuery.noConflict();

$(document).ready(function () {
    $(".accordion-title").on("click",function(){
        if($(this).hasClass("accordion-open")){
            $(".accordion-title").removeClass("accordion-open");
            $(".accordion-content").slideUp();
        }else{
            $(".accordion-title").removeClass("accordion-open");
            $(".accordion-content").slideUp();
            $(this).addClass("accordion-open");
            $(this).next(".accordion-content").slideDown();
        }
    });

    $(".order-box").click(function(e){
        e.preventDefault();
        var dataAttr = $(this).data("attr");        
        $(".order-box").removeClass("active")
        $(this).addClass("active");
        $(".pending-order-box").hide();    
        $(".pending-order-box[data-source='"+dataAttr+"']").show();
        
    });

    $(".flag-icon").click(function(e){
        var id = $(this).data('id');
        var action = $(this).attr('data-action');
        $.ajax({
            url: action,
            type: 'post',
            dataType: 'json',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {id: id},
            success: function (res) { // What to do if we succeed
                toastr.options = {'positionClass': "toast-bottom-left"}
                if (res.status === 'success') {
                    toastr.success(res.msg);
                    $(".flag-icon").children("i").removeClass("far");
                    $(".flag-icon").children("i").addClass("fas");
                } else {
                    toastr.error(res.msg);
                }
            }
        });
        
    });

    $('.print-popup').magnificPopup({
        type: 'inline',
        preloader: false,
        focus: '#name',
    });

    $('.popup-with-form').magnificPopup({
        type: 'inline',
        preloader: false,
        focus: '#name',
    });
    $(".mCustomScrollbar").mCustomScrollbar({
        theme:"light-thick"
        //scrollbarPosition:"outside"
    });
    $('.popup-with-form').on('click',function(){
        $('#order_id').val($(this).data("orderid"));
        id=$(this).data("id");
        order_id=$(this).data("orderid");
        $.ajax({
                type:"POST",
                url:BASEURL+"get-messages",
                data:{order_id:order_id,id:id},
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success:function(res){
                    if(res){
                        $('#msg-data').empty();
                        $("#msg-data").append(res);
                        $(".mCustomScrollbar").mCustomScrollbar("update");
                        $(".mCustomScrollbar").mCustomScrollbar("scrollTo", "bottom");
                    }else{
                        $('#msg-data').empty();
                    }
                }
            });
    });
    //order status change
    $('.change-status').click(function(event) {
        var id = $(this).data('id');
        var action = $(this).attr('data-action');
        var status = $(this).attr('data-status');
        var timezone = $('#timezone').val();
        $.ajax({
            url: action,
            type: 'post',
            dataType: 'json',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {id: id,status:status,timezone:timezone},
            success: function (res) { // What to do if we succeed
                toastr.options = {'positionClass': "toast-bottom-left"}
                if (res.status === 'success') {
                    toastr.success(res.msg);
                    location.reload();
                } else {
                    toastr.error(res.msg);
                }
            }
        });
              
    });
});

$(function () { //must
    $("#frmChefMessage").validate({
        errorElement: 'span',
        errorClass: 'help-block error-help-block',
        errorPlacement: function (error, element) {
            return false;
        },
        focusInvalid: true,
        submitHandler: function (form) {
            var $btn = $('#btnSubmit');
            $.ajax({
                url: $('#frmChefMessage').attr('action'),
                type: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                success: function (res) {
                    var message = res.message;
                    if (res.status == 200) {
                       
                        $('#frmChefMessage')[0].reset();
                        $("#msg-data").append(res.msg);
                        $(".mCustomScrollbar").mCustomScrollbar("update");
                        $(".mCustomScrollbar").mCustomScrollbar("scrollTo", "bottom");
                    } 
                },
            });
        }
    });
});