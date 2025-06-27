
//new
$(function () { //must
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    if($('html').attr('lang')=='es'){
        $.extend( $.validator.messages, {
            required: "Este campo es obligatorio.",
            email: "Por favor, escribe una dirección de correo válida.",        
        } );
    }
    $("#frmForgotPassword").validate({
        errorElement: 'span',
        errorClass: 'help-block error-help-block',
        highlight: function (element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error'); // add the Bootstrap error class to the control group
        },
        success: function (element) {
            $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // remove the Boostrap error class from the control group
        },

        focusInvalid: true,
        submitHandler: function (form) { 
            var $btn = $('#btnSubmit');
            $btn.attr('disabled', true);
            $('.alert').hide();
            $('.loader-btn').show();
            $.ajax({
                url: $('#frmForgotPassword').attr('action'),
                type: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                success: function (res) {
                    var message = res.message;
                    if (res.status == 200) {
                        $(".loader-btn").hide();
                        localStorage.setItem('message', message);
                        $('.alert-success').show().html(message);
                        $('#frmForgotPassword')[0].reset();
                    } else {
                        $(".loader-btn").hide();
                        $('.alert-danger').show().html(message);
                        $btn.html($btn.data('text'));
                        $btn.attr('disabled', false);
                    }
                },
                error: function (err) {
                    $(".loader-btn").hide();
                    $('.alert-danger').show().html('Ooops...Something went wrong. Please try again.');
                    $btn.html($btn.data('text'));
                    $btn.attr('disabled', false);
                }
            });
        }
    });
});

