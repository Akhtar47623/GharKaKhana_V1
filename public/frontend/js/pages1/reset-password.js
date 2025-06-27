//new

$(function () { //must
    if($('html').attr('lang')=='es'){
    
        $.extend( $.validator.messages, {
            required: "Este campo es obligatorio.",
            remote: "Por favor, rellena este campo.",
            email: "Por favor, escribe una dirección de correo válida.",
            url: "Por favor, escribe una URL válida.",
            number: "Por favor, escribe un número válido.",
            digits: "Por favor, escribe sólo dígitos.",
            equalTo: "Por favor, escribe el mismo valor de nuevo.",
            extension: "Por favor, escribe un valor con una extensión aceptada.",
            maxlength: $.validator.format( "Por favor, no escribas más de {0} caracteres." ),
            minlength: $.validator.format( "Por favor, no escribas menos de {0} caracteres." ),
            rangelength: $.validator.format( "Por favor, escribe un valor entre {0} y {1} caracteres." ),
            range: $.validator.format( "Por favor, escribe un valor entre {0} y {1}." ),
            max: $.validator.format( "Por favor, escribe un valor menor o igual a {0}." ),
            min: $.validator.format( "Por favor, escribe un valor mayor o igual a {0}." ),          
        });
    }
    $("#frmResetPassword").validate({
        errorElement: 'span',
        errorClass: 'help-block error-help-block',
        rules: {
            password: {
                minlength: 6                
            },
            confirm_password: {
                minlength: 6,
                equalTo: "#password"               
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
            $(".loader-btn").show();
            $btn.attr('disabled', true);
            $('.alert').hide();

            $.ajax({
                url: $('#frmResetPassword').attr('action'),
                type: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                success: function (res) {
                    var message = res.message;
                    if (res.status == 200) {
                        $(".loader-btn").hide();
                        $('#frmResetPassword')[0].reset();
                        localStorage.setItem('message', message);
                        $('.alert-success').show().html(message);
                        setTimeout(function() {
                            window.location = BASEURL+'chef-sign-in';
                        }, 2000);
                        
                        
                        
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



