//new 

$(function () { //must
   if($('html').attr('lang')=='es'){
    
      $.extend( $.validator.messages, {
        required: "Este campo es obligatorio.",
        url: "Por favor, escribe una URL válida.",
        checkextension: 'Solo se permiten archivos jpg y png',                    
      });
    }else{
      $.extend( $.validator.messages, {
        checkextension: 'Only jpg & png files are allowed', 
      });
    }
    $("#frmCertificate").validate({
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
         rules: {
            image: {
                checkextension: true
            },
            certi_url: {
                url: true
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
                url: $('#frmCertificate').attr('action'),
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
                        window.location = BASEURL+'certificate';
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
    $.validator.addMethod('checkextension', function (value, element) {
        var fileExtension = ['jpeg', 'jpg', 'png', 'JPG', 'JPEG', 'PNG'];
        var filename = $('#image').val();

        if (filename) {
            if ($.inArray(filename.split('.').pop().toLowerCase(), fileExtension) == -1) {
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    });
    
        var searchMinDate = "-25y";
        var searchMaxDate = "-1m";
        if ((new Date()).getDate() <= 5) {
          searchMaxDate = "-2m";
        }
        $("#from").datepicker({
          dateFormat: "M yy",
          yearRange: '1900:c+1',
          changeMonth: true,
          changeYear: true,

          showButtonPanel: true,
          showAnim: "",
          minDate: searchMinDate,
          maxDate: searchMaxDate,
          showButtonPanel: true,
          beforeShow: function(input, inst) {
            if ((datestr = $("#from").val()).length > 0) {
              var year = datestr.substring(datestr.length - 4, datestr.length);
              var month = jQuery.inArray(datestr.substring(0, datestr.length - 5), $("#from").datepicker('option', 'monthNamesShort'));
              $("#from").datepicker('option', 'defaultDate', new Date(year, month, 1));
              $("#from").datepicker('setDate', new Date(year, month, 1));
            }
          },
          onClose: function(input, inst) {
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $("#from").datepicker('option', 'defaultDate', new Date(year, month, 1));
            $("#from").datepicker('setDate', new Date(year, month, 1));
            var to = $("#to").val();
            $("#to").datepicker('option', 'minDate', new Date(year, month, 1));
            if (to.length > 0) {
              var toyear = to.substring(to.length - 4, to.length);
              var tomonth = jQuery.inArray(to.substring(0, to.length - 5), $("#to").datepicker('option', 'monthNamesShort'));
              $("#to").datepicker('option', 'defaultDate', new Date(toyear, tomonth, 1));
              $("#to").datepicker('setDate', new Date(toyear, tomonth, 1));
            }
          }
        });
        $("#to").datepicker({
          dateFormat: "M yy",
          yearRange: '1900:c+1',
          changeMonth: true,
          changeYear: true,
          showButtonPanel: true,
          showAnim: "",
          minDate: searchMinDate,
          maxDate: searchMaxDate,
          showButtonPanel: true,
          beforeShow: function(input, inst) {
            if ((datestr = $("#to").val()).length > 0) {
              var year = datestr.substring(datestr.length - 4, datestr.length);
              var month = jQuery.inArray(datestr.substring(0, datestr.length - 5), $("#to").datepicker('option', 'monthNamesShort'));
              $("#to").datepicker('option', 'defaultDate', new Date(year, month, 1));
              $("#to").datepicker('setDate', new Date(year, month, 1));
            }
          },
          onClose: function(input, inst) {
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $("#to").datepicker('option', 'defaultDate', new Date(year, month, 1));
            $("#to").datepicker('setDate', new Date(year, month, 1));
            var from = $("#from").val();
            $("#from").datepicker('option', 'maxDate', new Date(year, month, 1));
            if (from.length > 0) {
              var fryear = from.substring(from.length - 4, from.length);
              var frmonth = jQuery.inArray(from.substring(0, from.length - 5), $("#from").datepicker('option', 'monthNamesShort'));
              $("#from").datepicker('option', 'defaultDate', new Date(fryear, frmonth, 1));
              $("#from").datepicker('setDate', new Date(fryear, frmonth, 1));
            }

          }
        });
});
function previewImage(input) {
    if (input.files && input.files[0]) {
        var filerdr = new FileReader();
        filerdr.onload = function (e) {
            $('#previewImage').html('<img src="' + e.target.result + '" class="img-thumbnail" height="100px" width="100px"/>');
        }
        filerdr.readAsDataURL(input.files[0]);
    } else {
        $('#previewImage').html('');
    }
}



