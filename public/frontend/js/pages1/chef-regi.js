//new 
$(function () { //must
    $(".prev").click(function(){
        if ($('#step2').is(":visible")){
            $('#step1').show();
            $('#step2').hide();
            location.reload();
        }else if($('#step3').is(":visible")){
            $('#step2').show();
            $('#step3').hide();
        }else if($('#step4').is(":visible")){
            $('#step3').show();
            $('#step4').hide();
        }
    });

    $('.popup-modal').magnificPopup({
        type: 'inline',
        preloader: false,
        focus: '#name',     
    });
    
    $(".next").click(function(){
        var form = $("#chefRegistration");
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
        form.validate({
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
                    checkextension: true,
                    filesize: 1000000,
                },
                first_name: {
                    alpha:true
                },
                last_name: {
                    alpha:true
                },
                municipality: {
                    required:true
                }
            },
            
            highlight: function (element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error'); // add the Bootstrap error class to the control group
            },

            success: function (element) {
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // remove the Boostrap error class from the control group
            },                       
        });
        if (form.valid() === true){

            if ($('#step1').is(":visible")){
                current_fs = $('#step1');
                next_fs = $('#step2');
            }else if($('#step2').is(":visible")){
                current_fs = $('#step2');
                next_fs = $('#step3');
            }else if($('#step3').is(":visible")){
                current_fs = $('#step3');
                next_fs = $('#step4');
            }else{
                $('.loader-btn').show();
                $.ajax({
                    url: $('#chefRegistration').attr('action'),
                    type: "POST",
                    data: new FormData($('form#chefRegistration')[0]),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (res) {
                        var message = res.message;
                        if (res.status == 200) {
                            $(".loader-btn").hide();
                            localStorage.setItem('message', message);
                            
                            window.location = BASEURL+'thank-you';
                            $('#chefRegistration')[0].reset();
                            
                        } else {
                            $(".loader-btn").hide();                             
                            $('.alert-danger').show().html(message);                            
                        }
                    },
                    error: function (err) {
                        $(".loader-btn").hide();                         
                        $('.alert-danger').show().html('Ooops...Something went wrong. Please try again.');

                    }
                });
            }
            next_fs.show();
            current_fs.hide();
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
$.validator.addMethod('filesize', function (value, element, param) {
    return this.optional(element) || (element.files[0].size <= param)
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
$('#country').change(function(){
    var countryID = $(this).val();   
    if(countryID){
        $.ajax({
            type:"GET",
            url:BASEURL+"get-state-lists?country_id="+countryID,
            success:function(res){
                if(res)
                {                    
                    if(countryID==142){
                        $("#state").empty();
                        $("#state").append('<option>Seleccione estado</option>');
                        $.each(res,function(key,value){
                            $("#state").append('<option value="'+key+'">'+value+'</option>');
                        });
                        $('#typechef').hide();
                        $('#citydropd').hide();
                        $("#municipalitydropd").empty();
                        $('#munides').hide();
                        $("#municipalitydropd").append('<br><label for="">Municipio<em>*</em></label>\
                            <select name="municipality" id="municipality" class="form-control select2" style="width:60%" class="form-wrap">\
                            <option value="">Seleccionar municipio</option>\
                            <option value="48358">Tultitlán de Mariano Escobedo</option>\
                            <option value="48357">Coacalco</option>\
                            </select>');
                        $('#city_or_minicipa').after('<li id="munides">\
                            <div class="form-wrap">\
                            <label for="">Municipio</label>\
                            <input type="text"  id="municipalitydes" disabled>\
                            </div>\
                            </li>');
                        $('#municipality').on('change',function(){
                            var mun = $("#municipality option:selected").text();
                            $('#municipalitydes').val(mun);
                        });

                    }else{
                        $("#state").empty();
                        $("#state").append('<option>Select State ....</option>');
                        $.each(res,function(key,value){
                            $("#state").append('<option value="'+key+'">'+value+'</option>');
                        });
                    }

                }
                else{   
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
$('#next1').click(function(){
    var countryID = $('#country').val();
    var stateID = $('#state').val();
    var user_type = $('input[name="user_type"]:checked').val();
    if(stateID && countryID){
        $.ajax({
            type:"POST",
            url:BASEURL+"get-state-info",
            data:{country_id:countryID,state_id:stateID,user_type:user_type},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success:function(res){
                if(res){
                    $("#description").html(res.description); 
                }  
            }
        });
    }
    else
    {
        $("#state").empty();
    } 
});
$(document).ready(function(){
    $('#country').on('change',function(){
        var Country = $("#country option:selected").text();
        $('#counrtydes').val(Country);
    });
    $('#state').on('change',function(){
        var state = $("#state option:selected").text();
        $('#statedes').val(state);
    });
})

$('#next1').click(function(){
    var countryID = $('#country').val();
    var stateID = $('#state').val();
    var user_type = $('input[name="user_type"]:checked').val();
    if(stateID && countryID){
        $.ajax({
            type:"POST",
            url:BASEURL+"get-state-info",
            data:{country_id:countryID,state_id:stateID,user_type:user_type},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success:function(res){
                if(res){
                    $("#description").html(res.description); 
                }  
            }
        });
    }
    else
    {
        $("#state").empty();
    } 
});
