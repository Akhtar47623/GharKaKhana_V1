$(function () { //must
    if($('html').attr('lang')=='es'){
    
            $.extend( $.validator.messages, {
                required: "Requerida",
                monGreaterThan: "No es mayor",
                tueGreaterThan: "No es mayor",
                wedGreaterThan: "No es mayor",
                thuGreaterThan: "No es mayor",
                friGreaterThan: "No es mayor",
                satGreaterThan: "No es mayor",
                sunGreaterThan: "No es mayor",
                                                     
            });
        }else{
            $.extend( $.validator.messages, {
                required: "Required",
                monGreaterThan: "Not Greater",
                tueGreaterThan: "Not Greater",
                wedGreaterThan: "Not Greater",
                thuGreaterThan: "Not Greater",
                friGreaterThan: "Not Greater",
                satGreaterThan: "Not Greater",
                sunGreaterThan: "Not Greater",
            });
        }
    $("#frmMenu").validate({
        errorElement: 'span',
        errorClass: 'help-block error-help-block',
        rules:{
            mon_end_time:{
                required: true,
                monGreaterThan: "#mon_start_time"   
            },
            tue_end_time:{
                required: true,
                tueGreaterThan: "#tue_start_time"   
            },
            wed_end_time:{
                required: true,
                wedGreaterThan: "#wed_start_time"   
            },
            thu_end_time:{
                required: true,
                thuGreaterThan: "#thu_start_time"   
            },
            fri_end_time:{
                required: true,
                friGreaterThan: "#fri_start_time"   
            },
            sat_end_time:{
                required: true,
                satGreaterThan: "#sat_start_time"   
            },
            sun_end_time:{
                required: true,
                sunGreaterThan: "#sun_start_time"   
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
            $("#loader").show();
            var $btn = $('#btnSubmit');
            $btn.html($btn.data('loading-text'));
            $btn.attr('disabled', true);
            $('.alert').hide();

            $.ajax({
                url: $('#frmMenu').attr('action'),
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
                        timeOut: 3000,closeButton: !0,debug: !1,newestOnTop: !0,progressBar: !0,positionClass: "toast-top-right",
                        preventDuplicates: !0,onclick: null,showDuration: "300",hideDuration: "1000",
                        extendedTimeOut: "1000",showEasing: "swing",hideEasing: "linear",showMethod: "fadeIn",hideMethod: "fadeOut",tapToDismiss: !1
                        });
                        //window.location = BASEURL+'chef-dashboard';
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
    $.validator.addMethod('monGreaterThan', function(value, element) {
            var startTime = $("#mon_start_time").val();
            var endTime = $('#mon_end_time').val();
            return endTime > startTime;
    });
    $.validator.addMethod('tueGreaterThan', function(value, element) {
            var startTime = $("#tue_start_time").val();
            var endTime = $('#tue_end_time').val();
            return endTime > startTime;
    });
    $.validator.addMethod('wedGreaterThan', function(value, element) {
            var startTime = $("#wed_start_time").val();
            var endTime = $('#wed_end_time').val();
            return endTime > startTime;
    });
    $.validator.addMethod('thuGreaterThan', function(value, element) {
            var startTime = $("#thu_start_time").val();
            var endTime = $('#thu_end_time').val();
            return endTime > startTime;
    });
    $.validator.addMethod('friGreaterThan', function(value, element) {
            var startTime = $("#fri_start_time").val();
            var endTime = $('#fri_end_time').val();
            return endTime > startTime;
    });
    $.validator.addMethod('satGreaterThan', function(value, element) {
            var startTime = $("#sat_start_time").val();
            var endTime = $('#sat_end_time').val();
            return endTime > startTime;
    });
    $.validator.addMethod('sunGreaterThan', function(value, element) {
            var startTime = $("#sun_start_time").val();
            var endTime = $('#sun_end_time').val();
            return endTime > startTime;
    });
    $.validator.addMethod("alpha", function(value, element) {
        return this.optional(element) || value == value.match(/^[a-zA-Z ]+$/);
    }); 
});


$(".weekDays-selector .weekday").click(function(){
    $(this).parent("li").find(".time-sec input").val('');
}) 