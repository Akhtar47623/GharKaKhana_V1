$(function () { //must
    $("#frmMenu").validate({
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
            service_per_container: {
                number: true
            },
            quantity: {
                number: true
            },
            serving_size:{
                number: true
            },
            units:{
                alpha: true
            },
            label:{
                checkextension1: true,
                dimention:[640,480]
                
            },
            profile:{
                checkextension: true
            },
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
          messages: {
            service_per_container: { number:"Allowed number only"},
            quantity: { number:"Please enter a whole,fraction or decimal number"},
            service_size: { number:"Allowed number only"},
            units:{ alpha: 'Only Alphabet allowed'},
            mon_start_time: {required: "Required"},
            mon_end_time: {required: "Required",monGreaterThan: "Not Greater"},
            tue_start_time: {required: "Required"},
            tue_end_time: {required: "Required",tueGreaterThan: "Not Greater"},
            wed_start_time: {required: "Required"},
            wed_end_time: {required: "Required",wedGreaterThan: "Not Greater"},
            thu_start_time: {required: "Required"},
            thu_end_time: {required: "Required",thuGreaterThan: "Not Greater"},
            fri_start_time: {required: "Required"},
            fri_end_time: {required: "Required",friGreaterThan: "Not Greater"},
            sat_start_time: {required: "Required"},
            sat_end_time: {required: "Required",satGreaterThan: "Not Greater"},
            sun_start_time: {required: "Required"},
            sun_end_time: {required: "Required",sunGreaterThan: "Not Greater"},
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
                        timeOut: 3000,closeButton: !0,
                        debug: !1,newestOnTop: !0,progressBar: !0,
                        positionClass: "toast-top-right",preventDuplicates: !0,onclick: null,showDuration: "500",
                        hideDuration: "2000",extendedTimeOut: "2000",showEasing: "swing",hideEasing: "linear",showMethod: "fadeIn", hideMethod: "fadeOut",
                        tapToDismiss: !1
                        })
                        window.location = BASEURL+'menu';
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
    $.validator.addMethod('checkextension', function (value, element) {
        var fileExtension = ['jpeg', 'jpg', 'png', 'JPG', 'JPEG', 'PNG'];
        var filename = $('#profile').val();

        if (filename) {
            if ($.inArray(filename.split('.').pop().toLowerCase(), fileExtension) == -1) {
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }, 'Only jpg & png files are allowed.');
    $.validator.addMethod('checkextension1', function (value, element) {
        var fileExtension = ['jpeg', 'jpg', 'png', 'JPG', 'JPEG', 'PNG'];
        var filename = $('#label').val();

        if (filename) {
            if ($.inArray(filename.split('.').pop().toLowerCase(), fileExtension) == -1) {
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }, 'Only jpg & png files are allowed.');
    $.validator.addMethod('dimention', function(value, element, param) {
        if(element.files.length == 0){
            return true;
        }
        var width = $(element).data('imageWidth');
        var height = $(element).data('imageHeight');
        if(width > param[0] && height > param[1]){
            return true;
        }else{
            return false;
        }
    },'Please upload an image with 640 x 480 pixels dimension');
    
    
});

function previewImage(input) {
    if (input.files && input.files[0]) {
        var filerdr = new FileReader();
        filerdr.onload = function (e) {
            $('#previewImage').html('<img src="' + e.target.result + '" class="" height="80px" width="80px"/>');
        }
        filerdr.readAsDataURL(input.files[0]);
    } else {
        $('#previewImage').html('');
    }
}
function previewImage1(input) {
    if (input.files && input.files[0]) {

        var filerdr = new FileReader();
        var file = input.files[0];
        var tmpImg = new Image();
        tmpImg.src=window.URL.createObjectURL( file );
        filerdr.onload = function (e) {
            width = tmpImg.naturalWidth;
            height = tmpImg.naturalHeight;
            $('#label').data('imageWidth', width);
            $('#label').data('imageHeight', height);
            $('#previewImage1').html('<img src="' + e.target.result + '" class="" height="80px" width="80px"/>');
        }
        filerdr.readAsDataURL(input.files[0]);
        
    } else {
        $('#previewImage1').html('');
    }
}
$(".weekDays-selector .weekday").click(function(){
    $(this).parent("li").find(".time-sec input").val('');
}) 
$(document.body).on('click', '.togBtn' ,function(){
    $(this).closest('.card-body').find( ".rate-hide-show" ).toggleClass("active");
});

$(".onoffswitch-label").click(function(){
    $(".option-box").toggleClass("active");
    $("#option1").attr("required", true);
});
function displayRate()
{
    var basicRate =  $('#basicRate').val();
    var service_fee_per = $('#service_fee_per').val();
    var tax = $('#tax').val();
    var rate =  parseFloat(basicRate) * parseInt(service_fee_per) / 100 + parseFloat(basicRate);
    var displayRate =  parseFloat(rate) *  parseInt(tax) / 100 + parseFloat(rate);
    $("#displayrate").val(displayRate);



}

function rate()
{
    var basicRate =  $('#basicRate').val();
    var service_fee_per = $('#service_fee_per').val();
    var tax = $('#tax').val();
    var rate =  parseFloat(basicRate) * parseInt(service_fee_per) / 100 + parseFloat(basicRate);
    var displayRate =  parseFloat(rate) *  parseInt(tax) / 100 + parseFloat(rate);
    $("#displayrate").val(displayRate);

    
}
rate();

$(document).on('change', '.option-rate', function() { 
    var service_fee_per = $('#service_fee_per').val();
    var tax = $('#tax').val();
    optionRate=$(this).val();
    var opRate =  parseFloat(optionRate) * parseInt(service_fee_per) / 100 + parseFloat(optionRate);
    var opDisplayRate =  parseFloat(opRate) *  parseInt(tax) / 100 + parseFloat(opRate);
    $(this).parent().parent().find('.display-option-rate').text(" (With Comm. & Tax: " + opDisplayRate.toFixed(2) + ")");
});