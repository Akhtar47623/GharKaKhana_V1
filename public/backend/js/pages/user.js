$(function () { //must
   
    $("#frmUser").validate({
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
        messages: {
            password: {
                minlength: "Your password must contain more than 6 characters",
            },
            confirm_password: {
                minlength: "Your password must contain more than 6 characters",
                equalTo: "Your Passwords Must Match" // custom message for mismatched passwords
            },
            profile: {
                checkextension: 'Only jpg & png files are allowed'
            },
            first_name:{
                alpha: 'Only Alphabet allowed'
            },
            last_name:{
                alpha: 'Only Alphabet allowed'
            },
            mobile:{
                minlength : 'Please enter at least 4 digit.'
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
                url: $('#frmUser').attr('action'),
                type: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                success: function (res) {
                    var message = res.message;
                    if (res.status == 200) {
                        localStorage.setItem('message', message);
                        window.location = BASEURL+'users';
                        // $('#frmLocation')[0].reset();
                    } else {
                        $('.alert-danger').show().html(message);
                        $btn.html($btn.val());
                        $btn.attr('disabled', false);
                    }
                },
                error: function (err) {
                    $('.alert-danger').show().html('Ooops...Something went wrong. Please try again.');
                    $btn.html($btn.val());
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
    }, "White space is not allowed");

    $('select').select2({}).on("change", function (e) {
        $(this).valid()
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

$('#country').change(function(){
        var countryID = $(this).val();    
        if(countryID){
            $.ajax({
            type:"GET",
            url:BASEURL+"get-state-list?country_id="+countryID,
            success:function(res){
                if(res['0'])
                {
                    $("#state").empty();
                    $("#state").append('<option>Select State ...</option>');
                    $.each(res['0'],function(key,value){
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
            url:BASEURL+"get-city-list?state_id="+stateID,
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