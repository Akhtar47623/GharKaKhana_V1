$(function () { //must
    $('.toggle_class').change(function() {
    alert("hereaaa");
            var status = $(this).prop('checked') == true ? 1 : 0; 
            var id = $(this).data('id');
            $.ajax({
              type: "get",
              dataType: "json",
              url: 'change-discount-status',
              data: {'status': status, 'id': id},
              success: function(data){
                console.log(data.success)
              }
            });
        });
    $("#frmPromocode").validate({
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
        rules:{
            promocode: {
                required: true
            },
            discount: {
                required: true,
                digits:true
            },
            total_coupon:{
                required: true,
                digits:true
            },
            minimum_order_value:{
                required: true,
                digits:true
            },
            start_date:{
                required: true
            },
            expired_date:{
                required: true
            },
           
        },
          messages: {
             promocode: {
                required: "Please Enter Promocode"
            },
             discount: {
                required: "Enter Discount",
                digits:"Enter Only Number"
            },
            total_coupon:{
                digits:"Enter Only Number"
            },
            minimum_order_value:{
                digits:"Enter Only Number"
            },
            start_date:{
                required: "Please Select Starts Date"

            },
            expired_date:{
                required: "Please Select Expired Date"
            },

        },
        highlight: function (element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error'); // add the Bootstrap error class to the control group
        },

        success: function (element) {
            $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // remove the Boostrap error class from the control group
        },

        focusInvalid: true,
        submitHandler: function (form) {
            $("#loader").show();
            var $btn = $('#btnSubmit');
            $btn.html($btn.data('loading-text'));
            $btn.attr('disabled', true);
            $('.alert').hide();

            $.ajax({
                url: $('#frmPromocode').attr('action'),
                type: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                success: function (res) {
                    var message = res.message;
                    if (res.status == 200) {
                        $("#loader").hide();
                        localStorage.setItem('message', message);
                        toastr.success(message, "Top Right", {
                        timeOut: 3000,closeButton: !0,
                        debug: !1,newestOnTop: !0,progressBar: !0,
                        positionClass: "toast-top-right",preventDuplicates: !0,onclick: null,showDuration: "500",
                        hideDuration: "2000",extendedTimeOut: "2000",showEasing: "swing",hideEasing: "linear",showMethod: "fadeIn", hideMethod: "fadeOut",
                        tapToDismiss: !1
                        })
                        window.location = BASEURL+'chef-discount';
                        // $('#frmLocation')[0].reset();
                    } else {
                        $("#loader").hide();
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
                    $("#loader").hide();
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
function randomString() {
    var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
    var string_length = 8;
    var randomstring = '';
    for (var i=0; i<string_length; i++) {
        var rnum = Math.floor(Math.random() * chars.length);
        randomstring += chars.substring(rnum,rnum+1);
    }
    return randomstring;
}
$("#start_date").datepicker({
        dateFormat: 'yy-mm-dd',
        onSelect: function(selected) {
          $("#expired_date").datepicker( "option","minDate", selected)
        }
    });
    $("#expired_date").datepicker({ 
        dateFormat: 'yy-mm-dd',
        onSelect: function(selected) {
           $("#start_date").datepicker("option","maxDate", selected)
        }
    });  

