//new
var $ = jQuery.noConflict();

$(document).ready(function () {

    $('.edit-profile-tab').easyResponsiveTabs({
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
        }
    });

});
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
                checkidextension:'Solo se permiten archivos jpg y png',
                noSpace: "No se permiten espacios en blanco",
                filesize: 'El tamaño del archivo debe ser inferior a 1 MB',                     
            });
        }else{
            $.extend( $.validator.messages, {
                alpha: 'Only Alphabet allowed',
                checkextension: 'Only jpg & png files are allowed',
                checkidextension: 'Only jpg & png files are allowed',   
                noSpace:"White space is not allowed",
                filesize:'File size must be less than 1MB',     
            });
        }
    //Chef Basic Info
    $("#frmChefBasicInfo").validate({
        errorElement: 'span',
        errorClass: 'help-block error-help-block',
        rules: {
            profile: {
                checkextension: true
            },
            first_name: {
                alpha:true
            },
            last_name: {
                alpha:true
            },
            mobile:{
                minlength:4
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
            $("#preloader").show();
            $btn.attr('disabled', true);
            $('.alert').hide();

            $.ajax({
                url: $('#frmChefBasicInfo').attr('action'),
                type: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
               success: function (res) {
                    var message = res.message;
                    if (res.status == 200) {
                       $('#preloader').show();
                        localStorage.setItem('message', message);
                        toastr.success(message, "Top Right", {
                        timeOut: 2000,closeButton: !0,
                        debug: !1,newestOnTop: !0,progressBar: !0,
                        positionClass: "toast-top-center",preventDuplicates: !0,onclick: null,showDuration: "5000",
                        hideDuration: "2000",extendedTimeOut: "2000",showEasing: "swing",hideEasing: "linear",showMethod: "fadeIn", hideMethod: "fadeOut",
                        tapToDismiss: !1
                        })
                        $('.alert-success').show().html(message);
                        setTimeout(function(){
                            $('.alert-success').hide().html(message);
                        }, 5000);
                    } else {
                        $('#preloader').hide();
                         toastr.error(message, "Top Right", {
                        positionClass: "toast-top-center",timeOut: 2000,
                        closeButton: !0, debug: !1,newestOnTop: !0,
                        progressBar: !0,preventDuplicates: !0,onclick: null,showDuration: "5000",hideDuration: "1000",
                        extendedTimeOut: "2000",showEasing: "swing", hideEasing: "linear",showMethod: "fadeIn",hideMethod: "fadeOut",
                        tapToDismiss: !1
                        })
                        $('.alert-danger').show().html(message);
                        setTimeout(function(){
                            $('.alert-danger').hide().html(message);
                        }, 5000);
                    }
                },
                error: function (err) {
                    $('#preloader').hide();
                    toastr.error("'Ooops...Something went wrong. Please try again.'", "Top Right", {
                    positionClass: "toast-top-center",timeOut: 2000,closeButton: !0,
                    debug: !1,newestOnTop: !0,progressBar: !0,preventDuplicates: !0,
                    onclick: null,showDuration: "5000", hideDuration: "1000",extendedTimeOut: "2000",
                    showEasing: "swing",hideEasing: "linear", showMethod: "fadeIn",hideMethod: "fadeOut",
                    tapToDismiss: !1
                    })
                    $('.alert-danger').show().html('Ooops...Something went wrong. Please try again.');
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

    //Change Password
    $("#frmChefChangePassword").validate({
        errorElement: 'span',
        errorClass: 'help-block error-help-block',
        rules: {
            password: {
                required: true,
                minlength: 6,
                noSpace: true
            },
            password_confirm: {
                required: true,
                minlength: 6,
                noSpace: true,
                equalTo: "#password"
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
            var $btn = $('#btnSubmit');
            $("#loader").show();
            $btn.attr('disabled', true);
            $('.alert').hide();

            $.ajax({
                url: $('#frmChefChangePassword').attr('action'),
                type: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                success: function (res) {
                    var message = res.message;
                    if (res.status == 200) {
                       $('#loader').hide();
                        localStorage.setItem('message', message);
                        toastr.success(message, "Top Right", {
                        timeOut: 2000,closeButton: !0,
                        debug: !1,newestOnTop: !0,progressBar: !0,
                        positionClass: "toast-top-center",preventDuplicates: !0,onclick: null,showDuration: "5000",
                        hideDuration: "2000",extendedTimeOut: "2000",showEasing: "swing",hideEasing: "linear",showMethod: "fadeIn", hideMethod: "fadeOut",
                        tapToDismiss: !1
                        })
                        $('.alert-success').show().html(message);
                        $('#frmChefChangePassword')[0].reset();
                        setTimeout(function(){
                            $('.alert-success').hide().html(message);
                        }, 5000);
                    } else {
                        $('#loader').hide();
                        toastr.error(message, "Top Right", {
                        positionClass: "toast-top-center",timeOut: 2000,
                        closeButton: !0, debug: !1,newestOnTop: !0,
                        progressBar: !0,preventDuplicates: !0,onclick: null,showDuration: "5000",hideDuration: "1000",
                        extendedTimeOut: "2000",showEasing: "swing", hideEasing: "linear",showMethod: "fadeIn",hideMethod: "fadeOut",
                        tapToDismiss: !1
                        })
                        $('.alert-danger').show().html(message);
                        setTimeout(function(){
                            $('.alert-danger').hide().html(message);
                        }, 5000);
                    }
                },
                error: function (err) {
                    $('#loader').hide();
                    toastr.error("'Ooops...Something went wrong. Please try again.'", "Top Right", {
                    positionClass: "toast-top-center",timeOut: 2000,closeButton: !0,
                    debug: !1,newestOnTop: !0,progressBar: !0,preventDuplicates: !0,
                    onclick: null,showDuration: "5000", hideDuration: "1000",extendedTimeOut: "2000",
                    showEasing: "swing",hideEasing: "linear", showMethod: "fadeIn",hideMethod: "fadeOut",
                    tapToDismiss: !1
                    })
                    $('.alert-danger').show().html('Ooops...Something went wrong. Please try again.');
                }
            });
        }
    });

    //Chef Location
    $("#frmChefLocation").validate({
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
            $.ajax({
                url: $('#frmChefLocation').attr('action'),
                type: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                success: function (res) {
                    var message = res.message;
                    if (res.status == 200) {
                       
                        localStorage.setItem('message', message);
                        toastr.success(message, "Top Right", {
                        timeOut: 2000,closeButton: !0,
                        debug: !1,newestOnTop: !0,progressBar: !0,
                        positionClass: "toast-top-center",preventDuplicates: !0,onclick: null,showDuration: "5000",
                        hideDuration: "2000",extendedTimeOut: "2000",showEasing: "swing",hideEasing: "linear",showMethod: "fadeIn", hideMethod: "fadeOut",
                        tapToDismiss: !1
                        })
                        $('.alert-success').show().html(message);
                        setTimeout(function(){
                            $('.alert-success').hide().html(message);
                        }, 5000);
                    } else {
                         toastr.error(message, "Top Right", {
                        positionClass: "toast-top-center",timeOut: 2000,
                        closeButton: !0, debug: !1,newestOnTop: !0,
                        progressBar: !0,preventDuplicates: !0,onclick: null,showDuration: "5000",hideDuration: "1000",
                        extendedTimeOut: "2000",showEasing: "swing", hideEasing: "linear",showMethod: "fadeIn",hideMethod: "fadeOut",
                        tapToDismiss: !1
                        })
                        $('.alert-danger').show().html(message);
                        setTimeout(function(){
                            $('.alert-danger').hide().html(message);
                        }, 5000);
                    }
                },
                error: function (err) {
                    toastr.error("'Ooops...Something went wrong. Please try again.'", "Top Right", {
                    positionClass: "toast-top-center",timeOut: 2000,closeButton: !0,
                    debug: !1,newestOnTop: !0,progressBar: !0,preventDuplicates: !0,
                    onclick: null,showDuration: "5000", hideDuration: "1000",extendedTimeOut: "2000",
                    showEasing: "swing",hideEasing: "linear", showMethod: "fadeIn",hideMethod: "fadeOut",
                    tapToDismiss: !1
                    })
                    $('.alert-danger').show().html('Ooops...Something went wrong. Please try again.');
                }
            });
        }
    });

    //Chef Business
    $("#frmChefBusiness").validate({
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
        highlight: function (element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error'); // add the Bootstrap error class to the control group
        },

        success: function (element) {
            $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // remove the Boostrap error class from the control group
        },
        focusInvalid: true,
        submitHandler: function (form) {
            var $btn = $('#btnSubmit');
            $btn.html($btn.data('loading-text'));
            $btn.attr('disabled', true);
            $('.alert').hide();
            $.ajax({
                url: $('#frmChefBusiness').attr('action'),
                type: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
               success: function (res) {
                    var message = res.message;
                    if (res.status == 200) {
                       
                        localStorage.setItem('message', message);
                        toastr.success(message, "Top Right", {
                        timeOut: 2000,closeButton: !0,
                        debug: !1,newestOnTop: !0,progressBar: !0,
                        positionClass: "toast-top-center",preventDuplicates: !0,onclick: null,showDuration: "5000",
                        hideDuration: "2000",extendedTimeOut: "2000",showEasing: "swing",hideEasing: "linear",showMethod: "fadeIn", hideMethod: "fadeOut",
                        tapToDismiss: !1
                        })
                        $('.alert-success').show().html(message);
                         setTimeout(function(){
                            $('.alert-success').hide().html(message);
                        }, 5000);

                    } else {
                         toastr.error(message, "Top Right", {
                        positionClass: "toast-top-center",timeOut: 2000,
                        closeButton: !0, debug: !1,newestOnTop: !0,
                        progressBar: !0,preventDuplicates: !0,onclick: null,showDuration: "5000",hideDuration: "1000",
                        extendedTimeOut: "2000",showEasing: "swing", hideEasing: "linear",showMethod: "fadeIn",hideMethod: "fadeOut",
                        tapToDismiss: !1
                        })
                        $('.alert-danger').show().html(message);
                        setTimeout(function(){
                            $('.alert-danger').hide().html(message);
                        }, 5000);
                    }
                },
                error: function (err) {
                    toastr.error("'Ooops...Something went wrong. Please try again.'", "Top Right", {
                    positionClass: "toast-top-center",timeOut: 2000,closeButton: !0,
                    debug: !1,newestOnTop: !0,progressBar: !0,preventDuplicates: !0,
                    onclick: null,showDuration: "5000", hideDuration: "1000",extendedTimeOut: "2000",
                    showEasing: "swing",hideEasing: "linear", showMethod: "fadeIn",hideMethod: "fadeOut",
                    tapToDismiss: !1
                    })
                    $('.alert-danger').show().html('Ooops...Something went wrong. Please try again.');
                }
            });
        }
    });

    //Chef Tax
    $("#frmChefTax").validate({
        errorElement: 'span',
        errorClass: 'help-block error-help-block',
        rules: {
            uploadid: {
                checkidextension: true
            }
        },
        
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
        highlight: function (element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error'); // add the Bootstrap error class to the control group
        },

        success: function (element) {
            $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // remove the Boostrap error class from the control group
        },
        focusInvalid: true,
        submitHandler: function (form) {
            var $btn = $('#btnSubmit');
            $btn.html($btn.data('loading-text'));
            $btn.attr('disabled', true);
            $('.alert').hide();
            $.ajax({
                url: $('#frmChefTax').attr('action'),
                type: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                success: function (res) {
                    var message = res.message;
                    if (res.status == 200) {
                       
                        localStorage.setItem('message', message);
                        toastr.success(message, "Top Right", {
                        timeOut: 2000,closeButton: !0,
                        debug: !1,newestOnTop: !0,progressBar: !0,
                        positionClass: "toast-top-center",preventDuplicates: !0,onclick: null,showDuration: "5000",
                        hideDuration: "2000",extendedTimeOut: "2000",showEasing: "swing",hideEasing: "linear",showMethod: "fadeIn", hideMethod: "fadeOut",
                        tapToDismiss: !1
                        })
                        $('.alert-success').show().html(message);
                        setTimeout(function(){
                            $('.alert-success').hide().html(message);
                        }, 5000);
                    } else {
                         toastr.error(message, "Top Right", {
                        positionClass: "toast-top-center",timeOut: 2000,
                        closeButton: !0, debug: !1,newestOnTop: !0,
                        progressBar: !0,preventDuplicates: !0,onclick: null,showDuration: "5000",hideDuration: "1000",
                        extendedTimeOut: "2000",showEasing: "swing", hideEasing: "linear",showMethod: "fadeIn",hideMethod: "fadeOut",
                        tapToDismiss: !1
                        })
                        $('.alert-danger').show().html(message);
                         setTimeout(function(){
                            $('.alert-danger').hide().html(message);
                        }, 5000);
                    }
                },
                error: function (err) {
                    toastr.error("'Ooops...Something went wrong. Please try again.'", "Top Right", {
                    positionClass: "toast-top-center",timeOut: 2000,closeButton: !0,
                    debug: !1,newestOnTop: !0,progressBar: !0,preventDuplicates: !0,
                    onclick: null,showDuration: "5000", hideDuration: "1000",extendedTimeOut: "2000",
                    showEasing: "swing",hideEasing: "linear", showMethod: "fadeIn",hideMethod: "fadeOut",
                    tapToDismiss: !1
                    })
                    $('.alert-danger').show().html('Ooops...Something went wrong. Please try again.');
                }
            });
        }
    });
    $.validator.addMethod('checkidextension', function (value, element) {
        var fileExtension = ['jpg','jpeg','png','JPG','JPEG','PNG','pdf', 'doc', 'docs'];
        var filename = $('#uploadid').val();

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
function previewImage1(input) {
    if (input.files && input.files[0]) {
        var filerdr = new FileReader();
        filerdr.onload = function (e) {
            $('#previewImage1').html('<embed src="' + e.target.result + '" width="200px" height="200px" />');
        }
        filerdr.readAsDataURL(input.files[0]);
    } else {
        $('#previewImage1').html('');
    }
}
$('#country').change(function(){
    var countryID = $(this).val();    
    if(countryID){
        $.ajax({
            type:"GET",
            url:BASEURL+"get-state-lists?country_id="+countryID,
            success:function(res){
                if(res)
                {
                    $("#state").empty();
                    $("#state").append('<option>Select State ...</option>');
                    $.each(res,function(key,value){
                        $("#state").append('<option value="'+key+'">'+value+'</option>');
                    });
                }
                else
                {
                    $("#state").empty();
                }
            }
        });
    }
    else
    {
        $("#state").empty();
    }
});
$('#state').change(function(){
    var stateID = $(this).val();    
    if(stateID){
        $.ajax({
            type:"GET",
            url:BASEURL+"get-city-lists?state_id="+stateID,
            success:function(res){
                if(res)
                {
                    $("#city").empty();
                    $("#city").append('<option>Select City ...</option>');
                    $.each(res,function(key,value){
                        $("#city").append('<option value="'+key+'">'+value+'</option>');
                    });
                }
                else
                {
                    $("#city").empty();
                }
            }
        });
    }
    else
    {
        $("#city").empty();
    }
});
function previewAvatar(a) {   
    input=a.src;
    if(input){
        $('#previewImage').html('<img src="' + input + '" class="img-thumbnail" height="100px" width="100px"/>');
        $('#profile-avtr').val(a.id);
        var $el = $('#profile');
        $el.wrap('<form>').closest('form').get(0).reset();
        $el.unwrap();
    }else{
        $('#previewImage').html('');
    }       
}