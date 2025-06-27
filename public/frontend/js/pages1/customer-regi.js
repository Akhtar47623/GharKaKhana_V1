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
                alpha: 'Solo se permite el alfabeto',
                checkextension: 'Solo se permiten archivos jpg y png',
                noSpace: "No se permiten espacios en blanco",
                filesize: 'El tamaño del archivo debe ser inferior a 1 MB',                     
            });
        }else{
            $.extend( $.validator.messages, {
                alpha: 'Only Alphabet allowed',
                checkextension: 'Only jpg & png files are allowed', 
                noSpace:"White space is not allowed",
                filesize:'File size must be less than 1MB',     
            });
        }
    $("#customerRegistration").validate({
        errorElement: 'span',
        errorClass: 'help-block error-help-block',
        rules: {
            password: {
                minlength: 6,
                noSpace: true
            },
            confirm_password: {
                minlength: 6,
                equalTo: "#password",
                noSpace: true
            },
            profile: {
                checkextension: true
            },
            first_name: {
                alpha:true
            },
            last_name: {
                alpha:true
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
            $(".loader-btn").show();
            var $btn = $('#btnSubmit');
            $btn.html($btn.data('loading-text'));
            $btn.attr('disabled', true);
            $('.alert').hide();

            $.ajax({
                url: $('#customerRegistration').attr('action'),
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
                        $('#customerRegistration')[0].reset();
                        window.location = BASEURL+'customer-sign-in';                        
                    } else {
                        $(".loader-btn").hide();
                        $('.alert-danger').show().html(message);
                        $btn.html($btn.data('text'));
                        $btn.attr('disabled', false);
                    }
                },
                error: function (err) {
                    $('.alert-danger').show().html('Ooops...Something went wrong. Please try again.');
                    $btn.html($btn.data('text'));
                    $btn.attr('disabled', false);
                }
            });
        }
    });


    $.validator.addMethod("alpha", function(value, element) {
        return this.optional(element) || value == value.match(/^[a-zA-Z ]+$/);
    });
    $.validator.addMethod("noSpace", function(value, element) {
        return value.indexOf(" ") < 0 && value != "";
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

