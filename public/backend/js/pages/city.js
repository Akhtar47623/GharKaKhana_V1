
$(function () { //must
   
    $("#frmCity").validate({
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
            name: {
                alpha:true
            },
            sortname:{
                alpha:true
            }
        },
        messages: {
            name:{
                alpha: 'Only alphabet allowed'
            },
            sortname:{
                alpha: 'Only alphabet allowed'
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
                url: $('#frmCity').attr('action'),
                type: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                success: function (res) {
                    var message = res.message;
                    if (res.status == 200) {
                        localStorage.setItem('message', message);
                        window.location = BASEURL+'city';
                        //$('#frmLocation')[0].reset();
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
    $('select').select2({}).on("change", function (e) {
        $(this).valid()
    });
    
    $.validator.addMethod("alpha", function(value, element) {
    return this.optional(element) || value == value.match(/^[a-zA-Z ]+$/);
    });


});


  $('#country_id').change(function(){
        var countryID = $(this).val();    
        if(countryID){
            $.ajax({
            type:"GET",
            url:BASEURL+"get-state-list?country_id="+countryID,
            success:function(res){
                if(res['0'])
                {
                    $("#state_id").empty();
                    $("#state_id").append('<option>Select State ...</option>');
                    $.each(res['0'],function(key,value){
                    $("#state_id").append('<option value="'+key+'">'+value+'</option>');
                    });
                }
                else
                {
                    $("#state_id").empty();
                }
            }

        });

        }
        else
        {
            $("#state_id").empty();
        }      

    });